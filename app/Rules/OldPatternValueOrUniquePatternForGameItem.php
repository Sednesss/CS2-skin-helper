<?php

namespace App\Rules;

use App\Models\Skin;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class OldPatternValueOrUniquePatternForGameItem implements DataAwareRule, ValidationRule
{
    protected $skinId;

    public function setData(array $data): static
    {
        $this->skinId = $data['skin_id'] ?? null;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($this->skinId) === false) {
            $existingSkin = Skin::find($this->skinId);
            $existingGameItemId = $existingSkin->game_item_id;
            
            $existingPatternSkins = Skin::where('game_item_id', $existingGameItemId)
                ->where('pattern', $value)
                ->where('id', '!=', $this->skinId)
                ->exists();

            if ($existingPatternSkins) {
                $fail('The pattern must be unique or match the pattern of the selected skin.');
            }
        }
    }
}
