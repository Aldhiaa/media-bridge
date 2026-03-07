<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isCompany() || $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'industry_id' => ['nullable', 'exists:industries,id'],
            'objective' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'target_audience' => ['required', 'string', 'max:2000'],
            'channels' => ['required', 'array', 'min:1'],
            'channels.*' => ['string', 'max:50'],
            'required_deliverables' => ['required', 'string', 'max:3000'],
            'budget' => ['required', 'numeric', 'min:1'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'proposal_deadline' => ['required', 'date', 'after_or_equal:today'],
            'allow_proposal_updates' => ['sometimes', 'boolean'],
            'status' => ['nullable', 'in:draft,published,receiving_proposals'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:5120', 'mimes:pdf,doc,docx,png,jpg,jpeg'],
        ];
    }
}
