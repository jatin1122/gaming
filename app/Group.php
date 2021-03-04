<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'permissions'
    ];

    protected $casts = [
        'permissions' => 'array'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_groups');
    }
}
