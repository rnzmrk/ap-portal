<?php

namespace App\Http\Requests\PoGppo;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PoGppoStatusEnum;
use Illuminate\Validation\Rules\Enum;

class UpdatePoGppoRequest extends FormRequest
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
        if ($this->user()->role === 'supplier') {
            return [
                'invoice_no' => ['required', 'string'],
                'po_no' => ['required', 'string'],
                'amount' => ['required', 'string'],
                'files.*' => ['nullable', 'file', 'mimes:pdf,jpg,png,doc,docx'],
                'removed_files' => ['nullable', 'string'],
            ];
        }

        return [
            'status' => ['required', new Enum(PoGppoStatusEnum::class)],
            'return_reason' => ['nullable', 'string'],
            'payment_details' => ['nullable', 'string'],
            'check_no' => ['nullable', 'string'],
            'release_location' => ['nullable', 'string'],
        ];
    }
}
