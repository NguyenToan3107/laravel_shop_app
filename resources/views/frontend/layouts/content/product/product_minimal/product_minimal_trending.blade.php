<div class="products">
    <div class="product-detail_related">
        <div></div>
        <p>Thịnh hành</p>
    </div>
    <div class="product-detail_related--content">
        <h4>Xu hướng hiện nay</h4>
        <button class="btn btn-danger">Xem thêm sản phẩm</button>
    </div>
    <div class="product_list" style="margin-top: 60px">
        @foreach($product_trending as $product_trend)
            <div class="product_item">
                <div class="product_item--sale">
                    <p>-{{$product_trend->percent_sale}}%</p>
                </div>
                <div class="product_item--heart">
                    <i class="fa-regular fa-heart"></i>
                </div>

                <a href="/product_detail/{{$product_trend->slug}}" class="product_item--preview">
                    <ion-icon name="eye-outline"></ion-icon>
                </a>
                <a href="/product_detail/{{$product_trend->slug}}" value="{{$product_trend->slug}}">
                    <div class="product_cart">
                        <div class="product_img">
                            <img class="product_img--cart" src="{{$product_trend->image}}" alt="">
                        </div>
                        <button class="product_cart--button" value="{{$product_trend->id}}">
                            <ion-icon name="cart-outline"></ion-icon>
                            Thêm vào giỏ hàng
                        </button>
                    </div>
                </a>
                <div class="product_content">
                    <br>
                    <p class="product_price--name">{{$product_trend->title}}</p>
                    <div class="product_price">
                        <p class="product_price--new">{{number_format($product_trend->price_old * 1000, 0)}}</p>
                        <p class="product_price--old">{{number_format($product_trend->price * 1000, 0)}}</p>
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
