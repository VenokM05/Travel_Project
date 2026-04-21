<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Story;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    /**
     * Display the community wall
     */
    public function wall()
    {
        $posts = Post::with(['user', 'comments.user', 'likes'])
            ->where('privacy', 'public')
            ->latest()
            ->paginate(10);

        $stories = Story::where('expires_at', '>', now())
            ->with('user')
            ->latest()
            ->get();

        return view('social.wall', compact('posts', 'stories'));
    }

    /**
     * Store a new post
     */
    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:2000',
            'media_urls' => 'nullable|array',
            'media_urls.*' => 'url',
            'location' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'privacy' => 'nullable|in:public,followers,private',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['privacy'] = $validated['privacy'] ?? auth()->user()->default_post_privacy ?? 'public';
        $validated['likes_count'] = 0;
        $validated['comments_count'] = 0;

        $post = Post::create($validated);

        return redirect()->route('social.wall')
            ->with('success', 'Post published!');
    }

    /**
     * Toggle like on a post
     */
    public function likePost(Post $post)
    {
        $user = auth()->user();
        $existingLike = Like::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $post->decrement('likes_count');
            $liked = false;
        } else {
            Like::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
            $post->increment('likes_count');
            $liked = true;
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes_count' => $post->likes_count,
            ]);
        }

        return back();
    }

    /**
     * Add comment to a post
     */
    public function commentPost(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        $post->increment('comments_count');

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'comment' => $comment->load('user'),
            ]);
        }

        return back()->with('success', 'Comment added');
    }

    /**
     * Delete a post
     */
    public function deletePost(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('social.wall')
            ->with('success', 'Post deleted');
    }

    /**
     * Display stories page
     */
    public function stories()
    {
        $stories = Story::where('expires_at', '>', now())
            ->with('user')
            ->latest()
            ->get();

        return view('social.stories', compact('stories'));
    }

    /**
     * Store a new story
     */
    public function storeStory(Request $request)
    {
        $validated = $request->validate([
            'media_url' => 'required|url',
            'media_type' => 'required|in:image,video',
            'caption' => 'nullable|string|max:500',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['expires_at'] = now()->addHours(24);
        $validated['views'] = [];

        Story::create($validated);

        return back()->with('success', 'Story posted!');
    }

    /**
     * Display reels page
     */
    public function reels()
    {
        $reels = \App\Models\Reel::with(['user', 'likes', 'comments'])
            ->latest()
            ->take(20)
            ->get();

        return view('social.reels', compact('reels'));
    }
}
