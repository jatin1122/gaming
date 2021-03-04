<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameInstanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $room = $this->room;
        $room->setPlayerCount($this->player_count);
        return [
            'id' => $this->id,
            'state' => $this->state,
            'room' => new RoomResource($room),
            'players' => UserResource::collection($this->players),
            'started_at' => $this->created_at,
            'last_activity' => $this->updated_at,
        ];
    }
}
