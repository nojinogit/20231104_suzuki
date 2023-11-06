<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\User;

class LikeController extends Controller
{
    public function add(Request $request)
    {
    try {
        $user = User::where('uid', $request->uid)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $like = Like::create([
            'post_id' => $request->post_id,
            'user_id' => $user->id
        ]);
        if (!$like) {
            return response()->json(['error' => 'Failed to create like'], 500);
        }
        return response()->json([
            'data' => $like
        ], 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred'], 500);
    }
    }

    public function remove(Request $request)
    {
    try {
        $user = User::where('uid', $request->uid)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $user_id = $user->id;
        $post_id = request()->get('post_id');
        $like = Like::where('user_id',$user_id)->where('post_id',$post_id)->first();
        if (!$like) {
            return response()->json(['error' => 'Like not found'], 404);
        }
        $like->delete();
        return response()->json(['message' => 'Like removed successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred'], 500);
    }
    }
}
