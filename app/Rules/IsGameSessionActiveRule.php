<?php

namespace App\Rules;

use Closure;
use App\Models\GameSession;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class IsGameSessionActiveRule implements ValidationRule
{
    /**
     * Validates that the GameSession exists and hasn't ended.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $gameSession = GameSession::findOrFail($value);
        } catch (ModelNotFoundException $th) {
            $fail('The selected id is invalid.');
            return;
        }

        if ($gameSession->state !== 'Started') {
            $fail('The game session has already ended.');
        }
    }
}
