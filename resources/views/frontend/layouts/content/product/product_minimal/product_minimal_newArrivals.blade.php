<div class="products">
    <div class="product-detail_related">
        <div></div>
        <p>Mới ra mắt</p>
    </div>
    <div style="margin-top: 15px; display: flex; justify-content: space-between">
        <div>
            <h4>Flash Sales</h4>
            <div class=""></div>
        </div>
        <div style="display: flex; flex-direction: row; gap: 20px">
            <div class="category_arrow"><i class="fa-solid fa-arrow-left"></i></div>
            <div class="category_arrow"><i class="fa-solid fa-arrow-right"></i></div>
        </div>
    </div>
    <div class="product_list" style="margin-top: 50px">
        @foreach($products_new_arivals as $products_new_arival)
            <div class="product_item">
                <div class="product_item--sale">
                    <p>-{{$products_new_arival->percent_sale}}%</p>
                </div>
                <div class="product_item--heart">
                    <i class="fa-regular fa-heart"></i>
                </div>

                <a href="/product_detail/{{$products_new_arival->slug}}" class="product_item--preview">
                    <ion-icon name="eye-outline"></ion-icon>
                </a>
                <a href="/product_detail/{{$products_new_arival->slug}}" value="{{$products_new_arival->slug}}">
                    <div class="product_cart">
                        <div class="product_img">
                            <img class="product_img--cart" src="{{$products_new_arival->image}}" alt="">
                        </div>
                        <button class="product_cart--button" value="{{$products_new_arival->id}}">
                            <ion-icon name="cart-outline"></ion-icon>
                            Thêm vào giỏ hàng
                        </button>
                    </div>
                </a>
                <div class="product_content">
                    <br>
                    <p class="product_price--name">{{$products_new_arival->title}}</p>
                    <div class="product_price">
                        <p class="product_price--new">{{number_format($products_new_arival->price_old * 1000, 0)}}</p>
                        <p class="product_price--old">{{number_format($products_new_arival->price * 1000, 0)}}</p>
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
{{--<div style="margin-top: 50px; display: flex; justify-content: center">--}}
{{--    <button class="btn btn-danger">Xem thêm sản phẩm</button>--}}
{{--</div>--}}

<div style="margin-top: 50px"></div>

{{--<div class="horizontal-bar">--}}
{{--</div>--}}

