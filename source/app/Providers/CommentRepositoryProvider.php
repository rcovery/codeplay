<?php

namespace App\Providers;

use App\Repositories\CommentRepository;
use App\Repositories\EloquentCommentRepository;
use Illuminate\Support\ServiceProvider;

class CommentRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CommentRepository::class, EloquentCommentRepository::class);
    }
}
