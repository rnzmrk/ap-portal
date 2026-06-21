<?php

namespace App\Http\Requests\PoGppo;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePoGppoRequest extends FormRequest
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
                'po_no' => ['required', 'string'],
                'amount' => ['required', 'numeric'],

                'files' => ['required', 'array'],
                'files.*' => [
                    'file',
                    'mimes:pdf,jpg,jpeg,png,doc,docx',
                    'max:10240'
                ],
            ];
        }
}
