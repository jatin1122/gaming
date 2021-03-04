<?php

namespace App\Rules;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Rule;
use App\Room;
use App\User;

class UserHasEnoughFunds implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->roomId = $request->get('room_id');
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
        $room = Room::findOrFail($this->roomId);

        try {
            foreach ($value as $userId) {
                $user = User::notBanned()->findOrFail($userId);

                if ($user->getBalance() < $room->getEntryFee()) {
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
        return 'Player does not have enough funds.';
    }
}
