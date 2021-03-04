<?php

namespace App\Policies;

use App\User;
use App\GameInstance;
use Illuminate\Auth\Access\HandlesAuthorization;

class GameInstancePolicy
{
    use HandlesAuthorization;

    public function attachAnyUser(User $user, GameInstance $gameInstance)
    {
        return false;
    }

    public function detachAnyUser(User $user, GameInstance $gameInstance)
    {
        return false;
    }

    /**
     * Determine whether the user can view the game instance.
     *
     * @param  \App\User  $user
     * @param  \App\GameInstance  $gameInstance
     * @return mixed
     */
    public function view(User $user, GameInstance $gameInstance)
    {
        return true;
    }

    /**
     * Determine whether the user can create game instances.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the game instance.
     *
     * @param  \App\User  $user
     * @param  \App\GameInstance  $gameInstance
     * @return mixed
     */
    public function update(User $user, GameInstance $gameInstance)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the game instance.
     *
     * @param  \App\User  $user
     * @param  \App\GameInstance  $gameInstance
     * @return mixed
     */
    public function delete(User $user, GameInstance $gameInstance)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the game instance.
     *
     * @param  \App\User  $user
     * @param  \App\GameInstance  $gameInstance
     * @return mixed
     */
    public function restore(User $user, GameInstance $gameInstance)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the game instance.
     *
     * @param  \App\User  $user
     * @param  \App\GameInstance  $gameInstance
     * @return mixed
     */
    public function forceDelete(User $user, GameInstance $gameInstance)
    {
        return false;
    }
}
