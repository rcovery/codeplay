<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use App\Repositories\CommentRepository;

class ReplyCommentController extends Controller
{
    public function __construct(private CommentRepository $comment)
    {
    }

    public function store(StoreCommentRequest $request, Post $post, int $comment_id)
    {
        $this->comment->add($request, $post, $comment_id);

        return to_route('posts.show', ['post' => $post->id]);
    }
}
