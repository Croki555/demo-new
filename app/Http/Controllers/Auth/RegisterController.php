<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'regex:/^[А-Яа-яЁё]+$/u'],
            'login' => ['required', 'unique:users,login', 'regex:/^[A-Za-z]+$/u'],
            'email' => ['required'],
            'phone' => ['required', 'regex:/^(\+7)\(([0-9]{3})\)([0-9]{2})-([0-9]{2})-([0-9]{3})$/u'],
            'password' => ['required', 'confirmed'],
        ], [
            'name.required' => 'Поле обязательно для заполнения',
            'login.required' => 'Поле обязательно для заполнения',
            'email.required' => 'Поле обязательно для заполнения',
            'phone.required' => 'Поле обязательно для заполнения',
            'password.required' => 'Поле обязательно для заполнения',
            'password.confirmed' => 'Пароли не совпадают',
            'name.regex' => 'Допустимые символы кирилицы',
            'login.regex' => 'Допустимые символы латиницы',
            'login.unique' => 'Данный логин занят',
            'phone.regex' => 'Формат для телефона +7(XXX)XX-XX-XXX',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->login = $request->input('login');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->password = Hash::make($request->input('password'));
        $user->created_at = now();
        $user->updated_at = now();
        $user->save();
        session()->flash('status', 'Пользователь успешно добавлен');
        return response()->json(['status' => route('register')]);
    }
}
