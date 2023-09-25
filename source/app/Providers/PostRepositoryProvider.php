<?php

namespace App\Providers;

use App\Repositories\EloquentPostRepository;
use App\Repositories\PostRepository;
use Illuminate\Support\ServiceProvider;

class PostRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepository::class, EloquentPostRepository::class);
    }
}
