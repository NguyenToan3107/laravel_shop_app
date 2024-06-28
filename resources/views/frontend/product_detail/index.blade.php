@extends('frontend.layouts.app')

@section('content')
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>
    <div class="detail_nav">
        <a href="/">Trang chủ</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="/products">Sản phẩm</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="#">Chi tiết</a>
    </div>
    <div style="margin-top: 100px"></div>
    <div class="product-detail">
        <div class="product-detail--image">
            <div class="product-detail_subimg">
                @foreach($product_images as $product_image)
                    <div class="product-detail_subimg--detail">
                        <img src="{{$product_image->image_url}}" alt="">
                    </div>
                @endforeach

            </div>
            <div class="product-detail_img">
                <img src="{{$product->image}}" alt="{{$product->title}}">
            </div>
        </div>
        <div class="product-detail_info">
            <h3>{{$product->title}}</h3>
            <div class="product_star">
                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                (150 Reviews)
            </div>
{{--            <div class="product_star--price">--}}
{{--                <p class="product_star--price--new">{{number_format($product->price * (1 - ($product->percent_sale / 100)) * 1000, 0)}} đ</p>--}}
{{--                <p class="product_star--price--old">{{number_format($product->price * 1000, 0)}} đ</p>--}}
{{--            </div>--}}
            <p>{{$product->description}}</p>

            <form id="form_choose_option">
                <div class="product-detail--capacity">
                    @foreach($capacities as $capacity)
                        @if($loop->first)
                            @if($capacity->value == 1000)
                                <p class="active" data-id="{{$product->id}}"
                                   data-capacity="{{$capacity->value}}">{{$capacity->value / 1000}} TB</p>
                            @else
                                <p class="active" data-id="{{$product->id}}" data-capacity="{{$capacity->value}}">{{$capacity->value}} GB</p>
                            @endif
                        @else
                            @if($capacity->value == 1000)
                                <p data-id="{{$product->id}}" data-capacity="{{$capacity->value}}">{{$capacity->value / 1000}} TB</p>
                            @else
                                <p data-id="{{$product->id}}" data-capacity="{{$capacity->value}}">{{$capacity->value}} GB</p>
                            @endif
                        @endif
                    @endforeach
                </div>

                <div class="product-detail--color">
                    @foreach($colors as $color)
                        @if($loop->first)
                            <p class="active" data-id="{{$product->id}}" data-color="{{$color->value}}">{{$color->value}}</p>
                        @else
                            <p data-id="{{$product->id}}" data-color="{{$color->value}}">{{$color->value}}</p>
                        @endif
                    @endforeach
                </div>
                <br>
                <div class="product_star--price" id="product_star--price">
                    <p class="product_star--price--new">{{number_format($sku_first->price * 1000, 0)}} đ</p>
                    <p class="product_star--price--old">{{number_format($sku_first->price_old * 1000, 0)}} đ</p>
                    <p class="product_star--discount">-({{$sku_first->percent_sale}})%</p>
                </div>
                <br>
                <div class="product_detail--quantity">
                    <div class="product_detail--quantity--num">
                        <p>Số lượng: </p>
                        <span class="input-group-text icon-hidden"><i class="fa-solid fa-minus"></i></span>
                        <input type="number" class="form-control" value="0" style="width: 80px;">
                        <span class="input-group-text icon-hidden"><i class="fa-solid fa-plus"></i></span>
                    </div>
                    <button type="submit" class="btn btn-danger" value="{{$product->id}}">Thêm vào giỏ hàng</button>
                    <button type="submit" class="btn btn-secondary"><i class="fa-regular fa-heart"></i></button>
                </div>
            </form>

            <br>
            <br>

            <div class="product-detail_delivery">
                <div class="product-detail_info--deliver">
                    <img src="{{asset('assets/frontend/images/car.png')}}" alt="">
                    <div>
                        <h6>Free Delivery</h6>
                        <p style="font-size: 0.8rem">Enter your postal code for Delivery Availability</p>
                    </div>
                </div>

                <div class="product-detail_info--deliver">
                    <img src="{{asset('assets/frontend/images/return.png')}}" alt="">
                    <div>
                        <h6>Return Delivery</h6>
                        <p style="font-size: 0.8rem">Free 30 Days Delivery Returns. Details</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div style="margin-top: 140px"></div>
    <div class="product-detail_related">
        <div></div>
        <p>Sản phẩm liên quan</p>
    </div>

    @include('frontend.layouts.content.product.list_product')
@endsection
