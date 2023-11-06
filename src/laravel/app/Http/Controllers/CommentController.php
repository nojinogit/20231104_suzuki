<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class CommentController extends Controller
{
    public function commentIndex(Request $request)
    {
    try {
        $uid = $request->uid;
        $user = User::where('uid', $uid)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $post = Post::with('user','likes')->withCount('likes')->where('id',$request->post_id)->first();

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $post->isLikedByUser = $post->likes->contains('user_id', $user->id);
        $post->myMessage = $post->user_id == $user->id;

        return response()->json([
            'data' => $post,
        ], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred'], 500);
    }
    }

    public function commentGet(Request $request)
    {
    try {
        $comments = Comment::with('user')->where('post_id', $request->post_id)->get();

        return response()->json([
            'data' => $comments,
        ], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred'], 500);
    }
    }

    public function commentStore(Request $request)
    {
    try {
        $user = User::where('uid', $request->uid)->first();

        if ($user != null) {
            $comment = Comment::create([
                'user_id' => $user->id,
                'comment' => $request->comment,
                'post_id' => $request->post_id,
            ]);

            if ($comment) {
                return response()->json([
                    'data' => $comment
                ], 201);
            } else {
                return response()->json([
                    'error' => 'Failed to create comment'
                ], 500);
            }
        } else {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'An error occurred'
        ], 500);
    }
    }
}
