<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'account_number' => (string) $this->getAccountNumber(),
            'username' => $this->username,
            'profile_image' => url($this->profile_image),
            'games_won' => (int) $this->getTotalGamesWon(),
            'games_played' => (int) $this->getTotalGamesPlayed(),
            'win_percentage' => (int) $this->getWinPercentage(),
            'win_streak' => (int) $this->getWinStreak(),
            'country' => $this->country == 'GB' ? 'UK' : $this->country,
            'county_image' => secure_asset("images/flags/{$this->country}.png")
        ];
    }
}
