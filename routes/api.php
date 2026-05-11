<?php

use App\Http\Controllers\BudgetCalculatorController;
use Illuminate\Support\Facades\Route;

Route::post('budget/calculate', [BudgetCalculatorController::class, 'calculate']);
