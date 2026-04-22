<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
        'bio',
        'subscription_tier',
        'subscription_status',
        'subscription_expires',
        'storage_used',
        'notification_email',
        'notification_push',
        'profile_privacy',
        'default_post_privacy',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'subscription_expires' => 'date',
            'notification_email' => 'boolean',
            'notification_push' => 'boolean',
        ];
    }

    // Relationships
    public function itineraries(): HasMany
    {
        return $this->hasMany(Itinerary::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public function budgetSplits(): HasMany
    {
        return $this->hasMany(BudgetSplit::class);
    }

    public function todos(): HasMany
    {
        return $this->hasMany(Todo::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function stories(): HasMany
    {
        return $this->hasMany(Story::class);
    }

    public function reels(): HasMany
    {
        return $this->hasMany(Reel::class);
    }

    public function memories(): HasMany
    {
        return $this->hasMany(Memory::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function travelGroups(): HasMany
    {
        return $this->hasMany(TravelGroup::class, 'created_by');
    }

    public function groupMemberships(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    // Follow relationships
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')->withTimestamps();
    }

    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')->withTimestamps();
    }

    public function isFollowing(User $user): bool
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    public function isFollowedBy(User $user): bool
    {
        return $this->followers()->where('follower_id', $user->id)->exists();
    }

    // Helper methods
    public function hasActiveSubscription()
    {
        return $this->subscription_status === 'active' && 
               ($this->subscription_expires === null || $this->subscription_expires->isFuture());
    }

    public function getStorageLimit()
    {
        return match($this->subscription_tier) {
            'pro' => 10, // 10 GB
            'premium' => 50, // 50 GB
            default => 1, // 1 GB for free
        };
    }

    public function getStorageRemaining()
    {
        return $this->getStorageLimit() - $this->storage_used;
    }
}
