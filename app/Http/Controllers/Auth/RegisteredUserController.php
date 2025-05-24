<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'is_active' => 'required|boolean',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $role = Role::where('uuid', $request->role)->first();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'is_active' => $request->is_active,
            'password' => Hash::make($request->password),
        ]);
        $user->syncRoles($role);
        return redirect()->route('users')->with('success', 'User created successfully.');
    }
}
