<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\BloodType;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonorProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $donor = Donor::with(['bloodType', 'location'])
            ->where('user_id', $user->id)
            ->first();

        $bloodTypes = BloodType::orderBy('type')->orderBy('rhesus')->get();

        if ($request->query('edit') === 'true') {
            return view('donor.edit-profile', compact('donor', 'bloodTypes'));
        }

        return view('donor.profile', compact('donor', 'bloodTypes'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'blood_type_id' => ['required', 'exists:blood_types,id'],
            'phone' => ['required', 'string', 'max:20'],
            'last_donation_date' => ['nullable', 'date'],
            'address' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        $location = Location::create([
            'address' => $validated['address'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        Donor::updateOrCreate(
            ['user_id' => $user->id],
            [
                'blood_type_id' => $validated['blood_type_id'],
                'location_id' => $location->id,
                'phone' => $validated['phone'],
                'last_donation_date' => $validated['last_donation_date'],
                'is_available' => true,
            ]
        );

        return redirect()->route('donor.profile')->with('success', 'Profil berhasil diperbarui');
    }
}