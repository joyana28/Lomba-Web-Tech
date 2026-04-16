<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\DonorRequest;
use App\Models\MatchingResult;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DonorResponseController extends Controller
{
    public function store(DonorRequest $request)
    {
        $user = Auth::user();

        if ($request->status === 'closed') {
            return redirect()
                ->route('requests.show', $request->id)
                ->with('error', 'Kebutuhan donor ini sudah ditutup.');
        }

        $donor = Donor::query()
            ->where('user_id', $user->id)
            ->with(['bloodType', 'location', 'cooldown'])
            ->first();

        if (!$donor) {
            return redirect()
                ->route('donor.profile')
                ->with('error', 'Lengkapi profil donor terlebih dahulu sebelum merespons.');
        }

        if ((int) $donor->is_available !== 1) {
            return redirect()
                ->route('requests.show', $request->id)
                ->with('error', 'Status donor Anda sedang tidak tersedia.');
        }

        if ($donor->cooldown && $donor->cooldown->cooldown_until) {
            $cooldownUntil = Carbon::parse($donor->cooldown->cooldown_until);

            if ($cooldownUntil->isFuture()) {
                return redirect()
                    ->route('requests.show', $request->id)
                    ->with('error', 'Anda masih dalam masa cooldown sampai ' . $cooldownUntil->format('d M Y') . '.');
            }
        }

        $existingResult = MatchingResult::query()
            ->where('donor_request_id', $request->id)
            ->where('donor_id', $donor->id)
            ->first();

        $responseNote = 'RESPON_DONOR: donor siap membantu.';

        if ($existingResult) {
            if (Str::contains((string) $existingResult->notes, 'RESPON_DONOR:')) {
                return redirect()
                    ->route('requests.show', $request->id)
                    ->with('error', 'Anda sudah pernah merespons kebutuhan donor ini.');
            }

            $existingResult->update([
                'notes' => trim(($existingResult->notes ? $existingResult->notes . ' | ' : '') . $responseNote),
            ]);

            return redirect()
                ->route('requests.show', $request->id)
                ->with('success', 'Respons donor berhasil dikirim.');
        }

        MatchingResult::create([
            'donor_request_id' => $request->id,
            'donor_id' => $donor->id,
            'distance_km' => 0,
            'priority_score' => 0,
            'is_eligible' => true,
            'notes' => $responseNote,
        ]);

        return redirect()
            ->route('requests.show', $request->id)
            ->with('success', 'Respons donor berhasil dikirim.');
    }
}