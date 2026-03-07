<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'body' => ['required_without:attachment', 'nullable', 'string', 'max:5000'],
            'attachment' => ['nullable', 'file', 'max:5120', 'mimes:pdf,doc,docx,png,jpg,jpeg'],
        ];
    }
}
