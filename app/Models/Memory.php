<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Memory extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'date',
        'media_urls',
        'itinerary_id',
        'mood',
    ];

    protected $casts = [
        'date' => 'date',
        'media_urls' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function itinerary(): BelongsTo
    {
        return $this->belongsTo(Itinerary::class);
    }
}
