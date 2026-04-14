<?php

namespace App\Services;

use App\Models\Donor;
use App\Models\DonorRequest;
use App\Models\MatchingResult;
use App\Models\Notification;
use Illuminate\Support\Collection;

class MatchingService
{
    public function __construct(
        private DistanceService $distanceService,
        private PriorityService $priorityService,
    ) {
    }

    public function run(DonorRequest $request): Collection
    {
        $request->loadMissing(['bloodType', 'location']);

        $donors = Donor::query()
            ->with(['user', 'bloodType', 'location', 'cooldown'])
            ->get();

        $ranked = $donors
            ->map(function (Donor $donor) use ($request) {
                $distanceKm = null;

                if ($donor->location && $request->location) {
                    $distanceKm = $this->distanceService->calculateKm(
                        (float) $request->location->latitude,
                        (float) $request->location->longitude,
                        (float) $donor->location->latitude,
                        (float) $donor->location->longitude,
                    );
                }

                $evaluation = $this->priorityService->evaluate($donor, $request, $distanceKm);

                if (!$evaluation['is_compatible']) {
                    return null;
                }

                return [
                    'donor' => $donor,
                    'distance_km' => $distanceKm,
                    'priority_score' => $evaluation['priority_score'],
                    'is_eligible' => $evaluation['is_eligible'],
                ];
            })
            ->filter()
            ->sortByDesc(function (array $row) {
                $distancePenalty = (int) round(($row['distance_km'] ?? 9999) * 10);

                return ($row['is_eligible'] ? 100000 : 0)
                    + ((int) round($row['priority_score']) * 100)
                    - $distancePenalty;
            })
            ->values();

        $request->matchingResults()->delete();

        foreach ($ranked as $row) {
            MatchingResult::create([
                'donor_request_id' => $request->id,
                'donor_id' => $row['donor']->id,
                'distance_km' => $row['distance_km'],
                'priority_score' => $row['priority_score'],
                'is_eligible' => $row['is_eligible'],
            ]);
        }

        $this->createNotifications($request, $ranked);

        $request->update([
            'status' => $ranked->where('is_eligible', true)->isNotEmpty() ? 'in_progress' : 'open',
        ]);

        return $request->matchingResults()
            ->with(['donor.user', 'donor.bloodType', 'donor.location', 'donor.cooldown'])
            ->orderByDesc('is_eligible')
            ->orderByDesc('priority_score')
            ->orderBy('distance_km')
            ->get();
    }

    private function createNotifications(DonorRequest $request, Collection $ranked): void
    {
        $request->loadMissing(['bloodType', 'location']);

        Notification::where('donor_request_id', $request->id)->delete();

        $limit = max($request->quantity * 3, 5);

        $topDonors = $ranked
            ->where('is_eligible', true)
            ->take($limit);

        foreach ($topDonors as $candidate) {
            Notification::create([
                'user_id' => $candidate['donor']->user_id,
                'donor_request_id' => $request->id,
                'message' => sprintf(
                    'Permintaan donor %s%s di %s sebelum %s.',
                    $request->bloodType->type,
                    $request->bloodType->rhesus,
                    $request->location->address ?? 'lokasi tidak tersedia',
                    $request->deadline->format('d M Y H:i')
                ),
                'status' => 'sent',
            ]);
        }
    }
}