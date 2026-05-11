<?php

namespace App\Services;

class BudgetCalculatorService
{
    public function __construct(
        private readonly BudgetBreakdownService $breakdownService
    ) {
    }

    public function calculate(array $input): array
    {
        $weeks = (int) $input['weeks'];
        $hoursPerWeek = (int) $input['hours_per_week'];
        $hourlyRate = (float) $input['hourly_rate'];
        $contingencyPercent = (float) $input['contingency_percent'];
        $fixedCosts = $input['fixed_costs'] ?? [];

        $totalHours = $weeks * $hoursPerWeek;
        $baseCost = $totalHours * $hourlyRate;

        $fixedCostsTotal = $this->sumFixedCosts($fixedCosts);
        $netCost = $baseCost + $fixedCostsTotal;

        $breakdownData = $this->breakdownService->normalize($input['breakdown']);
        $breakdown = $this->calculateBreakdownAmounts($breakdownData['normalized'], $baseCost);

        $contingencyAmount = $netCost * ($contingencyPercent / 100);
        $grossCost = $netCost + $contingencyAmount;

        return [
            'input' => [
                'weeks' => $weeks,
                'hours_per_week' => $hoursPerWeek,
                'hourly_rate' => $hourlyRate,
                'contingency_percent' => $contingencyPercent,
                'fixed_costs' => [
                    'infrastructure' => (float) ($fixedCosts['infrastructure'] ?? 0),
                    'integrations' => (float) ($fixedCosts['integrations'] ?? 0),
                    'platform' => (float) ($fixedCosts['platform'] ?? 0),
                ],
                'breakdown_original' => $breakdownData['original'],
                'breakdown_normalized' => $breakdownData['normalized'],
                'breakdown_sum_original' => $breakdownData['sum_original'],
                'breakdown_sum_normalized' => $breakdownData['sum_normalized'],
            ],
            'totals' => [
                'total_hours' => $totalHours,
                'base_cost' => round($baseCost, 2),
                'fixed_costs_total' => round($fixedCostsTotal, 2),
                'net_cost' => round($netCost, 2),
                'contingency_amount' => round($contingencyAmount, 2),
                'gross_cost' => round($grossCost, 2),
            ],
            'breakdown' => $breakdown,
            'notes' => [
                'Breakdown percentages are normalized to 100%.',
                'Contingency is applied at the end over net_cost (base_cost + fixed_costs_total).',
            ],
        ];
    }

    private function sumFixedCosts(array $fixedCosts): float
    {
        $total = 0;

        foreach (['infrastructure', 'integrations', 'platform'] as $key) {
            $total += (float) ($fixedCosts[$key] ?? 0);
        }

        return $total;
    }

    private function calculateBreakdownAmounts(array $normalized, float $baseCost): array
    {
        $items = [];

        foreach ($normalized as $key => $percent) {
            $items[] = [
                'key' => $key,
                'percent' => $percent,
                'amount' => round(($percent / 100) * $baseCost, 2),
            ];
        }

        return $items;
    }
}
