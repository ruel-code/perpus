<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLoanStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'actual_return_date' => 'nullable|date',
            'status' => 'required|in:dikembalikan',
            'condition' => 'nullable|in:baik,rusak,hilang',
            'condition_notes' => 'nullable|string',
        ];
    }
}
