<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ValidUser implements Rule
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
                User::notBanned()->findOrFail($userId);
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
        return 'One or more players do not exist or are banned.';
    }
}
