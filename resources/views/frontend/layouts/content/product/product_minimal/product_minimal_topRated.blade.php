<div class="products">
    <div class="product-detail_related">
        <div></div>
        <p>This month</p>
    </div>
    <div class="product-detail_related--content">
        <h4>Sản phẩm bán chạy nhất</h4>
        <button class="btn btn-danger">Xem thêm sản phẩm</button>
    </div>
    <div class="product_list" style="margin-top: 60px">
        @foreach($products_top_rated as $products_top_rate)
            <div class="product_item">
                <div class="product_item--sale">
                    <p>-{{$products_top_rate->percent_sale}}%</p>
                </div>
                <div class="product_item--heart">
                    <i class="fa-regular fa-heart"></i>
                </div>

                <a href="/product_detail/{{$products_top_rate->slug}}" class="product_item--preview">
                    <ion-icon name="eye-outline"></ion-icon>
                </a>
                <a href="/product_detail/{{$products_top_rate->slug}}" value="{{$products_top_rate->slug}}">
                    <div class="product_cart">
                        <div class="product_img">
                            <img class="product_img--cart" src="{{$products_top_rate->image}}" alt="">
                        </div>
                        <button class="product_cart--button" value="{{$products_top_rate->id}}">
                            <ion-icon name="cart-outline"></ion-icon>
                            Thêm vào giỏ hàng
                        </button>
                    </div>
                </a>
                <div class="product_content">
                    <br>
                    <p class="product_price--name">{{$products_top_rate->title}}</p>
                    <div class="product_price">
                        <p class="product_price--new">{{number_format($products_top_rate->price_old * 1000, 0)}}</p>
                        <p class="product_price--old">{{number_format($products_top_rate->price * 1000, 0)}}</p>
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

<div style="margin-top: 50px"></div>

<div class="horizontal-bar">
</div>
