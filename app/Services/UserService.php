<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class UserService
{
    /**
     * Search users by username or name
     *
     * @param string $query Search query
     * @param User $excludeUser User to exclude from results (usually the searcher)
     * @param int $limit Maximum number of results
     * @return Collection
     */
    public function searchUsers(string $query, User $excludeUser, int $limit = 20): Collection
    {
        return User::where('username', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->where('id', '!=', $excludeUser->id)
            ->limit($limit)
            ->get();
    }

    /**
     * Get suggested users to follow
     *
     * @param User $user The user to get suggestions for
     * @param int $limit Maximum number of suggestions
     * @return Collection
     */
    public function getSuggestions(User $user, int $limit = 10): Collection
    {
        return User::whereNotIn('id', function($query) use ($user) {
                $query->select('following_id')
                    ->from('follows')
                    ->where('follower_id', $user->id);
            })
            ->where('id', '!=', $user->id)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    /**
     * Toggle follow status between two users
     *
     * @param User $follower The user who is following/unfollowing
     * @param User $target The user being followed/unfollowed
     * @return bool True if now following, false if unfollowed
     */
    public function toggleFollow(User $follower, User $target): bool
    {
        if ($follower->isFollowing($target)) {
            $follower->following()->detach($target);
            return false;
        } else {
            $follower->following()->attach($target);
            return true;
        }
    }

    /**
     * Get followers of a user
     *
     * @param User $user The user to get followers for
     * @param int $perPage Number of results per page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFollowers(User $user, int $perPage = 20)
    {
        return $user->followers()
            ->latest('follows.created_at')
            ->paginate($perPage);
    }

    /**
     * Get users that a user is following
     *
     * @param User $user The user to get following for
     * @param int $perPage Number of results per page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFollowing(User $user, int $perPage = 20)
    {
        return $user->following()
            ->latest('follows.created_at')
            ->paginate($perPage);
    }

    /**
     * Get user profile data with counts
     *
     * @param User $user The user to get profile data for
     * @return array
     */
    public function getProfileData(User $user): array
    {
        $user->loadCount(['posts', 'followers', 'following']);

        return [
            'posts_count' => $user->posts_count,
            'followers_count' => $user->followers_count,
            'following_count' => $user->following_count,
        ];
    }

    /**
     * Get user's posts with relationships
     *
     * @param User $user The user whose posts to retrieve
     * @param int $perPage Number of posts per page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUserPosts(User $user, int $perPage = 12)
    {
        return $user->posts()
            ->with(['user', 'likes', 'comments'])
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get user's reels
     *
     * @param User $user The user whose reels to retrieve
     * @param int $limit Maximum number of reels
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserReels(User $user, int $limit = 12): Collection
    {
        return $user->reels()
            ->latest()
            ->take($limit)
            ->get();
    }
}
