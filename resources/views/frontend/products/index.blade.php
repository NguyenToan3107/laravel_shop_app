@extends('frontend.layouts.app')

@section('content')
    <div class="products">
        <div class="products_top">
            <p>Wishlist (4)</p>
            <button class="btn btn-secondary">Move To The Bag</button>
        </div>
        <div class="product_list" style="margin-top: 100px">
            <div class="product_item">
                <a href="/product_detail" class="product_item">
                    <div class="product_item--sale">
                        <p>-40%</p>
                    </div>
                    <span class="product_item--heart">
                        <i class="fa-regular fa-heart"></i>
                    </span>

                    <span class="product_item--preview">
                        <ion-icon name="eye-outline"></ion-icon>
                    </span>

                    <div class="product_cart">
                        <div class="product_img">
                            <img class="product_img--cart" src="{{asset('assets/frontend/images/products/bag.png')}}" alt="">
                        </div>
                        <button class="product_cart--button"><ion-icon name="cart-outline"></ion-icon> Thêm vào giỏ hàng</button>
                    </div>
                    <div class="product_content">
                        <br>
                        <a href="/product_detail" class="product_price--name">Gucci Gacbaga bag</a>
                        <div class="product_price">
                            <p class="product_price--new">$960</p>
                            <p class="product_price--old">$1000</p>
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
                </a>
            </div>
            <div class="product_item">
                <a href="/product_detail" class="product_item">
                    <div class="product_item--sale">
                        <p>-40%</p>
                    </div>
                    <span class="product_item--heart">
                        <i class="fa-regular fa-heart"></i>
                    </span>

                    <span class="product_item--preview">
                        <ion-icon name="eye-outline"></ion-icon>
                    </span>

                    <div class="product_cart">
                        <div class="product_img">
                            <img class="product_img--cart" src="{{asset('assets/frontend/images/products/bag.png')}}" alt="">
                        </div>
                        <button class="product_cart--button"><ion-icon name="cart-outline"></ion-icon> Thêm vào giỏ hàng</button>
                    </div>
                    <div class="product_content">
                        <br>
                        <a href="/product_detail" class="product_price--name">Gucci Gacbaga bag</a>
                        <div class="product_price">
                            <p class="product_price--new">$960</p>
                            <p class="product_price--old">$1000</p>
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
                </a>
            </div>
            <div class="product_item">
                <a href="/product_detail" class="product_item">
                    <div class="product_item--sale">
                        <p>-40%</p>
                    </div>
                    <span class="product_item--heart">
                        <i class="fa-regular fa-heart"></i>
                    </span>

                    <span class="product_item--preview">
                        <ion-icon name="eye-outline"></ion-icon>
                    </span>

                    <div class="product_cart">
                        <div class="product_img">
                            <img class="product_img--cart" src="{{asset('assets/frontend/images/products/bag.png')}}" alt="">
                        </div>
                        <button class="product_cart--button"><ion-icon name="cart-outline"></ion-icon> Thêm vào giỏ hàng</button>
                    </div>
                    <div class="product_content">
                        <br>
                        <a href="/product_detail" class="product_price--name">Gucci Gacbaga bag</a>
                        <div class="product_price">
                            <p class="product_price--new">$960</p>
                            <p class="product_price--old">$1000</p>
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
                </a>
            </div>
            <div class="product_item">
                <a href="/product_detail" class="product_item">
                    <div class="product_item--sale">
                        <p>-40%</p>
                    </div>
                    <span class="product_item--heart">
                        <i class="fa-regular fa-heart"></i>
                    </span>

                    <span class="product_item--preview">
                        <ion-icon name="eye-outline"></ion-icon>
                    </span>

                    <div class="product_cart">
                        <div class="product_img">
                            <img class="product_img--cart" src="{{asset('assets/frontend/images/products/bag.png')}}" alt="">
                        </div>
                        <button class="product_cart--button"><ion-icon name="cart-outline"></ion-icon> Thêm vào giỏ hàng</button>
                    </div>
                    <div class="product_content">
                        <br>
                        <a href="/product_detail" class="product_price--name">Gucci Gacbaga bag</a>
                        <div class="product_price">
                            <p class="product_price--new">$960</p>
                            <p class="product_price--old">$1000</p>
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
                </a>
            </div>
            <div class="product_item">
                <a href="/product_detail" class="product_item">
                    <div class="product_item--sale">
                        <p>-40%</p>
                    </div>
                    <span class="product_item--heart">
                        <i class="fa-regular fa-heart"></i>
                    </span>

                    <span class="product_item--preview">
                        <ion-icon name="eye-outline"></ion-icon>
                    </span>

                    <div class="product_cart">
                        <div class="product_img">
                            <img class="product_img--cart" src="{{asset('assets/frontend/images/products/bag.png')}}" alt="">
                        </div>
                        <button class="product_cart--button"><ion-icon name="cart-outline"></ion-icon> Thêm vào giỏ hàng</button>
                    </div>
                    <div class="product_content">
                        <br>
                        <a href="/product_detail" class="product_price--name">Gucci Gacbaga bag</a>
                        <div class="product_price">
                            <p class="product_price--new">$960</p>
                            <p class="product_price--old">$1000</p>
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
                </a>
            </div>
        </div>
    </div>
    <div class="pagination_product">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Trước</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Sau</a></li>
            </ul>
        </nav>
    </div>
@endsection
