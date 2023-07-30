<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class AuthController extends Controller
{

    public function login(): Response|RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return inertia('Login');
    }

    public function logar(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($request->only('email', 'password'))) {
            return redirect()->route('home');
        }

        return redirect()->back()->withErrors(['email' => 'Email ou senha inválidos.']);
    }
}
