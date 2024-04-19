<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'orderTitle' => ['required'],
            'orderCategory' => ['required'],
            'orderDate' => ['required'],
            'orderImage' => ['required', 'mimes:jpg,png', 'max:' . 24 * 2048]
        ], [
            'orderTitle.required' => 'Поле обязательно для заполнения',
            'orderCategory.required' => 'Поле обязательно для заполнения',
            'orderDate.required' => 'Поле обязательно для заполнения',
            'orderImage.required' => 'Поле обязательно для заполнения',
        ]);

        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->title = $request->input('orderTitle');
        $order->date = $request->input('orderDate');
        $order->category_id = $request->input('orderCategory');

        $image = $request->file('orderImage');
        $exten = $image->getClientOriginalExtension();
        $imageName = Str::random(10) . '.' . $exten;
        Storage::putFileAs('./public/images', $image, $imageName);

        $order->image_path = 'images/' . $imageName;
        $order->created_at = now();
        $order->updated_at = now();
        $order->save();

        session()->flash('status', 'Заявка создана');
        return response()->json(['status' => route('profile')]);
    }

    public function delete(int $id)
    {
        $order = Order::find($id);
        if(!$order) {
            abort(404);
        }
        $order->delete();
        session()->flash('status', 'Заявка удалена');
        return redirect(route('profile'));
    }

    public function get(int $id)
    {
        $order = Order::find($id);
        if(!$order) {
            abort(404);
        }
        return view('order',[
            'order' => $order
        ]);
    }
}
