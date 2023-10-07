<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'post_id', 'user_id', 'comment_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeTopComments(Builder $builder): void
    {
        $builder->where('comment_id', null)->with('user');
    }

    public function scopeLastReplies(Builder $builder): void
    {
        $builder->with('replies', function () use ($builder) {
            return $builder->where('comment_id', 'IS NOT', null)->with('user');
        });
    }
}
