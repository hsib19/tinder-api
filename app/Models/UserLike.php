<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'liker_id',
        'liked_id',
        'is_liked',
        'created_at',
    ];

    public $timestamps = false;

    public function liker()
    {
        return $this->belongsTo(User::class, 'liker_id');
    }

    public function liked()
    {
        return $this->belongsTo(User::class, 'liked_id');
    }
}
