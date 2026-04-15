<?php

namespace Database\Seeders;

use App\Models\BloodType;
use App\Models\Donor;
use App\Models\DonorRequest;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@donorhub.test'],
            [
                'name' => 'Admin DonorHub',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $donorUsers = [
            ['name' => 'Budi Donor', 'email' => 'budi@donorhub.test'],
            ['name' => 'Sinta Donor', 'email' => 'sinta@donorhub.test'],
            ['name' => 'Rina Donor', 'email' => 'rina@donorhub.test'],
            ['name' => 'Andi Donor', 'email' => 'andi@donorhub.test'],
            ['name' => 'Dewi Donor', 'email' => 'dewi@donorhub.test'],
        ];

        foreach ($donorUsers as $index => $donorUser) {
            $user = User::updateOrCreate(
                ['email' => $donorUser['email']],
                [
                    'name' => $donorUser['name'],
                    'password' => Hash::make('password'),
                    'role' => 'donor',
                ]
            );

            $location = Location::create([
                'address' => 'Lokasi Donor ' . ($index + 1) . ', Balige, Toba',
                'latitude' => 2.3330 + ($index * 0.01),
                'longitude' => 99.0660 + ($index * 0.01),
            ]);

            $bloodType = BloodType::query()->inRandomOrder()->first();

            Donor::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'blood_type_id' => $bloodType?->id,
                    'location_id' => $location->id,
                    'phone' => '08123456789' . $index,
                    'last_donation_date' => now()->subDays(rand(100, 300))->format('Y-m-d'),
                    'is_available' => rand(0, 1),
                ]
            );
        }

        $requestLocations = [
            [
                'address' => 'RSUD Porsea, Toba',
                'latitude' => 2.1245,
                'longitude' => 99.1762,
            ],
            [
                'address' => 'Puskesmas Balige, Toba',
                'latitude' => 2.3341,
                'longitude' => 99.0671,
            ],
            [
                'address' => 'Klinik Laguboti, Toba',
                'latitude' => 2.2574,
                'longitude' => 99.1022,
            ],
        ];

        foreach ($requestLocations as $i => $requestLocation) {
            $location = Location::create([
                'address' => $requestLocation['address'],
                'latitude' => $requestLocation['latitude'],
                'longitude' => $requestLocation['longitude'],
            ]);

            $bloodType = BloodType::query()->inRandomOrder()->first();

            DonorRequest::updateOrCreate(
                [
                    'created_by' => $admin->id,
                    'location_id' => $location->id,
                    'blood_type_id' => $bloodType?->id,
                    'quantity' => $i + 1,
                ],
                [
                    'urgency' => $i === 0 ? 'high' : ($i === 1 ? 'medium' : 'low'),
                    'deadline' => now()->addDays($i + 1),
                    'status' => $i === 2 ? 'closed' : 'open',
                ]
            );
        }
    }
}