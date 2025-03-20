<?php

namespace App\Http\Requests;

use App\Services\PatreonService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateChapterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return PatreonService::isCreator();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'volume_id' => 'required|exists:volumes,id',
            'chapter_number' => 'nullable|integer',
            'chapter_name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('chapters')->where(function ($query) {
                    return $query
                        ->where('volume_id', $this->volume_id)
                        ->where('chapter_number', $this->chapter_number)
                        ->where('chapter_name', $this->chapter_name);
                })->ignore($this->id, 'id')
            ],
            'chapter_description' => 'nullable|string',
        ];
    }
}
