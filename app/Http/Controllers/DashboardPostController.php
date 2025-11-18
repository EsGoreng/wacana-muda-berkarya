<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        $posts = Post::where('author_id', $userId)
            ->filter(request(['search'])) // Menerapkan search (Sesuai roadmap)
            ->latest()
            ->paginate(10) // Menerapkan paginasi (Sesuai roadmap)
            ->withQueryString();

        // Kirim data ke view
        return view('dashboard.index', [
            'posts' => $posts,
            'title' => 'Dashboard',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('dashboard.blogs.create', [
            'categories' => Category::all(),
            'title' => 'Create New Post'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = $request->file('image');
        $fileName = null;
        $fileType = null;
        if ($file) {
            if (is_array($file)) {
                $names = [];
                $types = [];
                foreach ($file as $f) {
                    $names[] = $f->getClientOriginalName();
                    $types[] = $f->getClientMimeType();
                }
                $fileName = implode(',', $names);
                $fileType = implode(',', $types);
            } else {
                $fileName = $file->getClientOriginalName();
                $fileType = $file->getClientMimeType();
            }
        }

        logger()->info('Image debug store', [
            'hasFile' => $request->hasFile('image'),
            'fileClass' => is_object($file) ? get_class($file) : (is_array($file) ? 'array' : null),
            'fileName' => $fileName,
            'fileType' => $fileType,
        ]);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'body' => 'required|string',
            'image' => 'image|file|max:2048',
        ]);

        if ($request->file('image')) {
            $imagePath = $request->file('image')->store('post-images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $validatedData['author_id'] = auth()->id();
        $validatedData['slug'] = Str::slug($request->title, '-');
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 150, '...');

        Post::create($validatedData); //

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

        return view('dashboard.blogs.show', [
            'post' => $post,
            'title' => $post->title,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Otorisasi: Pastikan user hanya bisa mengedit post miliknya
        if ($post->author_id !== auth()->id()) {
            abort(403);
        }

        return view('dashboard.blogs.edit', [
            'post' => $post, // Kirim data post yang ingin diedit
            'categories' => Category::all(),
            'title' => 'Edit ' . $post->title, // Kirim data kategori untuk dropdown
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // 1. Otorisasi
        if ($post->author_id !== auth()->id()) {
            abort(403);
        }

        // 2. Validasi
        $rules = [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'body' => 'required|string',
            'image' => 'image|file|max:2048', // Validasi gambar
        ];

        // Debug logging (Boleh dihapus jika sudah tidak diperlukan)
        $file = $request->file('image');
        $fileName = null;
        $fileType = null;
        if ($file) {
            $fileName = $file->getClientOriginalName();
            $fileType = $file->getClientMimeType();
        }

        logger()->info('Image debug update', [
            'hasFile' => $request->hasFile('image'),
            'fileClass' => is_object($file) ? get_class($file) : (is_array($file) ? 'array' : null),
            'fileName' => $fileName,
            'fileType' => $fileType,
        ]);

        $validatedData = $request->validate($rules);

        // --- TAHAP 3: LOGIKA BARU UNTUK GAMBAR ---

        // Cek apakah user mencentang 'Hapus Gambar'
        if ($request->has('delete_image')) {

            // 1. Hapus gambar lama dari storage jika ada
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            // 2. Set 'image' di database menjadi null
            $validatedData['image'] = null;
        }
        // Jika tidak hapus, cek apakah user upload gambar BARU
        elseif ($request->file('image')) {

            // 1. Hapus gambar lama (jika ada) untuk diganti
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            // 2. Simpan gambar baru dan dapatkan path-nya
            $validatedData['image'] = $request->file('image')->store('post-images', 'public');
        }
        // Jika tidak ada aksi (tidak hapus, tidak upload baru),
        // kita tidak memasukkan 'image' ke $validatedData,
        // sehingga database tidak akan di-update (gambar lama tetap ada).


        // 4. (Opsional) Cek jika title berubah, buat ulang slug
        if ($request->title !== $post->title) {
            $validatedData['slug'] = Str::slug($request->title, '-');
        }

        // 5. Buat ulang excerpt
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 150, '...');

        // 6. Update data di database
        $post->update($validatedData);

        // 7. Redirect
        return redirect()->route('dashboard.posts.index')
            ->with('success', 'Post has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // 1. Otorisasi
        if ($post->author_id !== auth()->id()) {
            abort(403);
        }

        // 2. Hapus gambar (Logika BARU)
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        // 3. Hapus post dari database
        $post->delete();

        // 4. Redirect dengan pesan sukses
        return redirect()->route('dashboard.posts.index')
            ->with('success', 'Post has been deleted successfully!');
    }
}
