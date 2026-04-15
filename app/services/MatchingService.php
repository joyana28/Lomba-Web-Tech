<?php

namespace App\Services;

use App\Models\Donor;
use App\Models\DonorRequest;
use Carbon\Carbon;

class PriorityService
{
    public function evaluate(DonorRequest $request, Donor $donor, float $distance): array
    {
        $notes = [];
        $score = 0;
        $isEligible = true;

        if ((int) $donor->is_available !== 1) {
            $isEligible = false;
            $notes[] = 'Donor tidak tersedia';
        }

        if (!$this->isCompatible($request, $donor)) {
            $isEligible = false;
            $notes[] = 'Golongan darah tidak kompatibel';
        } else {
            $score += 50;
            $notes[] = 'Golongan darah kompatibel';
        }

        if ($donor->cooldown && $donor->cooldown->cooldown_until) {
            $cooldownUntil = Carbon::parse($donor->cooldown->cooldown_until);

            if ($cooldownUntil->isFuture()) {
                $isEligible = false;
                $notes[] = 'Masih cooldown sampai ' . $cooldownUntil->format('d M Y');
            }
        }

        if ($distance <= 5) {
            $score += 30;
            $notes[] = 'Radius sangat dekat';
        } elseif ($distance <= 15) {
            $score += 20;
            $notes[] = 'Radius dekat';
        } elseif ($distance <= 30) {
            $score += 10;
            $notes[] = 'Radius menengah';
        } else {
            $notes[] = 'Radius jauh';
        }

        if ($request->urgency === 'high') {
            $score += 10;
        } elseif ($request->urgency === 'medium') {
            $score += 5;
        }

        return [
            'priority_score' => $isEligible ? $score : 0,
            'is_eligible' => $isEligible,
            'notes' => implode(' | ', $notes),
        ];
    }

    public function isCompatible(DonorRequest $request, Donor $donor): bool
    {
        if (!$request->bloodType || !$donor->bloodType) {
            return false;
        }

        $requestType = $request->bloodType->type;
        $requestRhesus = $request->bloodType->rhesus;
        $donorType = $donor->bloodType->type;
        $donorRhesus = $donor->bloodType->rhesus;

        $compatibleTypes = match ($requestType) {
            'O' => ['O'],
            'A' => ['A', 'O'],
            'B' => ['B', 'O'],
            'AB' => ['AB', 'A', 'B', 'O'],
            default => [],
        };

        $compatibleRhesus = match ($requestRhesus) {
            '+' => ['+', '-'],
            '-' => ['-'],
            default => [],
        };

        return in_array($donorType, $compatibleTypes, true)
            && in_array($donorRhesus, $compatibleRhesus, true);
    }
}