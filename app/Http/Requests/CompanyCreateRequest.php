<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
{
    
    public function rules(): array
    {
        return [
            //
            'name' => 'required|string|max:255||unique:companies,name',
            'address' => 'required|string|max:255',
            'industry' => 'required|string',
            'website' => 'nullable|url',
            'Owner_Name'=> 'required|string',
            'Owner_Email'=> 'required|email|unique:users,email',
            'Owner_Password'=> 'required|string',
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
            'Owner_Email.required' => 'The owner email is required.',
            'Owner_Email.email' => 'The owner email must be a valid email address.',
            'Owner_Password.required' => 'The owner password is required.',
        ];
    }
}
