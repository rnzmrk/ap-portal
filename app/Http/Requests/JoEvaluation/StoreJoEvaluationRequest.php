<?php

namespace App\Http\Requests\JoEvaluation;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreJoEvaluationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'invoice_no' => ['required', 'string'],
            'accomplishment_no' => ['required', 'string'],
            'jo_reference' => ['required', 'string'],
            'dr_no' => ['required', 'string'],
            'amount' => ['required', 'string'],
            'files' => ['required'],
            'files.*' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
        ];
    }
}
