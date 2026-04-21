<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItineraryDay extends Model
{
    protected $fillable = [
        'itinerary_id',
        'day_number',
        'date',
        'activities',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'activities' => 'array',
    ];

    public function itinerary(): BelongsTo
    {
        return $this->belongsTo(Itinerary::class);
    }
}
