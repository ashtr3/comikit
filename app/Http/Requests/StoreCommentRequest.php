<?php

namespace App\Http\Requests;

use App\Services\PatreonService;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return PatreonService::hasAuthenticated();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'parent_id' => 'nullable|integer|exists:comments,id',
            'body' => 'required|string|min:1|max:500',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'parent_id' => $this->parent_id,
            'body' => $this->body,
            'patron_id' => session('patreon.id'),
            'patron_name' => session('patreon.name'),
            'patron_email' => session('patreon.email'),
            'patron_avatar' => session('patreon.avatar'),
            'is_creator' => session('patreon.is_creator'),
            'has_pledged' => session('patreon.is_pledged'),
        ]);
    }
}
