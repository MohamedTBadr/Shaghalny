<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;



class CompanyUpdateRequest extends FormRequest
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
        $companyId = $this->route('company') ?? optional(auth()->user()->company)->id;
        $ownerId = optional(Company::find($companyId))->Owner_id;

        return [
            'name' => 'bail|required|string|max:255|unique:companies,name,' . $companyId,
            'address' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'Owner_Name' => 'required|string|max:255',
            'Owner_Email' => 'nullable|email|max:255|unique:users,email,' . $ownerId,
            'Owner_Password' => 'nullable|string|min:4',
        ];
    }
 public function messages(): array
    {
        return [
            'name.required' => 'The company name is required.',
            'address.required' => 'The company address is required.',
            'industry.required' => 'The industry field is required.',
            'website.url' => 'The website must be a valid URL.',
            'Owner_Name.required' => 'The owner name is required.',
            'Owner_Email.email' => 'The owner email must be a valid email address.',
        ];
    }

}
