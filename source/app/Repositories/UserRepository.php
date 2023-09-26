<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;

interface UserRepository
{
    public function add(Request $request): User;
}
