<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetSplit extends Model
{
    protected $fillable = [
        'budget_id',
        'user_id',
        'share_percentage',
        'share_amount',
        'paid_amount',
        'status',
    ];

    protected $casts = [
        'share_percentage' => 'decimal:2',
        'share_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
