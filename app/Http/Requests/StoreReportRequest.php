<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:user,campaign,proposal,other'],
            'subject' => ['required', 'string', 'max:255'],
            'details' => ['required', 'string', 'max:3000'],
            'reported_user_id' => ['nullable', 'exists:users,id'],
            'campaign_id' => ['nullable', 'exists:campaigns,id'],
            'proposal_id' => ['nullable', 'exists:proposals,id'],
        ];
    }
}
