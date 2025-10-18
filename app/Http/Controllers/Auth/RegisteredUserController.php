<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\College; // <-- Import College model
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Fetch all colleges to populate the dropdown in the registration form
        $colleges = College::orderBy('name')->get();
        return view('auth.register', compact('colleges'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    'college_id' => ['required', 'exists:colleges,id'], 
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
]);

       $user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'college_id' => $request->college_id, 
    'role' => 'student',
    'is_approved' => false,
]);

        event(new Registered($user));

        // DO NOT LOG THE USER IN. Instead, redirect them to the login page
        // with a status message explaining the next step.
        return redirect(route('login'))->with('status', 'Registration successful! Your account is now pending approval from your college admin.');
    }
}