<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    protected $fillable = [
        'user_id',
        'itinerary_id',
        'name',
        'description',
        'total_budget',
        'total_spent',
        'currency',
        'type',
        'status',
    ];

    protected $casts = [
        'total_budget' => 'decimal:2',
        'total_spent' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function itinerary(): BelongsTo
    {
        return $this->belongsTo(Itinerary::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function splits(): HasMany
    {
        return $this->hasMany(BudgetSplit::class);
    }
}
