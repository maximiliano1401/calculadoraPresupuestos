<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BudgetCalculateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'weeks' => ['required', 'integer', 'min:1'],
            'hours_per_week' => ['required', 'integer', 'min:1'],
            'hourly_rate' => ['required', 'numeric', 'min:0.01'],
            'contingency_percent' => ['required', 'numeric', 'between:10,25'],
            'fixed_costs' => ['nullable', 'array'],
            'fixed_costs.infrastructure' => ['nullable', 'numeric', 'min:0'],
            'fixed_costs.integrations' => ['nullable', 'numeric', 'min:0'],
            'fixed_costs.platform' => ['nullable', 'numeric', 'min:0'],
            'breakdown' => ['required', 'array'],
            'breakdown.analysis' => ['required', 'numeric', 'between:0,100'],
            'breakdown.ux_ui' => ['required', 'numeric', 'between:0,100'],
            'breakdown.complexity' => ['required', 'numeric', 'between:0,100'],
            'breakdown.development' => ['required', 'numeric', 'between:0,100'],
            'breakdown.qa_testing' => ['required', 'numeric', 'between:0,100'],
            'breakdown.project_management' => ['required', 'numeric', 'between:0,100'],
            'breakdown.devops' => ['required', 'numeric', 'between:0,100'],
        ];
    }
}
