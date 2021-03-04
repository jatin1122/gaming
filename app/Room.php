<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Maths\PercentageCalculator;

class Room extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $playerCount = 2;

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function getPlayerCount(): int
    {
        return $this->playerCount;
    }

    public function setPlayerCount($playerCount)
    {
        $this->playerCount = $playerCount;
    }

    public function getCommissionPercentage(): float
    {
        return $this->commission;
    }

    public function getEntryFee(): float
    {
        return (new PercentageCalculator($this->commission))->add($this->prize / $this->getPlayerCount());
    }

    public function getPrize(): float
    {
        return $this->prize;
    }

    public function getCommission()
    {
        return round($this->getTotalCommission() / $this->getPlayerCount(), 2);
    }

    public function getTotalCommission(): float
    {
        return round(($this->getEntryFee() * $this->getPlayerCount()) - $this->getPrize(), 2);
    }
}
