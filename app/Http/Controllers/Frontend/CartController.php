<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        $carts = json_decode(Cookie::get('cart'));
        $price = 0;
        if ($carts) {
            foreach ($carts as $cart) {
                $price += $cart->price * $cart->quantity * (1 - ($cart->percent_sale / 100));
            }
        } else {
            $carts = []; // Nếu không có sản phẩm, gán $carts là một mảng rỗng để tránh lỗi khi truy cập vào biến trong view
        }
        return view('frontend.carts.index', [
            'carts' => $carts,
            'price' => $price
        ]);
    }

    public function addToCart(Request $request, $id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                abort(404, 'Product not found');
            }

            // Lấy giỏ hàng từ cookie và chuyển đổi từ JSON sang mảng
            $cart = json_decode($request->cookie('cart'), true) ?? [];

            // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
            if (isset($cart[$id])) {
                // Nếu đã tồn tại, tăng số lượng
                $cart[$id]['quantity']++;
            } else {
                // Nếu chưa tồn tại, thêm mới vào giỏ hàng
                $cart[$id] = [
                    "product_id" => $product->id,
                    "title" => $product->title,
                    "percent_sale" => $product->percent_sale,
                    "quantity" => 1,
                    "price" => $product->price,
                    "image" => $product->image
                ];
            }

            // Lưu giỏ hàng vào cookie
            $cookie = cookie('cart', json_encode($cart), 60 * 24 * 30); // Cookie có thời hạn là 30 ngày
            return redirect()->back()->withCookie($cookie)->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }


    public function updateToCart(Request $request, $id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                abort(404, 'Product not found');
            }

            // Lấy giỏ hàng từ cookie và chuyển đổi từ JSON sang mảng
            $cart = json_decode($request->cookie('cart'), true) ?? [];

            // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
            if (isset($cart[$id])) {
                // Nếu đã tồn tại, tăng số lượng
                $cart[$id]['quantity'] = $request->quantity;
            }
            // Lưu giỏ hàng vào cookie
            $cookie = cookie('cart', json_encode($cart), 60 * 24 * 30); // Cookie có thời hạn là 30 ngày
            return redirect()->back()->withCookie($cookie)->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    public function removeFromCart(Request $request, $id)
    {
        $carts = json_decode(Cookie::get('cart'), true) ?? [];
        if (isset($carts[$id])) {
            unset($carts[$id]);
        }
        $cookie = cookie('cart', json_encode($carts), 60 * 24 * 30);
        return redirect()->back()->withCookie($cookie);
    }
}
