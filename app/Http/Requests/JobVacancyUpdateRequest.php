<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyUpdateRequest extends FormRequest
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
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string|',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric',
            'type' => 'required|string|in:Full-Time,Contract,Remote,Hybrid',
            'Category_id' => 'required|exists:job_categories,id',
            'status' => 'sometimes|string|in:draft,published',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:today',
        ];

        if (auth()->user()?->role === 'company_owner') {
            $rules['Company_id'] = 'nullable|exists:companies,id';
        } else {
            $rules['Company_id'] = 'required|exists:companies,id';
        }

        return $rules;
    }
}
