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
            ['email' => 'admin@donorhub.com'],
            [
                'name' => 'Admin DonorHub',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        $donorUsers = [
            [
                'name' => 'Budi Donor',
                'email' => 'budi@donorhub.test',
                'address' => 'Balige, Toba',
                'lat' => 2.3330,
                'lng' => 99.0660,
            ],
            [
                'name' => 'Sinta Donor',
                'email' => 'sinta@donorhub.test',
                'address' => 'Porsea, Toba',
                'lat' => 2.1245,
                'lng' => 99.1762,
            ],
        ];

        foreach ($donorUsers as $i => $data) {

            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'donor',
                ]
            );

            $location = Location::create([
                'address' => $data['address'],
                'latitude' => $data['lat'],
                'longitude' => $data['lng'],
            ]);

            $bloodType = BloodType::inRandomOrder()->first();

            Donor::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'blood_type_id' => $bloodType->id,
                    'location_id' => $location->id,
                    'phone' => '0812345678' . $i,
                    'last_donation_date' => now()->subDays(120 + ($i * 30)),
                    'is_available' => true,
                ]
            );
        }

        $requests = [
            [
                'address' => 'RSUD Porsea',
                'lat' => 2.1245,
                'lng' => 99.1762,
                'urgency' => 'high',
            ],
            [
                'address' => 'Puskesmas Balige',
                'lat' => 2.3341,
                'lng' => 99.0671,
                'urgency' => 'medium',
            ],
        ];

        foreach ($requests as $i => $data) {

            $location = Location::create([
                'address' => $data['address'],
                'latitude' => $data['lat'],
                'longitude' => $data['lng'],
            ]);

            $bloodType = BloodType::inRandomOrder()->first();

            DonorRequest::updateOrCreate(
                [
                    'created_by' => $admin->id,
                    'location_id' => $location->id,
                    'blood_type_id' => $bloodType->id,
                ],
                [
                    'quantity' => $i + 1,
                    'urgency' => $data['urgency'],
                    'deadline' => now()->addDays($i + 2),
                    'status' => 'open',
                ]
            );
        }
    }
}