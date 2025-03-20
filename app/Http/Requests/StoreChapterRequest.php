<?php

namespace App\Http\Requests;

use App\Models\Chapter;
use App\Models\Volume;
use App\Services\PatreonService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreChapterRequest extends FormRequest
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
                })
            ],
            'chapter_description' => 'nullable|string',
        ];
    }

    protected function prepareForValidation(): void
    {
        $volume_index = Volume::find($this->volume_id)->volume_index;
        
        $max_index = Chapter::whereHas('volume', function ($query) use ($volume_index) {
            $query->where('volume_index', '<=', $volume_index);
        })->max('chapter_index') ?? -1;

        $this->merge([
            'volume_id' => $this->volume_id,
            'chapter_index' => $max_index + 1,
            'chapter_number' => $this->chapter_number,
            'chapter_name' => $this->chapter_name,
            'chapter_description' => $this->chapter_description,
        ]);
    }
}
