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
        protected PriorityService $priorityService,
        protected DistanceService $distanceService
    ) {
    }

    public function run(DonorRequest $donorRequest): Collection
    {
        $donorRequest->loadMissing(['bloodType', 'location']);

        MatchingResult::query()
            ->where('donor_request_id', $donorRequest->id)
            ->delete();

        $donors = Donor::query()
            ->with(['user', 'bloodType', 'location', 'cooldown'])
            ->get();

        $results = collect();

        foreach ($donors as $donor) {
            if (!$donor->location || !$donorRequest->location) {
                continue;
            }

            $distance = $this->distanceService->calculate(
                $donorRequest->location->latitude ?? 0,
                $donorRequest->location->longitude ?? 0,
                $donor->location->latitude ?? 0,
                $donor->location->longitude ?? 0
            );

            $evaluation = $this->priorityService->evaluate($donorRequest, $donor, $distance);

            $match = MatchingResult::create([
                'donor_request_id' => $donorRequest->id,
                'donor_id' => $donor->id,
                'distance_km' => $distance,
                'priority_score' => $evaluation['priority_score'],
                'is_eligible' => $evaluation['is_eligible'],
                'notes' => $evaluation['notes'] ?? null,
            ]);

            $results->push($match);
        }

        $eligibleMatches = MatchingResult::query()
            ->where('donor_request_id', $donorRequest->id)
            ->where('is_eligible', true)
            ->with('donor')
            ->orderByDesc('priority_score')
            ->orderBy('distance_km')
            ->get();

        $topTargets = $eligibleMatches->take(max($donorRequest->quantity * 3, 5));

        foreach ($topTargets as $target) {
            if (!$target->donor || !$target->donor->user_id) {
                continue;
            }

            Notification::create([
                'user_id' => $target->donor->user_id,
                'message' => 'Permintaan donor darah baru: dibutuhkan golongan '
                    . ($donorRequest->bloodType->type ?? '-')
                    . ($donorRequest->bloodType->rhesus ?? '')
                    . ' di ' . ($donorRequest->location->address ?? '-')
                    . '. Segera cek aplikasi DonorHub.',
                'status' => 'sent',
            ]);
        }

        return $eligibleMatches;
    }
}