<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function register(Request $request)
    {
    try {
        $user = User::create($request->all());
        if (!$user) {
            return response()->json(['error' => 'Failed to create user'], 500);
        }
        return response()->json([
            'data' => $user
        ], 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred'], 500);
    }
    }
}
