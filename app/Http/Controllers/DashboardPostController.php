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
            'image' => 'nullable|string',
        ]);

        // --- TAHAP 2: PERSIAPAN DATA ---
        if ($request->input('image')) {
            // Filepond mengirim string JSON, kita ambil data base64-nya
            $imageData = json_decode($request->input('image'), true);

            // Cek jika datanya valid
            if (isset($imageData['data'])) {
                $data = $imageData['data'];

                // Pisahkan data base64
                @list($type, $data) = explode(';', $data);
                @list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                // Buat nama file unik
                $filename = 'post-images/' . Str::uuid() . '.' . ($imageData['type'] == 'image/jpeg' ? 'jpg' : 'png');

                // Simpan file ke storage
                Storage::disk('public')->put($filename, $data);

                // Simpan path ke database
                $validatedData['image'] = $filename;
            }
        } else {
            $validatedData['image'] = null;
        }

        // --- TAHAP 3: PERSIAPAN DATA LAIN ---
        $validatedData['author_id'] = auth()->id();
        $validatedData['slug'] = Str::slug($request->title, '-');
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
    public function edit(Post $post)
    {
        // Otorisasi: Pastikan user hanya bisa mengedit post miliknya
        if ($post->author_id !== auth()->id()) {
            abort(403);
        }

        return view('dashboard.posts.edit', [
            'post' => $post, // Kirim data post yang ingin diedit
            'categories' => Category::all() // Kirim data kategori untuk dropdown
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // 1. Otorisasi (Sudah ada)
        if ($post->author_id !== auth()->id()) {
            abort(403);
        }

        // 2. Validasi (Diubah untuk FileEncode)
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'body' => 'required|string',
            'image' => 'nullable|string', // <- Diubah dari 'image|file'
        ]);

        // 3. Logika Update Gambar (Diubah untuk FileEncode)
        if ($request->input('image')) {
            // Ada gambar baru (Base64) yang di-upload

            // Cek data JSON dari Filepond
            $imageData = json_decode($request->input('image'), true);

            if (isset($imageData['data'])) {
                // 1. Hapus gambar lama (jika ada)
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }

                // 2. Dekode data Base64
                $data = $imageData['data'];
                @list($type, $data) = explode(';', $data);
                @list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                // 3. Buat nama file unik
                $ext = ($imageData['type'] == 'image/jpeg' ? 'jpg' : 'png');
                $filename = 'post-images/' . Str::uuid() . '.' . $ext;

                // 4. Simpan file baru
                Storage::disk('public')->put($filename, $data);

                // 5. Set path baru untuk divalidasi
                $validatedData['image'] = $filename;
            } else if (empty($imageData)) {
                // Jika input 'image' ada tapi datanya kosong 
                // (misal: user menghapus gambar di Filepond)

                // Hapus gambar lama (jika ada)
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                $validatedData['image'] = null; // Set jadi null
            }

            // Jika $imageData null (tidak ada input 'image' baru), 
            // kita tidak melakukan apa-apa, gambar lama tetap dipakai.

        }

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
