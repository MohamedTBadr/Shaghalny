<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return $user->hasRole('admin');
        return true; // Allow all users to make this request, adjust as needed
    }


    public function rules(): array
    {
        return [
            'name'=> 'required|string|max:255|unique:job_categories,name' 
        ];

    }
    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(){
        return ['name.required'=> 'The job category name is required.',
                'name.string' => 'The job category name must be a string.',
                'name.max' => 'The job category name may not be greater than 255 characters.',
        ];
    }
}
