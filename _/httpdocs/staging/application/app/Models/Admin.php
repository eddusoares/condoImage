<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function categories()
    {
        return $this->morphMany(Category::class, 'userable');
    }

    public function states()
    {
        return $this->morphMany(State::class, 'userable');
    }

    public function counties()
    {
        return $this->morphMany(County::class, 'userable');
    }

    public function neighborhoods()
    {
        return $this->morphMany(Neighborhood::class, 'userable');
    }
}
