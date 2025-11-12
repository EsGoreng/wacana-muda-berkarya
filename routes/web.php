<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardPostController;


Route::get('/', function () {
    return view('home')->with('title', 'Wacana Muda Berkarya');
});

Route::get('/posts', function () {
    return view('blog/posts', [
        'title' => 'Blog',
        'posts' => Post::latest()->paginate(9)
    ]);
});

Route::get('/posts/{post:slug}', function (Post $post) {
    return view('blog/post', [
        'title' => $post->title,
        'post' => $post
    ]);
});

Route::get('/dashboard', function () {
    return Redirect::route('dashboard.posts.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('/dashboard/posts', DashboardPostController::class)->names('dashboard.posts');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
