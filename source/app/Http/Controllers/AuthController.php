<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function login(Request $request)
    {
        $creds = $request->only(['username', 'password']);
        $remember = $request->input('remember', false);

        if (!Auth::attempt($creds, $remember)) {
            return back()->with('flash', [
                "error" => "Invalid credentials!"
            ]);
        }

        $request->session()->regenerate();

        return to_route('home');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        return to_route('home');
    }
}
