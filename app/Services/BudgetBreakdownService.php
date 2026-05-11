<?php

namespace App\Services;

class BudgetBreakdownService
{
    public function normalize(array $breakdown): array
    {
        $sum = array_sum($breakdown);

        if ($sum <= 0) {
            return [
                'original' => $breakdown,
                'normalized' => $breakdown,
                'sum_original' => $sum,
                'sum_normalized' => $sum,
            ];
        }

        $normalized = [];
        foreach ($breakdown as $key => $value) {
            $normalized[$key] = round(($value / $sum) * 100, 2);
        }

        return [
            'original' => $breakdown,
            'normalized' => $normalized,
            'sum_original' => $sum,
            'sum_normalized' => round(array_sum($normalized), 2),
        ];
    }
}
