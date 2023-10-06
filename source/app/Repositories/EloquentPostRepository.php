<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Http\Request;

class EloquentPostRepository implements PostRepository
{
    public function add(Request $request): Post
    {
        $post = Post::create($request->all());

        return $post;
    }

    public function edit(Request $request, Post $post): Post
    {
        $post->fill($request->all());
        $post->save();

        return $post;
    }
}
