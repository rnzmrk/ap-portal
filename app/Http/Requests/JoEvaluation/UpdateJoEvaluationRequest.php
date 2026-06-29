<?php

namespace App\Http\Requests\JoEvaluation;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\JoEvaluationStatusEnum;
use Illuminate\Validation\Rules\Enum;



class UpdateJoEvaluationRequest extends FormRequest
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
            'status' => ['required', new Enum(JoEvaluationStatusEnum::class)],
            'rejection_reason' => ['nullable', 'string'],
            'amount_details' => ['nullable', 'string'],
            'check_no' => ['nullable', 'string'],
            'release_location' => ['nullable', 'string'],
            'evaluation_files' => ['nullable', 'array'],
            'evaluation_files.*' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
        ];
    }
}
