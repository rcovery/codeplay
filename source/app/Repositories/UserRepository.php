<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;

class UserRepository
{
    public function add(Request $request)
    {
        return User::create($request->all());
    }
}
