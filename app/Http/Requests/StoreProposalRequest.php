<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProposalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAgency() || $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'proposed_price' => ['required', 'numeric', 'min:1'],
            'strategy_summary' => ['required', 'string', 'max:4000'],
            'execution_timeline' => ['required', 'string', 'max:255'],
            'relevant_experience' => ['nullable', 'string', 'max:4000'],
            'notes' => ['nullable', 'string', 'max:3000'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:5120', 'mimes:pdf,doc,docx,png,jpg,jpeg'],
        ];
    }
}
