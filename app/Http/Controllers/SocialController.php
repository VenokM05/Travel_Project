<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use App\Models\Story;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Reel;
use App\Services\SocialService;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function __construct(protected SocialService $socialService)
    {
    }
    /**
     * Display the community wall
     */
    public function wall()
    {
        $posts = $this->socialService->getWallPosts(10);
        $stories = $this->socialService->getActiveStories();

        return view('social.wall', compact('posts', 'stories'));
    }

    /**
     * Store a new post
     */
    public function storePost(StorePostRequest $request)
    {
        $this->socialService->createPost(
            $request->validated(),
            auth()->user()
        );

        return redirect()->route('social.wall')
            ->with('success', 'Post published!');
    }

    /**
     * Toggle like on a post
     */
    public function likePost(Post $post)
    {
        $result = $this->socialService->toggleLike($post, auth()->user());

        if (request()->wantsJson()) {
            return response()->json($result);
        }

        return back();
    }

    /**
     * Add comment to a post
     */
    public function commentPost(StoreCommentRequest $request, Post $post)
    {
        $comment = $this->socialService->addComment(
            $post,
            auth()->user(),
            $request->validated()
        );

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

        $this->socialService->deletePost($post);

        return redirect()->route('social.wall')
            ->with('success', 'Post deleted');
    }

    /**
     * Display stories page
     */
    public function stories()
    {
        $stories = $this->socialService->getActiveStories();

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

        $this->socialService->createStory($validated, auth()->user());

        return back()->with('success', 'Story posted!');
    }

    /**
     * Display reels page
     */
    public function reels()
    {
        $reels = Reel::with(['user', 'likes', 'comments'])
            ->latest()
            ->take(20)
            ->get();

        return view('social.reels', compact('reels'));
    }
}
