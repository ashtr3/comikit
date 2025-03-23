<?php

namespace App\Http\Requests;

use App\Models\Chapter;
use App\Models\Page;
use App\Services\PatreonService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePageRequest extends FormRequest
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
            'chapter_id' => 'required|exists:chapters,id',
            'page_number' => 'nullable|integer',
            'page_name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('pages')->where(function ($query) {
                    return $query
                        ->where('chapter_id', $this->chapter_id)
                        ->where('page_number', $this->page_number)
                        ->where('page_name', $this->page_name);
                })
            ],
            'page_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'page_description' => 'nullable|string',
            'page_secret' => 'nullable|string',
            'is_cover' => 'required|boolean',
            'is_special' => 'required|boolean',
            'patreon_release_at' => 'required|date',
            'public_release_at' => 'required|date|after_or_equal:patreon_release_at',
        ];
    }

    protected function prepareForValidation(): void
    {
        $chapter_index = Chapter::find($this->chapter_id)->chapter_index;
        
        $max_index = Page::whereHas('chapter', function ($query) use ($chapter_index) {
            $query->where('chapter_index', '<=', $chapter_index);
        })->max('page_index') ?? -1;

        $this->merge([
            'chapter_id' => $this->chapter_id,
            'page_index' => $max_index + 1,
            'page_number' => $this->page_number,
            'page_name' => $this->page_name,
            'page_description' => $this->page_description,
            'page_secret' => $this->page_secret,
            'is_cover' => $this->is_cover ?? false,
            'is_special' => $this->is_special ?? false,
            'patreon_release_at' => $this->patreon_release_at,
            'public_release_at' => $this->public_release_at,
        ]);
    }
}
