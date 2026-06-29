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
            'dr_no' => ['required', 'string'],
            'grpo' => ['required', 'string'],
            'amount' => ['required', 'numeric'],

            'files' => ['required'],
            'files.*' => [
                'file',
                'mimes:pdf',
                'max:2048',
            ],
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
            'content_length_header' => request()->header('Content-Length'),
            'content_type_header' => request()->header('Content-Type'),
            'request_all' => $this->all(),
            'request_files' => $this->allFiles(),
            'raw_post' => $_POST,
            'raw_files' => $filesInfo,
            'php_ini' => [
                'file_uploads' => ini_get('file_uploads'),
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
                'max_file_uploads' => ini_get('max_file_uploads'),
                'upload_tmp_dir' => ini_get('upload_tmp_dir'),
                'sys_temp_dir' => sys_get_temp_dir(),
                'is_sys_temp_writable' => is_writable(sys_get_temp_dir()),
            ]
        ]);
    }
}
