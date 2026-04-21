<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Search users by username or name
     */
    public function index(Request $request)
    {
        $query = $request->input('q');
        
        if (!$query) {
            return view('users.search', ['users' => [], 'query' => '']);
        }

        $users = User::where('username', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->where('id', '!=', auth()->id())
            ->limit(20)
            ->get();

        return view('users.search', compact('users', 'query'));
    }

    /**
     * Show user profile
     */
    public function show(User $user)
    {
        $user->loadCount(['posts', 'followers', 'following']);
        
        $posts = $user->posts()->with(['user', 'likes', 'comments'])->latest()->paginate(12);
        $reels = $user->reels()->latest()->take(12)->get();
        
        $isFollowing = auth()->user()->isFollowing($user);
        
        return view('users.show', compact('user', 'posts', 'reels', 'isFollowing'));
    }

    /**
     * Toggle follow
     */
    public function follow(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Cannot follow yourself'], 400);
        }

        $follower = auth()->user();
        
        if ($follower->isFollowing($user)) {
            $follower->following()->detach($user);
            $isFollowing = false;
        } else {
            $follower->following()->attach($user);
            $isFollowing = true;
        }

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
        $followers = $user->followers()->latest('follows.created_at')->paginate(20);
        
        return view('users.followers', compact('user', 'followers'));
    }

    /**
     * List following
     */
    public function following(User $user)
    {
        $following = $user->following()->latest('follows.created_at')->paginate(20);
        
        return view('users.following', compact('user', 'following'));
    }

    /**
     * Suggested users to follow
     */
    public function suggestions()
    {
        $user = auth()->user();
        
        // Get users that the current user doesn't follow, excluding themselves
        $suggestedUsers = User::whereNotIn('id', function($query) use ($user) {
                $query->select('following_id')
                    ->from('follows')
                    ->where('follower_id', $user->id);
            })
            ->where('id', '!=', $user->id)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        if (request()->wantsJson()) {
            return response()->json(['users' => $suggestedUsers]);
        }

        return view('users.suggestions', compact('suggestedUsers'));
    }
}
