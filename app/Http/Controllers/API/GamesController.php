<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\UserHasEnoughFunds;
use App\Rules\ValidUser;
use App\Room;
use App\User;
use App\Game;
use App\GameInstance;
use App\Http\Resources\CurrentUserResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\GameResource;
use App\Http\Resources\GameInstanceResource;
use App\Http\Resources\UserResource;
use App\Rules\UniquePlayers;
use App\Rules\UserHasNoActiveGames;

class GamesController extends Controller
{
    public function createGameInstance($gameId, Request $request)
    {
        // Check the users have enough funds
        // If they do, add a transaction to take their money
        // Create a game instance

        $game = Game::findOrFail($gameId);

        $room = $game->rooms()->findOrFail(
            $request->get('room_id')
        );
        $room->setPlayerCount(count($request->players));
        $players = $room->getPlayerCount();
        $this->validate($request, [
            'players' => ['required', 'array', "min:2", "max:4", new ValidUser, new UniquePlayers, new UserHasEnoughFunds($request)],
            'room_id' => ['required', 'exists:rooms,id']
        ]);

        $players = User::findOrFail(
            $request->get('players')
        );

        // Cancel and currently active games for each player
        foreach ($players as $player) {
            if ($activeGame = $player->getActiveGame()) {
                $activeGame->cancelGame();
            }
        }

        $instance = GameInstance::createWithPlayers($game, $room, $players);

        return new GameInstanceResource($instance);
    }

    public function getGame($gameId)
    {
        return new GameResource(
            Game::findOrFail($gameId)
        );
    }

    public function getCurrentUser($gameId, Request $request)
    {
        $user = $request->user();

        $user->setActiveGame(
            Game::findOrFail($gameId)
        );

        return new CurrentUserResource($user);
    }

    public function getUser($gameId, $userId)
    {
        $user = User::findOrFail($userId);
        $user->setActiveGame(
            Game::findOrFail($gameId)
        );

        return new UserResource($user);
    }

    public function updateInstance($gameId, $gameInstanceId, Request $request)
    {
        $gameInstance = GameInstance::where('state', '=', 'in_progress')->where('game_id', '=', $gameId)->findOrFail($gameInstanceId);

        $gameInstance->state = 'finished';

        $gameInstance->save();

        switch ($request->get('action')) {
            case 'end':
                $gameInstance->endGame(User::findOrFail(
                    $request->get('winner')
                ));

                return new GameInstanceResource($gameInstance);
                break;

            case 'cancel':
                $gameInstance->cancelGame();

                return new GameInstanceResource($gameInstance);

                break;

            default:
                throw new \InvalidArgumentException('Invalid action specified');
                break;
        }
    }
}
