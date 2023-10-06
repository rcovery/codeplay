<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use App\Repositories\CommentRepository;

class CommentController extends Controller
{
    public function __construct(private CommentRepository $comment)
    {
    }

    public function store(StoreCommentRequest $request, Post $post)
    {
        $this->comment->add($request, $post);

        return to_route('posts.show', ['post' => $post->id]);
    }
}
