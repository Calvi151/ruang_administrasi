<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $employee = $user->employee;

        if (!$employee) {
            return Redirect::route('profile.edit')->with('error', 'Profil karyawan tidak ditemukan.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                \Illuminate\Validation\Rule::unique('employee')->ignore($employee->id),
            ],
            'number' => ['nullable', 'string', 'max:20'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($employee->photo);
            }
            $validated['photo'] = $request->file('photo')->store('employees', 'public');
        } else {
            // Biarkan foto yang lama jika tidak ada upload baru
            unset($validated['photo']);
        }

        if (!empty($validated['password'])) {
            $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
            $user->save();
        }
        unset($validated['password']);

        $employee->fill($validated);
        $employee->save();

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
        $employee = $user->employee;

        Auth::logout();

        if ($employee) {
            if ($employee->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($employee->photo);
            }
            $employee->delete();
        }
        
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
