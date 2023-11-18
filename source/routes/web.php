<?php

use App\Mail\UserRegistered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReplyCommentController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/posts/{post}/comments', CommentController::class)->only(['store', 'update', 'destroy']);
    Route::resource('/posts/{post}/comments/{comment}/replies', ReplyCommentController::class)->only(['store', 'update', 'destroy']);
});

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/email', function () {
    return new UserRegistered(Auth::user()->name);
});

Route::resource('/users', UserController::class);
Route::resource('/posts', PostController::class);

require __DIR__ . '/auth.php';
