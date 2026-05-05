<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

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
        $user = $request->user();
        // Mengisi data nama dan email yang sudah divalidasi
        $user->fill($request->validated());

        // Cek jika ada file foto yang diupload
        if ($request->hasFile('avatar')) {

        // Hapus foto lama jika sebelumnya sudah pernah upload (biar tidak penuh-penuhin memori)
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        // Simpan foto baru ke folder 'avatars' di dalam storage/public
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
        }
        // Jika email berubah, reset verifikasi email
         if ($user->isDirty('email')) {
        $user->email_verified_at = null;
        }
        $user->save();

        return Redirect::route('profile.edit')->with('status','profile-updated');
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
