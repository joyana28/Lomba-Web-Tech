<?php

namespace Database\Seeders;

use App\Models\BloodType;
use Illuminate\Database\Seeder;

class BloodTypeSeeder extends Seeder
{
    public function run(): void
    {
        $bloodTypes = [
            ['type' => 'A', 'rhesus' => '+'],
            ['type' => 'A', 'rhesus' => '-'],
            ['type' => 'B', 'rhesus' => '+'],
            ['type' => 'B', 'rhesus' => '-'],
            ['type' => 'AB', 'rhesus' => '+'],
            ['type' => 'AB', 'rhesus' => '-'],
            ['type' => 'O', 'rhesus' => '+'],
            ['type' => 'O', 'rhesus' => '-'],
        ];

        foreach ($bloodTypes as $bloodType) {
            BloodType::updateOrCreate(
                [
                    'type' => $bloodType['type'],
                    'rhesus' => $bloodType['rhesus'],
                ],
                $bloodType
            );
        }
    }
}