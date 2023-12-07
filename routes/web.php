<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::middleware('auth')->group(function () {

    Route::get('/create-post', [PostController::class, "showCreateForm"]);

    Route::post('/create-post', [PostController::class, "storeNewPost"]);

    Route::get('/post/{post}', [PostController::class, "viewSinglePost"]);

    Route::post('/logout', [UserController::class, "logout"]);

    Route::get('/profile/{user:username}', [UserController::class, "profile"]);

    Route::delete('/post/{post}', [PostController::class, "delete"])->middleware('can:delete,post');

    Route::get('/post/{post}/edit', [PostController::class, 'showEditForm'])->middleware('can:update,post');

    Route::put('/post/{post}', [PostController::class, 'actuallyUpdate'])->middleware('can:update,post');

    Route::get('/manage-avatar', [UserController::class, 'showAvatarForm']);

    Route::post('/manage-avatar', [UserController::class, 'storeAvatar']);

    Route::post('/create-follow/{user:username}', [FollowController::class, 'createFollow']);

    Route::post('/remove-follow/{user:username}', [FollowController::class, 'removeFollow']);

});

Route::get('/', [UserController::class, "showCorrectHomepage"])->name('login');

Route::post('/register', [UserController::class, "register"]);

Route::post('/login', [UserController::class, "login"]);





