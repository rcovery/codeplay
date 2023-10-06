<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class EloquentCommentRepository implements CommentRepository
{
    public function add(Request $request, Post $post): Comment
    {
        $data = $request->all();
        $data['post_id'] = $post->id;

        dd($data);

        $comment = Comment::create($data);

        return $comment;
    }

    public function edit(Request $request, Comment $comment): Comment
    {
        $comment->fill($request->all());
        $comment->save();

        return $comment;
    }
}
