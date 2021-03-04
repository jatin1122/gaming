<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class GameInstance extends Model
{
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function players()
    {
        return $this->belongsToMany(User::class, 'game_instance_players')->withPivot('winner');
    }

    public static function createWithPlayers(Game $game, Room $room, Collection $players)
    {
        $instance = new static;

        $instance->game_id = $game->id;
        $instance->room_id = $room->id;
        $instance->prize = $room->getPrize();
        $instance->commission = $room->getTotalCommission();
        $instance->total = $instance->prize + $instance->commission;
        
        $instance->save();

        foreach ($players as $player) {
            $player->addTransaction('entry_fee', -$room->getEntryFee(), $room->getCommission(), $instance->id);
        }

        $instance->players()->attach($players->map(function ($player) {
            return $player->id;
        })->toArray());

        return $instance->fresh();
    }

    public function cancelGame()
    {
        foreach ($this->players as $player) {
            $player->addTransaction('refund', $this->room->getEntryFee());
        }

        $this->state = 'cancelled';

        $this->save();
    }

    public function endGame(User $winner)
    {
        $winner = $this->players->first(function ($player) use ($winner) {
            return $winner->id == $player->id;
        });

        if (empty($winner)) {
            throw new \RuntimeException('Player does not exist in this game');
        }

        if ($winner->pivot->winner) {
            throw new \RuntimeException('Game already finished');
        }

        $this->players()->updateExistingPivot($winner->id, [
            'winner' => true
        ]);

        $winner->addTransaction('win', $this->room->getPrize(), 0, $this->id);

        $this->state = 'finished';

        $this->save();
    }
}
