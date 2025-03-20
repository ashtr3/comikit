<?php

namespace App\Http\Requests;

use App\Services\PatreonService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVolumeRequest extends FormRequest
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
                })->ignore($this->id, 'id')
            ],
            'volume_description' => 'nullable|string',
        ];
    }
}
