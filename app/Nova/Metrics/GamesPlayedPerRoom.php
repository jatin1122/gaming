<?php

namespace App\Nova\Metrics;

use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Trend;
use App\Room;
use App\GameInstance;

class GamesPlayedPerRoom extends Trend
{
    protected $room;

    public function __construct(Room $room)
    {
        parent::__construct();

        $this->room = $room;
        $this->name = $room->name;
    }

    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->countByDays(
            $request, 
            GameInstance::where('game_id', '=', $request->resourceId)->where('room_id', '=', $this->room->id)
        )->showLatestValue()->suffix('games');
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            30 => '30 Days',
            60 => '60 Days',
            90 => '90 Days',
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'games-played-per-room-'.$this->room->id;
    }
}
