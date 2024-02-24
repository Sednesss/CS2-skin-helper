<?php

namespace App\Http\Requests\API\Skin;

use App\Rules\OldPatternValueOrUniquePattern;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
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
            'skin_id' => [
                'required',
                'integer',
                'between:1,999',
                'exists:App\Models\Skin,id',
            ],
            'pattern' => [
                'required',
                'integer',
                'between:1,999',
                new OldPatternValueOrUniquePattern
            ],
            'float' => [
                'required',
                'numeric',
                'between:0,1',
            ],
        ];
    }
}
