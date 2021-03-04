<?php

namespace App;

use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'email', 'password', 'first_name', 'last_name', 'username', 'dob', 'country', 'profile_image', 'countryCode', 'phone', 'is_phone_verified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    protected $dates = [
        'funds_locked_at'
    ];

    protected $activeGame = null;

    public function setActiveGame(Game $game)
    {
        $this->activeGame = $game;
    }

    public function gameInstances()
    {
        return $this->belongsToMany(GameInstance::class, 'game_instance_players');
    }

    public function getActiveGame()
    {
        return $this->gameInstances()->where('state', '=', 'in_progress')->first();
    }

    public function getActiveGamesCount(): int
    {
        return $this->gameInstances()->where('state', '=', 'in_progress')->count();
    }

    public function getAccountNumber(): string
    {
        $hash = hash_pbkdf2('sha256', $this->id, 'GenieGaming', 5, 8);

        return strtoupper(substr($hash, 0, 3) . '/' . substr($hash, 3));
    }

    public function scopeNotBanned($query)
    {
        return $query->whereNull('banned');
    }

    public function hasFullBan(): bool
    {
        return $this->banned == 'F';
    }

    public function isBanned(): bool
    {
        return $this->banned != null;
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getPhoneNumberAttribute($value)
    {
        return "+{$this->countryCode}{$this->phone}";
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'user_groups');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function games()
    {
        return $this->belongsToMany(GameInstance::class, 'game_instance_players')->withPivot('winner');
    }

    public function getTotalEntryFees()
    {
        return $this->getTotalFundsByType('entry_fee');
    }

    public function getTotalWinnings()
    {
        return $this->getTotalFundsByType('winnings');
    }

    public function getTotalWithdrawals()
    {
        return $this->getTotalFundsByType('withdrawal');
    }

    public function getTotalFundsByType(string $type)
    {
        return Transaction::where('user_id', '=', $this->id)->where('type', '=', $type)->sum('amount');
    }

    public function getBalance()
    {
        return Transaction::where('user_id', '=', $this->id)->sum('amount');
    }

    public function getTotalGamesWon(): int
    {
        return $this->games()->where(function ($game) {
            return $this->activeGame
                ? $game->where('game_id', '=', $this->activeGame->id)
                : $game;
        })->wherePivot('winner', '=', true)->count();
    }

    public function getTotalGamesPlayed(): int
    {
        return $this->games()->where(function ($game) {
            return $this->activeGame
                ? $game->where('game_id', '=', $this->activeGame->id)
                : $game;
        })->count();
    }

    public function getWinPercentage(): int
    {
        if (!$this->getTotalGamesPlayed()) {
            return 0;
        }

        return ceil(($this->getTotalGamesWon() / $this->getTotalGamesPlayed()) * 100);
    }

    public function getWinStreak(): int
    {
        $wins = 0;

        $games = $this->activeGame
            ? $this->games()->where('game_id', '=', $this->activeGame->id)->get()
            : $this->games;

        foreach ($games->sortByDesc('created_at') as $game) {
            if (!$game->pivot->winner) {
                return $wins;
            }

            $wins++;
        }

        return $wins;
    }

    public function addTransaction(string $type, float $amount, float $commission = 0, ?int $gameInstanceId = null)
    {
        return $this->transactions()->create([
            'type' => $type,
            'amount' => $amount,
            'commission' => $commission,
            'game_instance_id' => $gameInstanceId
        ]);
    }

    public function depositFunds(float $amount)
    {
        return $this->addTransaction('deposit', $amount);
    }

    public function withdrawFunds(float $amount)
    {
        return $this->addTransaction('withdrawal', -abs($amount));
    }

    public function getWithdrawableFunds()
    {
        return $this->getBalance();
    }

    public function lockFunds()
    {
        // $this->funds_locked_at = Carbon::now();

        // $this->save();
    }

    public function unlockFunds()
    {
        $this->funds_locked_at = null;

        $this->save();
    }

    public function hasLockedFunds(): bool
    {
        if (!$this->funds_locked_at) {
            return false;
        }

        return $this->funds_locked_at->diffInMinutes(Carbon::now()) == 0;
    }

    // public function getProfileImageAttribute($value)
    // {
    //     return $value ? Storage::url($value) : '/images/default.jpg';
    // }
}