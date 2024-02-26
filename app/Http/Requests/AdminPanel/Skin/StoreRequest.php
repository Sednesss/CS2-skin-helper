<?php

namespace App\Http\Requests\AdminPanel\Skin;

use App\Rules\UniquePatternForGameItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
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
            'description' => [
                'nullable',
                'string',
            ],
            'pattern' => [
                'required',
                'integer',
                'between:1,999',
                new UniquePatternForGameItem,
            ],
            'float' => [
                'required',
                'numeric',
                'between:0,1',
            ],
        ];
    }
}
