<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardPostController;


Route::get('/', function () {
    return view('home')->with('title', 'Wacana Muda Berkarya');
});

Route::get('/blogs', function () {
    $posts = Post::filter(request(['search', 'category', 'author']))
                ->latest()
                ->paginate(perPage: 12)
                ->withQueryString();

    $title = 'Blog Page';
    if (request('category') && $category = Category::firstWhere('slug', request('category'))) {
        $title = 'Article in ' . $category->name;
    } elseif (request('author') && $author = User::firstWhere('username', request('author'))) {
        $title = count($posts) . ' Article by ' . $author->name;
    } elseif (request('search')) {
        $title = 'Results for "' . request('search') . '"';
    }

    return view('blog/posts', ['title' => $title, 'posts' => $posts]);
});

Route::get('/blog/{post:slug}', function (Post $post) {
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
