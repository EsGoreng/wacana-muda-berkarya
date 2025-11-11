<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index(Request $request)
    {
        $posts = Post::filter(request(['search', 'category', 'author']))
            ->paginate(9);

        return view('posts', [
            'title' => 'Forum - Ruang Kata, Jejak Karya, Jelajah Rasa',
            'posts' => $posts
        ]);
    }

    /**
     * Display a specific post.
     */
    public function show(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('post', [
            'title' => $post->title,
            'post' => $post
        ]);
    }
}
