<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $statuses = Status::all();

        $ordersQuery = Order::where('user_id', auth()->user()->id);
        $days = Order::select('created_at')->get();
        if ($request->query('status') !== null) {
            $ordersQuery->where('status_id', $request->query('status'));
        }

        if ($request->query('day') !== null) {
            $formattedDay = str_pad($request->query('day'), 2, '0', STR_PAD_LEFT);
            $ordersQuery->whereDay('created_at', $formattedDay);
        }

        $orders = $ordersQuery->get();

        if ($orders->count() === 0) {
            $orders = Order::where('user_id', auth()->user()->id)->get();
        }
        return view('profile.index', [
            'categories' =>$categories,
            'orders' => $orders,
            'statuses' => $statuses,
            'days' => $days
        ]);
    }

    public function password(Request $request)
    {
        if (!Auth::attempt(['login' => Auth::user()->login, 'password' => $request->currentPassword])) {
            return response()->json(['errors' => [
                'currentPassword'=> 'Текущий пароль введен неправильно'
            ]], 422);
        }

        $request->validate([
            'currentPassword' => ['required'],
            'password' => ['required', 'confirmed']
        ], [
            'currentPassword.required' => 'Поле обязательно для заполнения',
            'password.required' => 'Поле обязательно для заполнения',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->input('password'));
        $user->save();


        session()->flash('status', 'Пароль успешно изменён');
        return response()->json(['status' => route('profile')]);
    }
}
