<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\User;

class LikeController extends Controller
{
    public function add(Request $request)
    {
    $user = User::where('uid', $request->uid)->first();
    $like = Like::create([
        'post_id' => $request->post_id,
        'user_id' => $user->id
    ]);
    return response()->json([
    'data' => $like
    ], 201);
    }
    public function remove(Request $request)
    {
    $user = User::where('uid', $request->uid)->first();
    $user_id = $user->id;
    $post_id = request()->get('post_id');
    Like::where('user_id',$user_id)->where('post_id',$post_id)->delete();
    }
}
