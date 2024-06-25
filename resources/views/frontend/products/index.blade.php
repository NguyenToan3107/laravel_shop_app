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

    @include('frontend.layouts.content.category')

    <div class="products">
        <div class="products_top">
            <p>Wishlist (4)</p>
            <button class="btn btn-secondary">Move To The Bag</button>
        </div>
        <div class="product_list" style="margin-top: 100px">
            @foreach($products as $product)
                <div class="product_item">
                    @if($product->percent_sale > 0)
                        <div class="product_item--sale">
                            <p>-{{$product->percent_sale}}%</p>
                        </div>
                    @endif
                    <span class="product_item--heart">
                        <i class="fa-regular fa-heart"></i>
                    </span>

                    <span class="product_item--preview">
                        <ion-icon name="eye-outline"></ion-icon>
                    </span>
                    <a class="product_cart--item" href="/product_detail/{{$product->id}}" value="{{$product->id}}">
                        <div class="product_cart">
                            <div class="product_img">
                                <img class="product_img--cart" src="{{$product->image}}" alt="">
                            </div>
                            <button class="product_cart--button" value="{{$product->id}}">
                                <ion-icon name="cart-outline"></ion-icon>
                                Thêm vào giỏ hàng
                            </button>
                        </div>
                    </a>
                    <div class="product_content">
                        <br>
                        <a href="/product_detail" class="product_price--name">{{$product->title}}</a>
                        <div class="product_price">
                            <p class="product_price--new">{{number_format((1 - ($product->percent_sale / 100)) * $product->price * 1000, 0)}}</p>
                            <p class="product_price--old">{{number_format($product->price * 1000, 0)}}</p>
                        </div>
                        <div class="product_star">
                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                            (70)
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div style="margin-top: 50px; display: flex; justify-content: center">
        <button class="btn btn-danger">Xem thêm sản phẩm</button>
    </div>
@endsection
