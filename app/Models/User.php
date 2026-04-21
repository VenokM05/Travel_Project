<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
    public function itineraries()
    {
        return $this->hasMany(Itinerary::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public function budgetSplits()
    {
        return $this->hasMany(BudgetSplit::class);
    }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function reels()
    {
        return $this->hasMany(Reel::class);
    }

    public function memories()
    {
        return $this->hasMany(Memory::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function travelGroups()
    {
        return $this->hasMany(TravelGroup::class, 'created_by');
    }

    public function groupMemberships()
    {
        return $this->hasMany(GroupMember::class);
    }

    // Follow relationships
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')->withTimestamps();
    }

    public function following()
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
