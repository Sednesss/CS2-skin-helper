<?php

namespace App\Rules;

use App\Models\Skin;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class UniquePatternForGameItem implements DataAwareRule, ValidationRule
{
    protected $gameItemId;

    public function setData(array $data): static
    {
        $this->gameItemId = $data['game_item_id'] ?? null;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($this->gameItemId) === false) {
            $existingPatternSkins = Skin::where('game_item_id', $this->gameItemId)
                ->where('pattern', $value)
                ->exists();

            if ($existingPatternSkins) {
                $fail('The pattern must be unique or match the pattern of the selected skin.');
            }
        }
    }
}
