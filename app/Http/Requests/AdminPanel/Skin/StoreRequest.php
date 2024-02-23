<?php

namespace App\Http\Requests\AdminPanel\Skin;

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
                'string',
                'exists:App\Models\GameItem,id',
            ],
            'description' => [
                'required',
                'string',
            ],
            'pattern' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^\d{1,3}$/', $value)) {
                        $fail($attribute.' must be an integer between 1 and 999.');
                    }
                },
            ],
            'float' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^0*\.0*[1-9]\d*$|^0*\.0*[1-9]$|^0*\.0*[1-9]\d{2}$|^1\.0*$|^1$/', $value)) {
                        $fail($attribute.' must be a floating point number between 0 and 1.');
                    }
                },
            ],
        ];
    }
}
