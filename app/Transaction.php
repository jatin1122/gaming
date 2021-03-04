<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Maths\PercentageCalculator;

class Transaction extends Model
{
    protected $fillable = [
        'type',
        'amount',
        'commission',
        'game_instance_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDeposits()
    {
        return $this->where('type', 'deposit');
    }

    public function scopeEntryFees()
    {
        return $this->where('type', 'entry_fee');
    }
}