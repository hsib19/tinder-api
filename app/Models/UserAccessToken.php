<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken;

class UserAccessToken extends PersonalAccessToken
{
    protected $table = 'user_access_tokens';
}
