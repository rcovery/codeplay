<?php

namespace App\Repositories;

use App\Mail\UserRegistered;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EloquentUserRepository implements UserRepository
{
    public function add(Request $request): User
    {
        $user_created = User::create($request->all());
        $user_registered_mail = new UserRegistered($user_created->name);

        Mail::queue($user_registered_mail);

        return $user_created;
    }
}
