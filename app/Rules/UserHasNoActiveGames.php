<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class UserHasNoActiveGames implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            foreach ($value as $userId) {
                $user = User::notBanned()->findOrFail($userId);

                if ($user->getActiveGamesCount() > 0) {
                    return false;
                }
            }

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'One or more players already have an active game in progress.';
    }
}
