<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'age', 'email', 'password',
        'city', 'country', 'latitude', 'longitude',
    ];

    public function pictures()
    {
        return $this->hasMany(UserPicture::class);
    }

    public function likesGiven()
    {
        return $this->hasMany(UserLike::class, 'liker_id');
    }

    public function likesReceived()
    {
        return $this->hasMany(UserLike::class, 'liked_id');
    }

    public function notifications()
    {
        return $this->hasMany(AdminNotification::class);
    }
}
