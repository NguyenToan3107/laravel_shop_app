<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class OrderController extends Controller
{
    public function index()
    {
//        $carts = json_decode(Cookie::get('cart'), true) ?? [];
        $carts = json_decode(Cookie::get('cart'));
        $total = 0;
        if ($carts) {
            foreach ($carts as $cart) {
                $total += $cart->price * $cart->quantity;
            }
        } else {
            $carts = []; // Nếu không có sản phẩm, gán $carts là một mảng rỗng để tránh lỗi khi truy cập vào biến trong view
        }
        return view('frontend.carts.checkout', [
            'carts' => $carts,
            'total' => $total
        ]);
    }
    public function store(Request $request) {
        $carts = json_decode(Cookie::get('cart'));

        $total = 0;
        if ($carts) {
            foreach ($carts as $cart) {
                $total += $cart->price * $cart->quantity;
            }
        } else {
            $carts = []; // Nếu không có sản phẩm, gán $carts là một mảng rỗng để tránh lỗi khi truy cập vào biến trong view
        }

        // create order
        $order = Order::create([
            'fullname' => request('fullname'),
            'phone' => request('phone'),
            'address' => request('address'),
            'status' => 1,
            'price' => $total
        ]);

        // create order detail
        foreach ($carts as $cart) {
            OrderDetail::create([
                'item_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'unit_price' => $cart->price,
                'order_id' => $order->id
            ]);
        }

        return redirect('/cart')->with('success', 'Bạn đã đặt hàng thành công!');
    }
}