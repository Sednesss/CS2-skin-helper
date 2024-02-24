<?php

namespace App\Rules;

use App\Models\Skin;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class OldPatternValueOrUniquePattern implements DataAwareRule, ValidationRule
{
    protected $skinId;

    public function setData(array $data): static
    {
        $this->skinId = $data['skin_id'];

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $existingPattern = Skin::where('id', $this->skinId)->value('pattern');
        if ($existingPattern !== (int)$value && Skin::where('pattern', $value)->exists()) {
            $fail('The pattern must be unique or match the pattern of the selected skin.');
        }
    }
}
