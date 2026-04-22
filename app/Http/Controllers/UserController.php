<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }
    /**
     * Search users by username or name
     */
    public function index(Request $request)
    {
        $query = $request->input('q');
        
        if (!$query) {
            return view('users.search', ['users' => [], 'query' => '']);
        }

        $users = $this->userService->searchUsers($query, auth()->user());

        return view('users.search', compact('users', 'query'));
    }

    /**
     * Show user profile
     */
    public function show(User $user)
    {
        $profileData = $this->userService->getProfileData($user);
        $posts = $this->userService->getUserPosts($user, 12);
        $reels = $this->userService->getUserReels($user, 12);
        
        $isFollowing = auth()->user()->isFollowing($user);
        
        return view('users.show', compact('user', 'posts', 'reels', 'isFollowing', 'profileData'));
    }

    /**
     * Toggle follow
     */
    public function follow(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Cannot follow yourself'], 400);
        }

        $isFollowing = $this->userService->toggleFollow(auth()->user(), $user);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'isFollowing' => $isFollowing,
                'followersCount' => $user->followers()->count(),
            ]);
        }

        return back()->with('success', $isFollowing ? 'Followed successfully' : 'Unfollowed');
    }

    /**
     * List followers
     */
    public function followers(User $user)
    {
        $followers = $this->userService->getFollowers($user);
        
        return view('users.followers', compact('user', 'followers'));
    }

    /**
     * List following
     */
    public function following(User $user)
    {
        $following = $this->userService->getFollowing($user);
        
        return view('users.following', compact('user', 'following'));
    }

    /**
     * Suggested users to follow
     */
    public function suggestions()
    {
        $suggestedUsers = $this->userService->getSuggestions(auth()->user());

        if (request()->wantsJson()) {
            return response()->json(['users' => $suggestedUsers]);
        }

        return view('users.suggestions', compact('suggestedUsers'));
    }
}
