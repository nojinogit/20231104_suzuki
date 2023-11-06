<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

Route::post('register',[UserController::class,'register']);
Route::get('index',[PostController::class,'index']);
Route::post('store',[PostController::class,'store']);
Route::post('add',[LikeController::class,'add']);
Route::post('remove',[LikeController::class,'remove']);
Route::post('delete',[PostController::class,'delete']);
Route::get('commentIndex',[CommentController::class,'commentIndex']);
Route::get('commentGet',[CommentController::class,'commentGet']);
Route::post('commentStore',[CommentController::class,'commentStore']);