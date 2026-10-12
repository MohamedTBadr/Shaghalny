<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobCategoryUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
'name' => "required|string|max:255|unique:job_categories,name," . $this->route('job_category'),  
      ];
    }
    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array{
        return [
            'name.required' => 'The job category name is required.',
            'name.string' => 'The job category name must be a string.',
            'name.max' => 'The job category name may not be greater than 255 characters.',
            'name.unique' => 'The job category name has already been taken.',
        ];
    }
}
