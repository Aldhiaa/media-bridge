<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isCompany() || $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'brand_name' => ['nullable', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'website' => ['nullable', 'url', 'max:255'],
            'industry_id' => ['nullable', 'exists:industries,id'],
            'city' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:3000'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
