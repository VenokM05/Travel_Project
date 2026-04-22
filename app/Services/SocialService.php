<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Story;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SocialService
{
    /**
     * Create a new post
     *
     * @param array $data Validated post data
     * @param User $user The authenticated user
     * @return Post
     */
    public function createPost(array $data, User $user): Post
    {
        return $user->posts()->create([
            'content' => $data['content'],
            'media_urls' => $data['media_urls'] ?? [],
            'location' => $data['location'] ?? null,
            'tags' => $data['tags'] ?? [],
            'privacy' => $data['privacy'] ?? $user->default_post_privacy ?? 'public',
            'likes_count' => 0,
            'comments_count' => 0,
        ]);
    }

    /**
     * Toggle like on a post
     *
     * @param Post $post The post to toggle like on
     * @param User $user The user toggling the like
     * @return array Status of the like action
     */
    public function toggleLike(Post $post, User $user): array
    {
        $existingLike = Like::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        if ($existingLike) {
            // Unlike
            $existingLike->delete();
            $post->decrement('likes_count');
            
            return [
                'success' => true,
                'liked' => false,
                'likes_count' => $post->likes_count,
                'message' => 'Post unliked',
            ];
        } else {
            // Like
            Like::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
            $post->increment('likes_count');
            
            return [
                'success' => true,
                'liked' => true,
                'likes_count' => $post->likes_count,
                'message' => 'Post liked',
            ];
        }
    }

    /**
     * Add a comment to a post
     *
     * @param Post $post The post to comment on
     * @param User $user The user commenting
     * @param array $data Validated comment data
     * @return Comment
     */
    public function addComment(Post $post, User $user, array $data): Comment
    {
        return DB::transaction(function () use ($post, $user, $data) {
            $comment = $post->comments()->create([
                'user_id' => $user->id,
                'content' => $data['content'],
                'parent_id' => $data['parent_id'] ?? null,
            ]);

            // Increment comment count
            $post->increment('comments_count');

            return $comment;
        });
    }

    /**
     * Delete a post and its associated data
     *
     * @param Post $post The post to delete
     * @return void
     */
    public function deletePost(Post $post): void
    {
        DB::transaction(function () use ($post) {
            // Delete associated likes
            $post->likes()->delete();

            // Delete associated comments
            $post->comments()->delete();

            // Delete the post
            $post->delete();
        });
    }

    /**
     * Create a new story
     *
     * @param array $data Validated story data
     * @param User $user The authenticated user
     * @return Story
     */
    public function createStory(array $data, User $user): Story
    {
        return $user->stories()->create([
            'media_url' => $data['media_url'],
            'media_type' => $data['media_type'],
            'caption' => $data['caption'] ?? null,
            'expires_at' => now()->addHours(24),
            'views' => [],
        ]);
    }

    /**
     * Get active stories (not expired)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveStories()
    {
        return Story::where('expires_at', '>', now())
            ->with('user')
            ->latest()
            ->get();
    }

    /**
     * Get community wall posts
     *
     * @param int $perPage Number of posts per page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getWallPosts(int $perPage = 10)
    {
        return Post::with(['user', 'comments.user', 'likes'])
            ->where('privacy', 'public')
            ->latest()
            ->paginate($perPage);
    }
}
