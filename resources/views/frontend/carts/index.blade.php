@extends('frontend.layouts.app')

@section('content')

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 2000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "toastify-custom toastify-success"
                }).showToast();
            });
        </script>

    @elseif(session('delete'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Toastify({
                    text: "{{ session('delete') }}",
                    duration: 2000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "toastify-custom toastify-error"
                }).showToast();
            });
        </script>
    @endif

    <div class="detail_nav">
        <a href="/">Trang chủ</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="/products">Sản phẩm</a>
    </div>

    <div style="margin-top: 100px"></div>

    <div class="cart" id="cart">
        <section class="cart_section">
            <table class="table table-hover cart_item_prouduct" id="cart-content">
                <thead>
                <tr>
                    <th>Xóa</th>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Khuyến mãi</th>
                    <th>Số lượng</th>
                    <th>Tổng tiền</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($carts))
                    @foreach($carts as $cart)
                        <tr>
                            <td><button class="cart_item_product--remove" value="{{$cart->product_id}}">
                                    <i class="fa-solid fa-xmark"></i>
                                </button></td>
                            <td><img style="width: 40px; height: 40px"
                                     src="{{$cart->image}}" alt=""></td>
                            <td>{{$cart->title}}</td>
                            <td>{{number_format($cart->price * 1000, 0)}}</td>
                            <td>{{number_format(($cart->percent_sale / 100) * $cart->price * 1000, 0)}}</td>
                            <td><input class="form-control cart_item_product--change" data-id="{{$cart->product_id}}" style="width: 80px" type="number" value="{{$cart->quantity}}"></td>
                            <?php
                                $total_price = $cart->quantity * (1 - ($cart->percent_sale / 100)) * $cart->price
                                ?>
                            <td>{{number_format($total_price * 1000, 0)}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>Không có sản phẩm nào trong giỏ hàng</td>
                    </tr>
                @endif

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
                        <td>Tổng phụ</td>
                        <td>{{number_format($price * 1000, 0)}}</td>
                    </tr>
                    <tr>
                        <td>Phí vận chuyển</td>
                        <td>30,000</td>
                    </tr>
                    <tr>
                        <td><strong>Tổng tiền</strong></td>
                        <td><strong>{{number_format($price * 1000 - 30000, 0)}}</strong></td>
                    </tr>
                </table>
                <br>
                <button class="btn btn-danger" style="margin-left: 100px">
                    <a href="/checkout" style="text-decoration: none; color: white; margin-top: 4px">Tiến hành thanh
                        toán</a>
                </button>
            </div>
        </section>
        <div style="margin-bottom: 100px"></div>
    </div>

@endsection
