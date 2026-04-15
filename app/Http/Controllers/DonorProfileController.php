<?php

namespace App\Http\Controllers;

use App\Models\BloodType;
use App\Models\Donor;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonorProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $donor = Donor::query()
            ->with(['bloodType', 'location'])
            ->where('user_id', $user->id)
            ->first();

        $bloodTypes = BloodType::orderBy('type')->orderBy('rhesus')->get();

        return view('donor.profile', compact('donor', 'bloodTypes'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'blood_type_id' => ['required', 'exists:blood_types,id'],
            'phone' => ['required', 'string', 'max:30'],
            'last_donation_date' => ['nullable', 'date', 'before_or_equal:today'],
            'address' => ['required', 'string', 'max:500'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'is_available' => ['nullable', 'in:0,1'],
        ]);

        $donor = Donor::query()->where('user_id', $user->id)->first();

        if ($donor && $donor->location_id) {
            $location = Location::find($donor->location_id);

            if ($location) {
                $location->update([
                    'address' => $validated['address'],
                    'latitude' => $validated['latitude'],
                    'longitude' => $validated['longitude'],
                ]);
            } else {
                $location = Location::create([
                    'address' => $validated['address'],
                    'latitude' => $validated['latitude'],
                    'longitude' => $validated['longitude'],
                ]);
            }
        } else {
            $location = Location::create([
                'address' => $validated['address'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]);
        }

        Donor::updateOrCreate(
            ['user_id' => $user->id],
            [
                'blood_type_id' => $validated['blood_type_id'],
                'location_id' => $location->id,
                'phone' => $validated['phone'],
                'last_donation_date' => $validated['last_donation_date'] ?? null,
                'is_available' => $validated['is_available'] ?? 0,
            ]
        );

        return redirect()
            ->route('donor.profile')
            ->with('success', 'Profil donor berhasil diperbarui.');
    }
}