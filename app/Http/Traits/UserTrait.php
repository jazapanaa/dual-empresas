<?php

namespace App\Http\Traits;

use App\Models\User;

trait UserTrait
{
    public function getUsers()
    {
        return User::query();
    }
    public function getUser($user_id)
    {
        return User::find($user_id);
    }

}
