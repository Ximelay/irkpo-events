<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
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
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'admin_firstName' => ['required', 'string', 'max:100'],
            'admin_lastName' => ['required', 'string', 'max:100'],
            'admin_middleName' => ['nullable', 'string', 'max:100'],
            'admin_email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Admin::class],
            'admin_password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $admin = Admin::create([
            'admin_firstName' => $request->admin_firstName,
            'admin_lastName' => $request->admin_lastName,
            'admin_middleName' => $request->admin_middleName,
            'admin_email' => $request->admin_email,
            'admin_password' => Hash::make($request->admin_password),
            'admin_isActive' => 1, // По умолчанию
        ]);

        event(new Registered($admin));

        Auth::login($admin);

        return redirect(route('dashboard', absolute: false));
    }
}
