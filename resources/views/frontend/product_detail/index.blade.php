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

            <form id="form_choose_option">
                <div class="product_skus">
                    @foreach($product_skus as $product_sku)
                        @if($loop->first)
                            <div class="product_skus--item active">
                                <div class="product_sku_attribute">
                                    @foreach($product_sku->attributeValues as $product_attribute)
                                        <p>{{$product_attribute->value}}</p>
                                    @endforeach
                                </div>
                                <p class="product_sku_price">{{number_format($product_sku->price * 1000, 0)}} đ</p>
                            </div>
                        @else
                            <div class="product_skus--item">
                                <div class="product_sku_attribute">
                                    @foreach($product_sku->attributeValues as $product_attribute)
                                        <p>{{$product_attribute->value}}</p>
                                    @endforeach
                                </div>
                                <p class="product_sku_price">{{number_format($product_sku->price * 1000, 0)}} đ</p>
                            </div>
                        @endif
                    @endforeach
                </div>

                <br>
                @if(isset($product_sku_first_price))
                    <div class="product_star--price" id="product_star--price">
                        <p class="product_star--price--new">{{number_format($product_sku_first_price->price * 1000, 0)}}
                            đ</p>
                        <p class="product_star--price--old">{{number_format($product_sku_first_price->price_old * 1000, 0)}}
                            đ</p>
                        <p class="product_star--discount">-({{$product_sku_first_price->percent_sale}})%</p>
                    </div>
                @else
                    <div class="product_star--price">
                        <p class="product_star--price--new">{{number_format($product->price * (1 - ($product->percent_sale / 100)) * 1000, 0)}}
                            đ</p>
                        <p class="product_star--price--old">{{number_format($product->price * 1000, 0)}} đ</p>
                    </div>
                @endif
                <br>
                <div class="product_detail--quantity">
                    <div class="product_detail--quantity--num">
                        <p>Số lượng: </p>
                        <span class="input-group-text icon-hidden"><i class="fa-solid fa-minus"></i></span>
                        <input type="number" class="form-control" value="0" style="width: 80px;">
                        <span class="input-group-text icon-hidden"><i class="fa-solid fa-plus"></i></span>
                    </div>
                    <button type="submit" class="btn btn-danger product_cart--button" value="{{$product->id}}">Thêm vào giỏ hàng</button>
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
    <div class="product_detail--description">
        <div class="product_detail--content">
            <div class="product_detail--content--desc">
                <p>{!! $product->description !!}</p>
            </div>
            <p>{!! $product->content !!}</p>
        </div>
        <div class="product_detail--stat">
            <p class="stat">Thông số thống kê</p>
            <table class="table table-striped">
                @foreach($product_attributes as $product_attribute)
                    <tr>
                        <td>{{ucwords($product_attribute->name)}}</td>
                        <td>30,000</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div style="margin-top: 140px"></div>
    <div class="product-detail_related">
        <div></div>
        <p>Sản phẩm liên quan</p>
    </div>

    @include('frontend.layouts.content.product.list_product')
@endsection
