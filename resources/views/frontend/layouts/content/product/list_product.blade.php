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

                <a href="/product_detail/{{$involve_product->slug}}" class="product_item--preview">
                    <ion-icon name="eye-outline"></ion-icon>
                </a>
                <a href="/product_detail/{{$involve_product->slug}}" value="{{$involve_product->slug}}">
                    <div class="product_cart">
                        <div class="product_img">
                            <img class="product_img--cart" src="{{$involve_product->image}}" alt="">
                        </div>
                        <button class="product_cart--button" value="{{$involve_product->id}}">
                            <ion-icon name="cart-outline"></ion-icon>
                            Thêm vào giỏ hàng
                        </button>
                    </div>
                </a>
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

<div id="num_more_product_detail" style="margin-top: 50px; display: flex; justify-content: center">
    @if($count_product < \App\Utils\Util::num_page_product_detail and $count_product > 0)
        <button class="btn btn-danger product_more_view_detail" data-id="{{$product->id}}" value="{{$count_product}}">Xem thêm {{$count_product}} sản phẩm</button>
    @elseif($count_product >= \App\Utils\Util::num_page_product_detail)
        <button class="btn btn-danger product_more_view_detail" data-id="{{$product->id}}" value="{{\App\Utils\Util::num_page_product_detail}}">
            Xem thêm {{\App\Utils\Util::num_page_product_detail}} sản phẩm
        </button>
    @endif
</div>

<div style="margin-top: 50px"></div>

<div class="horizontal-bar">
</div>

