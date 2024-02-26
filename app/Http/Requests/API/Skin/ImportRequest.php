<?php

namespace App\Http\Requests\API\Skin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class ImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'game_item_id' => [
                'required',
                'integer',
                'exists:App\Models\GameItem,id',
            ],
            'type' => [
                'required',
                'string',
                'in:rewrite,addition',
            ],
            'file' => [
                'required',
                'file',
                'max:20480',
                'mimes:xlsx',
            ],
        ];
    }
    
    public function messages(): array
    {
        return [
            'file.max' => 'The file size should not exceed 20MB.',
            'file.mimes' => 'The file must be a type of xlsx.',
        ];
    }
}
