@extends('frontend.layouts.app')

@section('content')

    <div class="detail_nav">
        <a href="/">Trang chủ</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="/products">Sản phẩm</a>
    </div>

    <div style="margin-top: 100px"></div>



    <div class="cart">
        <section>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Remove</td>
                        <td>Image</td>
                        <td>Product</td>
                        <td>Price</td>
                        <td>Quantity</td>
                        <td>Subtotal</td>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td><a href="#" style="color: black"><i class="fa-solid fa-xmark"></i></a></td>
                    <td><img style="width: 40px; height: 40px" src="{{asset('assets/frontend/images/products/bag.png')}}" alt=""></td>
                    <td>Cartoon Astronaut T-Shirt</td>
                    <td>$118.19</td>
                    <td><input class="form-control" style="width: 80px" type="number" value="1"></td>
                    <td>$118.19</td>
                </tr>
                <tr>
                    <td><a href="#" style="color: black"><i class="fa-solid fa-xmark"></i></a></td>
                    <td><img style="width: 40px; height: 40px" src="{{asset('assets/frontend/images/products/bag.png')}}" alt=""></td>
                    <td>Cartoon Astronaut T-Shirt</td>
                    <td>$118.19</td>
                    <td><input class="form-control" style="width: 80px" type="number" value="1"></td>
                    <td>$118.19</td>
                </tr>
                <tr>
                    <td><a href="#" style="color: black"><i class="fa-solid fa-xmark"></i></a></td>
                    <td><img style="width: 40px; height: 40px" src="{{asset('assets/frontend/images/products/bag.png')}}" alt=""></td>
                    <td>Cartoon Astronaut T-Shirt</td>
                    <td>$118.19</td>
                    <td><input class="form-control" style="width: 80px" type="number" value="1"></td>
                    <td>$118.19</td>
                </tr>
                </tbody>
            </table>
        </section>

        <br>
        <br>
        <br>
        <section class="cart_option">
            <div class="cart_option--coupon">
                <h3>Mã giảm giá</h3>
                <div style="display: flex; gap: 10px; flex-direction: row">
                    <input type="text" class="form-control" placeholder="Enter Your Coupon">
                    <button class="btn btn-danger">Apply</button>
                </div>
            </div>
            <div class="cart_option--subtotal">
                <h3>Cart Totals</h3>
                <table class="table">
                    <tr>
                        <td>Cart Subtotal</td>
                        <td>$ 335</td>
                    </tr>
                    <tr>
                        <td>Shipping</td>
                        <td>Free</td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>$ 335</strong></td>
                    </tr>
                </table>
                <br>
                <button class="btn btn-danger" style="margin-left: 100px">
                    <a href="/checkout" style="text-decoration: none; color: white; margin-top: 4px">Tiến hành thanh toán</a>
                </button>
            </div>
        </section>
        <div style="margin-bottom: 100px"></div>
    </div>

@endsection
