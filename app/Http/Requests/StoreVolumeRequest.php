<?php

namespace App\Http\Requests;

use App\Models\Volume;
use App\Services\PatreonService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVolumeRequest extends FormRequest
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
            'volume_number' => 'nullable|integer',
            'volume_name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('volumes')->where(function ($query) {
                    return $query
                        ->where('volume_number', $this->volume_number)
                        ->where('volume_name', $this->volume_name);
                })
            ],
            'volume_description' => 'nullable|string',
        ];
    }

    protected function prepareForValidation(): void
    {
        $max_index = Volume::max('volume_index') ?? -1;

        $this->merge([
            'volume_index' => $max_index + 1,
            'volume_number' => $this->volume_number,
            'volume_name' => $this->volume_name,
            'volume_description' => $this->volume_description,
        ]);
    }
}
