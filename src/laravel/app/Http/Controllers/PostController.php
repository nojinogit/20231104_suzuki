<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $uid = $request->uid;
        $user = User::where('uid', $uid)->first();

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
    }

    public function store(Request $request)
    {
    $user = User::where('uid', $request->uid)->first();

    if ($user != null) {
        $post = Post::create([
            'user_id' => $user->id,
            'message' => $request->message,
        ]);

        return response()->json([
            'data' => $post
        ], 201);
        } else {
        return response()->json([
            'error' => 'User not found'
        ], 404);
    }
    }

    public function delete(Request $request)
    {
    Post::find($request->post_id)->delete();
    }
}
