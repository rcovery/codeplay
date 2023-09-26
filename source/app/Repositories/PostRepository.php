<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Http\Request;

interface PostRepository
{
    public function add(Request $request): Post;
    public function edit(Request $request, Post $post): Post;
}
