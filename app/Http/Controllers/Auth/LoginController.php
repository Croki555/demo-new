<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authentificate(Request $request)
    {
        $data = $request->only('login', 'password');
        if(Auth::attempt($data)) {
            if(auth('web')->user()->is_admin === 1) {
                return response()->json(['status' => route('admin')], 200);
            }else {
                return response()->json(['status' => route('profile')], 200);
            }
        }
        return response()->json(['error' => 'Не правильный логин или пароль'], 422);
    }

    public function logout()
    {
        session()->invalidate();
        session()->regenerateToken();

        auth('web')->logout();

        return redirect(route('home'));
    }
}
