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
        // Debug logging: help determine whether an UploadedFile is received for 'image'
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
            'image' => 'nullable|string',
        ]);

        // --- TAHAP 2: PERSIAPAN DATA ---
        if ($request->input('image')) {
            // Filepond mengirim string JSON, kita ambil data base64-nya
            $imageData = json_decode($request->input('image'), true);

            // Cek jika datanya valid
            if (!empty($imageData['data'])) {
                $raw = $imageData['data'];

                // Jika raw mengandung data URI prefix (data:<mime>;base64,xxxxx), ambil bagian setelah koma
                if (strpos($raw, 'base64,') !== false) {
                    $parts = explode('base64,', $raw, 2);
                    $b64 = $parts[1] ?? '';
                } else {
                    // Bisa jadi plugin hanya mengirim base64 tanpa prefix
                    $b64 = $raw;
                }

                $decoded = base64_decode($b64);

                // Pastikan decode berhasil dan data tidak kosong sebelum menyimpan
                if ($decoded !== false && strlen($decoded) > 0) {
                    // Tentukan ekstensi dari tipe MIME jika tersedia
                    $mime = $imageData['type'] ?? null;
                    $ext = 'png';
                    if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
                        $ext = 'jpg';
                    } elseif ($mime === 'image/png') {
                        $ext = 'png';
                    }

                    // Buat nama file unik
                    $filename = 'post-images/' . Str::uuid() . '.' . $ext;

                    // Simpan file ke storage
                    Storage::disk('public')->put($filename, $decoded);

                    // Simpan path ke database
                    $validatedData['image'] = $filename;
                }
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
            'image' => 'image|file|max:2048', // Tambahkan validasi gambar
        ];

        // Debug logging: help determine whether an UploadedFile is received for 'image' on update
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

        logger()->info('Image debug update', [
            'hasFile' => $request->hasFile('image'),
            'fileClass' => is_object($file) ? get_class($file) : (is_array($file) ? 'array' : null),
            'fileName' => $fileName,
            'fileType' => $fileType,
        ]);

        $validatedData = $request->validate($rules);

        // 3. Logika Update Gambar (Diubah untuk FileEncode)
        if ($request->input('image')) {
            // Ada gambar baru atau aksi pada input image
            $imageData = json_decode($request->input('image'), true);

            if (!empty($imageData['data'])) {
                // Hapus gambar lama (jika ada)
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }

                $raw = $imageData['data'];
                if (strpos($raw, 'base64,') !== false) {
                    $parts = explode('base64,', $raw, 2);
                    $b64 = $parts[1] ?? '';
                } else {
                    $b64 = $raw;
                }

                $decoded = base64_decode($b64);

                if ($decoded !== false && strlen($decoded) > 0) {
                    $mime = $imageData['type'] ?? null;
                    $ext = 'png';
                    if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
                        $ext = 'jpg';
                    } elseif ($mime === 'image/png') {
                        $ext = 'png';
                    }

                    $filename = 'post-images/' . Str::uuid() . '.' . $ext;
                    Storage::disk('public')->put($filename, $decoded);
                    $validatedData['image'] = $filename;
                }
            } elseif (empty($imageData)) {
                // Jika input 'image' ada tapi kosong (user menghapus file di UI)
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                $validatedData['image'] = null;
            }
        }

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
