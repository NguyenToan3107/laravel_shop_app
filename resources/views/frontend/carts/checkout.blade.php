@extends('frontend.layouts.app')

@section('title', 'Tiến hành thanh toán')

@section('content')

    <div class="detail_nav">
        <a href="/">Trang chủ</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="/products">Sản phẩm</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="/cart">Giỏ hàng</a>
    </div>

    <div style="margin-top: 100px"></div>

    <h3 class="checkout_title">Chi tiết hóa đơn</h3>
    <div style="margin-top: 50px"></div>
    <div class="checkout">
        <form class="checkout_form" action="/orders" method="post">
            @csrf
            <div class="checkout_info">
                <div class="mb-3">
                    <label for="" class="form-label">Họ và tên*</label>
                    <input type="text" name="fullname" class="form-control" id="" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Email</label>
                    <input type="text" name="email" class="form-control" id="">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Số điện thoại*</label>
                    <input type="text" name="phone" class="form-control" id="" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Địa chỉ*</label>
                    <input type="text" name="address" class="form-control" id="" required>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Lưu lại thông tin</label>
                </div>

                <div id="map" style="height: 300px; width: 500px;"></div>

            </div>
            <div class="checkout_code">
                @foreach($carts as $cart)
                    <div class="checkout_code-product">
                        <div>
                            <img src="{{$cart->image}}" alt="{{$cart->title}}">
                            <p>{{$cart->title}}</p>
                        </div>
                            <?php
                            $total_price = $cart->quantity * (1 - ($cart->percent_sale / 100)) * $cart->price
                            ?>
                        <p class="checkout_code--product--price">{{number_format($total_price * 1000, 0)}}</p>
                    </div>
                @endforeach
                <table class="table">
                    <tr>
                        <td>Tổng phụ</td>
                        <td>{{number_format( $total * 1000, 0)}} đ</td>
                    </tr>
                    <tr>
                        <td>Shipping</td>
                        <td>30,000</td>
                    </tr>
                    <tr>
                        <td><strong>Tổng tiền</strong></td>
                        <td><strong>{{number_format( $total * 1000 - 30000, 0)}} đ</strong></td>
                    </tr>
                </table>

                <div class="checkout_code--payment">
                    <div class="checkout_code--payment--bank">
                        <div
                            style="display: flex; flex-direction: row; align-content: center; justify-content: space-between">
                            <div>
                                <input type="radio" id="html" name="fav_language" value="HTML">
                                <label for="html">Bank</label><br>
                            </div>
                            <div class="checkout_code--payment--bank">
                                <img src="{{asset('assets/frontend/images/bank/bank1.png')}}" alt="">
                                <img src="{{asset('assets/frontend/images/bank/bank2.png')}}" alt="">
                                <img src="{{asset('assets/frontend/images/bank/bank3.png')}}" alt="">
                                <img src="{{asset('assets/frontend/images/bank/bank4.png')}}" alt="">
                            </div>
                        </div>
                        <input type="radio" id="css" name="fav_language" value="CSS">
                        <label for="css">Cash on delivery</label><br>
                    </div>
                </div>

                <br>
                <div style="display: flex; gap: 10px; flex-direction: row">
                    <input type="text" class="form-control" placeholder="Enter Your Coupon">
                    <button class="btn btn-danger">Áp mã</button>
                </div>
                <br>
                <button type="submit" class="btn btn-danger">Đặt hàng</button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
        <!-- Replace YOUR_API_KEY here by your key above -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwaLDG4ZPsKoA-eKtq0Qr0ztmwoj2uhAA&callback=initMap" async defer></script>
        <script>
            function initMap() {
                var map = new google.maps.Map(document.getElementById("map"), {
                    center: { lat: 21.0168864, lng: 105.7855574 },
                    zoom: 15
                });
            }
        </script>


{{--    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"--}}
{{--          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>--}}
{{--    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"--}}
{{--            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>--}}
{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            var map = L.map('map').setView([51.505, -0.09], 13);--}}
{{--            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {--}}
{{--                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'--}}
{{--            }).addTo(map);--}}
{{--        });--}}
{{--    </script>--}}

@endpush
