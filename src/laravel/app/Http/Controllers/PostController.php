<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    public function index(Request $request)
    {
    try {
        $uid = $request->uid;
        $user = User::where('uid', $uid)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $posts = Post::with('user','likes')->withCount('likes')->latest()->get();
        $posts = $posts->each(function ($post) use ($user) {
            $post->isLikedByUser = $post->likes->contains('user_id', $user->id);
        });
        $posts = $posts->each(function ($post) use ($user) {
            $post->myMessage = $post->user_id == $user->id;
        });
        return response()->json([
            'data' => $posts
        ], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred'], 500);
    }
    }

    public function store(Request $request)
    {
    try {
        $user = User::where('uid', $request->uid)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $post = Post::create([
            'user_id' => $user->id,
            'message' => $request->message,
        ]);
        if (!$post) {
            return response()->json(['error' => 'Failed to create post'], 500);
        }
        return response()->json([
            'data' => $post
        ], 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred'], 500);
    }
    }

    public function delete(Request $request)
    {
    try {
        $post = Post::find($request->post_id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred'], 500);
    }
    }
}
