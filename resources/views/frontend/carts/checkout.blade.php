@extends('frontend.layouts.app')

@section('content')

    <div class="detail_nav">
        <a href="/">Trang chủ</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="/products">Sản phẩm</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="/cart">Giỏ hàng</a>
    </div>

    <div style="margin-top: 100px"></div>

    <h3 class="checkout_title">Billing Details</h3>
    <div style="margin-top: 50px"></div>
    <div class="checkout">
        <form class="checkout_form">
            <div class="checkout_info">
                <div class="mb-3">
                    <label for="" class="form-label">First Name*</label>
                    <input type="text" class="form-control" id="" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Company Name</label>
                    <input type="text" class="form-control" id="">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Street Address*</label>
                    <input type="text" class="form-control" id="">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Apartment, floor, etc. (optional)</label>
                    <input type="text" class="form-control" id="">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Town/City*</label>
                    <input type="text" class="form-control" id="">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Phone Number*</label>
                    <input type="text" class="form-control" id="">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Email Address*</label>
                    <input type="text" class="form-control" id="">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Save this information for faster check-out next
                        time</label>
                </div>
            </div>
            <div class="checkout_code">

                <div class="checkout_code-product">
                    <div>
                        <img src="{{asset('assets/frontend/images/products/bag.png')}}" alt="">
                        <p>LCD Monitor</p>
                    </div>
                    <p class="checkout_code--product--price">$650</p>
                </div>
                <div class="checkout_code-product">
                    <div>
                        <img src="{{asset('assets/frontend/images/products/bag.png')}}" alt="">
                        <p>LCD Monitor</p>
                    </div>
                    <p class="checkout_code--product--price">$650</p>
                </div>

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
                    <button class="btn btn-danger">Apply</button>
                </div>
                <br>
                <button type="submit" class="btn btn-danger">Place Order</button>
            </div>
        </form>
    </div>

@endsection

