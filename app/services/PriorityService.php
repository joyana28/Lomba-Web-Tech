<?php

namespace App\Services;

use App\Models\BloodType;
use App\Models\Donor;
use App\Models\DonorRequest;
use Carbon\Carbon;

class PriorityService
{
    public function evaluate(Donor $donor, DonorRequest $request, ?float $distanceKm): array
    {
        $isCompatible = $this->isCompatible($request->bloodType, $donor->bloodType);
        $isEligible = $isCompatible && $this->isAvailable($donor) && !$this->isInCooldown($donor);

        $score = 0;
        if ($isCompatible) {
            $score += $this->bloodMatchScore($request->bloodType, $donor->bloodType);
            $score += $this->distanceScore($distanceKm);
            $score += $donor->is_available ? 10 : 0;
        }

        return [
            'is_compatible' => $isCompatible,
            'is_eligible' => $isEligible,
            'priority_score' => $score,
            'cooldown_until' => $donor->cooldown?->next_available_date,
        ];
    }

    private function isAvailable(Donor $donor): bool
    {
        return (bool) $donor->is_available;
    }

    private function isInCooldown(Donor $donor): bool
    {
        if (!$donor->cooldown || !$donor->cooldown->is_active) {
            return false;
        }

        return Carbon::parse($donor->cooldown->next_available_date)->isFuture();
    }

    public function isCompatible(BloodType $requestType, BloodType $donorType): bool
    {
        $recipient = $requestType->type . $requestType->rhesus;
        $donor = $donorType->type . $donorType->rhesus;

        $compatibilityMap = [
            'O-' => ['O-'],
            'O+' => ['O+', 'O-'],
            'A-' => ['A-', 'O-'],
            'A+' => ['A+', 'A-', 'O+', 'O-'],
            'B-' => ['B-', 'O-'],
            'B+' => ['B+', 'B-', 'O+', 'O-'],
            'AB-' => ['AB-', 'A-', 'B-', 'O-'],
            'AB+' => ['AB+', 'AB-', 'A+', 'A-', 'B+', 'B-', 'O+', 'O-'],
        ];

        return in_array($donor, $compatibilityMap[$recipient] ?? [], true);
    }

    private function bloodMatchScore(BloodType $requestType, BloodType $donorType): int
    {
        if ($requestType->type === $donorType->type && $requestType->rhesus === $donorType->rhesus) {
            return 60;
        }

        if ($requestType->type === $donorType->type) {
            return 45;
        }

        return 30;
    }

    private function distanceScore(?float $distanceKm): int
    {
        if ($distanceKm === null) {
            return 0;
        }

        return match (true) {
            $distanceKm <= 5 => 30,
            $distanceKm <= 10 => 25,
            $distanceKm <= 25 => 15,
            $distanceKm <= 50 => 5,
            default => 0,
        };
    }
}