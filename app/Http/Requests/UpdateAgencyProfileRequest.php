<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAgencyProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAgency() || $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'agency_name' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'website' => ['nullable', 'url', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'about' => ['nullable', 'string', 'max:3000'],
            'years_experience' => ['nullable', 'integer', 'min:0', 'max:60'],
            'portfolio_links' => ['nullable', 'array'],
            'portfolio_links.*' => ['nullable', 'url', 'max:255'],
            'minimum_budget' => ['nullable', 'numeric', 'min:0'],
            'team_size' => ['nullable', 'string', 'max:100'],
            'pricing_style' => ['nullable', 'string', 'max:255'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['exists:services,id'],
            'industry_ids' => ['nullable', 'array'],
            'industry_ids.*' => ['exists:industries,id'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
