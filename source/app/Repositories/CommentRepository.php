<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

interface CommentRepository
{
    public function add(Request $request, Post $post, int $comment_id = null): Comment;
    public function edit(Request $request, Comment $post): Comment;
}
