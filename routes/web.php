<?php

use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ============================================
// PUBLIC ROUTES
// ============================================

// Home Page
Route::get('/', function () {
    return view('home', [
        'title' => 'Wacana Muda Berkarya - Dari Kata ke Karya'
    ]);
})->name('home');

// Posts Routes
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

// About Page
Route::get('/about', function () {
    return view('about', [
        'title' => 'Tentang Kami',
        'name' => 'Wacana Muda Berkarya'
    ]);
})->name('about');

// Contact Page
Route::get('/contact', function () {
    return view('contact', [
        'title' => 'Hubungi Kami'
    ]);
})->name('contact');

// ============================================
// DASHBOARD ROUTES (Protected)
// ============================================

// Dashboard Home
Route::get('/dashboard', function () {
    return view('dashboard', [
        'title' => 'Dashboard'
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Posts Management
    Route::resource('/dashboard/posts', DashboardPostController::class)->names('dashboard.posts');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================
// AUTHENTICATION ROUTES
// ============================================
require __DIR__.'/auth.php';
