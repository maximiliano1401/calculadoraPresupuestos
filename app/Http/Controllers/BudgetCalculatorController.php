<?php

namespace App\Http\Controllers;

use App\Http\Requests\BudgetCalculateRequest;
use App\Services\BudgetCalculatorService;
use Illuminate\Http\JsonResponse;

class BudgetCalculatorController extends Controller
{
    public function __construct(
        private readonly BudgetCalculatorService $calculator
    ) {
    }

    public function calculate(BudgetCalculateRequest $request): JsonResponse
    {
        $result = $this->calculator->calculate($request->validated());

        return response()->json($result);
    }
}
