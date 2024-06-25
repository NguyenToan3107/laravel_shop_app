<div class="products">
    <div class="product_list" style="margin-top: 50px">
        @foreach($involve_products as $involve_product)
            <div class="product_item">
                <div class="product_item--sale">
                    <p>-{{$involve_product->percent_sale}}%</p>
                </div>
                <div class="product_item--heart">
                    <i class="fa-regular fa-heart"></i>
                </div>

                <a href="/product_detail" class="product_item--preview">
                    <ion-icon name="eye-outline"></ion-icon>
                </a>

                <div class="product_cart">
                    <div class="product_img">
                        <img class="product_img--cart" src="{{$involve_product->image}}" alt="">
                    </div>
                    <button class="product_cart--button">
                        <ion-icon name="cart-outline"></ion-icon>
                        Thêm vào giỏ hàng
                    </button>
                </div>
                <div class="product_content">
                    <br>
                    <p class="product_price--name">{{$involve_product->title}}</p>
                    <div class="product_price">
                        <p class="product_price--new">{{number_format($involve_product->price * (1 - ($involve_product->pervent_sale / 100)) * 1000, 0)}}</p>
                        <p class="product_price--old">{{number_format($involve_product->price * 1000, 0)}}</p>
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

<div style="margin-top: 50px"></div>

<div class="horizontal-bar">
</div>

