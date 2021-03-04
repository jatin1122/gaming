<?php

namespace App\Nova\Metrics;

use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;
use App\GameInstance;
use App\Room;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoomBreakdown extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->sum($request, GameInstance::class, 'commission', 'room_id')
            ->label(function ($roomId) {
                return Room::findOrFail($roomId)->name;
                try {
                    return Room::findOrFail($roomId)->name;
                } catch (ModelNotFoundException $e) {
                    return 'Other';
                }
            });
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
        return 'room-breakdown';
    }
}
