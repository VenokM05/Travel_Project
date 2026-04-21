<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reel extends Model
{
    protected $fillable = [
        'user_id',
        'video_url',
        'thumbnail_url',
        'caption',
        'tags',
        'likes_count',
        'comments_count',
        'views_count',
        'duration',
    ];

    protected $casts = [
        'tags' => 'array',
        'likes_count' => 'integer',
        'comments_count' => 'integer',
        'views_count' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
}
