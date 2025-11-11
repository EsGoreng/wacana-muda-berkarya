<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        // Ambil postingan HANYA milik user tersebut,
        // Gunakan filter scope dari Model Post
        // Terapkan paginasi
        $posts = Post::where('author_id', $userId)
            ->filter(request(['search'])) // Menerapkan search (Sesuai roadmap)
            ->latest()
            ->paginate(10) // Menerapkan paginasi (Sesuai roadmap)
            ->withQueryString();

        // Kirim data ke view
        return view('dashboard.posts.index', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('dashboard.posts.create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // --- TAHAP 1: VALIDASI (Sesuai Roadmap) ---
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'body' => 'required|string',
        ]);

        // --- TAHAP 2: PERSIAPAN DATA ---

        // Ambil ID user yang sedang login
        $validatedData['author_id'] = auth()->id();

        // Buat Slug dari Judul
        $validatedData['slug'] = Str::slug($request->title, '-');

        // Buat Excerpt/Cuplikan dari Body
        // 'strip_tags' untuk membersihkan HTML, 'limit' untuk membatasi
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 150, '...');

        // --- TAHAP 3: SIMPAN KE DATABASE ---
        Post::create($validatedData); //

        // --- TAHAP 4: REDIRECT ---
        return redirect()->route('dashboard.posts.index')
            ->with('success', 'New post has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Periksa apakah user yang login adalah pemilik post
        // Ini adalah langkah keamanan yang PENTING
        if ($post->author_id !== auth()->id()) {
            abort(403); // Unauthorized action
        }

        return view('dashboard.posts.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
