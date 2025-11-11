<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // 1. Ambil data user
        $user = $request->user();

        // 2. Isi data yang divalidasi (dari ProfileUpdateRequest)
        $user->fill($request->validated());

        // 3. Reset verifikasi email jika email diubah
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // 4. (LOGIKA BARU) Handle Avatar Upload
        if ($request->file('avatar')) {
            // Validasi manual (bisa juga ditaruh di ProfileUpdateRequest)
            $request->validate([
                'avatar' => 'image|file|max:2048',
            ]);

            // Hapus avatar lama jika ada
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan avatar baru dan update path
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // 5. Simpan perubahan
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
