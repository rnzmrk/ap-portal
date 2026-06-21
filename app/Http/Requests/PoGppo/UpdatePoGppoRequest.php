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

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if (app()->runningUnitTests()) {
            parent::failedValidation($validator);
        }

        $filesInfo = [];
        if (isset($_FILES['files'])) {
            $filesInfo = $_FILES['files'];
        }

        dd([
            'validation_errors' => $validator->errors()->toArray(),
            'request_all' => $this->all(),
            'request_files' => $this->allFiles(),
            'raw_post' => $_POST,
            'raw_files' => $filesInfo,
            'php_ini' => [
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
                'max_file_uploads' => ini_get('max_file_uploads'),
            ]
        ]);
    }
}
