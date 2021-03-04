<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'name' => $this->name,
            'prize' => (float) $this->getPrize(),
            'total_players' => (int) $this->getPlayerCount(),
            'commission_percentage' => (float) $this->getCommissionPercentage(),
            'commission_per_player' => (float) round($this->getCommission(), 2),
            'total_commission' => (float) round($this->getTotalCommission(), 2),
            'entry_fee' => (float) round($this->getEntryFee(), 2),
            'user_can_join' => $request->user() ? $request->user()->getBalance() >= $this->getEntryFee() : null,
        ];
    }
}
