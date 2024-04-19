<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('reviews', [
            'orders' => $orders
        ]);
    }
}
