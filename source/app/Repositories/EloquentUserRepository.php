<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class EloquentUserRepository implements UserRepository
{
    public function add(Request $request): User
    {
        return User::create($request->all());
    }
}
