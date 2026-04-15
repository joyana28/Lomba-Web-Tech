<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\DonorRequest;
use App\Models\MatchingResult;
use Illuminate\Support\Facades\Auth;

class DonorResponseController extends Controller
{
    public function store(DonorRequest $request)
    {
        $user = Auth::user();

        $donor = Donor::where('user_id', $user->id)->first();

        if (!$donor) {
            return back()->with('error', 'Lengkapi profil donor terlebih dahulu.');
        }

        $already = MatchingResult::where('donor_request_id', $request->id)
            ->where('donor_id', $donor->id)
            ->exists();

        if ($already) {
            return back()->with('error', 'Kamu sudah mendaftar.');
        }

        MatchingResult::create([
            'donor_request_id' => $request->id,
            'donor_id' => $donor->id,
            'distance_km' => 0,
            'priority_score' => 0,
            'is_eligible' => true,
        ]);

        return back()->with('success', 'Berhasil mendaftar sebagai donor!');
    }
}