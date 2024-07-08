<div class="banner">
    <div class="banner_category">
        @foreach($categories as $category)
            <div style="cursor: pointer" class="btn-group banner_category--item">
                <div class="banner_category--subitem">
                    <div style="display: flex; flex-direction: row">
                        <img src="{{$category->image}}" alt="{{$category->title}}" class="banner_category--img">
                        <p>
                            {{$category->title}}
                        </p>
                    </div>
                    @if(count($category->children) > 0)
                        <span class="banner_category--subitem--icon-left">
                                <i class="fa-solid fa-angle-right fa-lg" style="color: #a0a3a6;"></i>
                            </span>
                    @endif
                    <ul class="banner_category--sub">
                        <div style="display: flex; flex-direction: column">
                            <x-category-item-banner :category="$category"/>
                        </div>
                        <div class="banner_info_fake">
                            <p style="font-weight: bold">Phân khúc giá</p>
                            <p>Dưới 10 triệu</p>
                            <p>Từ 10 đến 15 triệu</p>
                            <p>Từ 15 đến 20 triệu</p>
                            <p>Từ 20 đến 25 triệu</p>
                            <p>Từ 25 đến 30 triệu</p>
                            <p>Từ 30 đến 35 triệu</p>
                            <p>Từ 35 đến 40 triệu</p>
                        </div>

                        <div class="banner_info_fake">
                            <p style="font-weight: bold">Điện thoại Hot</p>
                            <p>iPhone 15 Pro Max</p>
                            <p>Samsung Galaxy A35</p>
                            <p>Oppo reno12 Series</p>
                            <p>Xiaomi 14</p>
                            <p>Samsung Galaxy M34</p>
                            <p>Xiaomi 14 Ultra 5G</p>
                            <p>OPPO Reno11 F 5G</p>
                            <p>realme C67</p>
                            <p>realme C51 4G 128GB</p>
                            <p>Tecno Camon 30</p>
                            <p>POCO M6</p>
                            <p>Redmi Note 13</p>
                        </div>
                        <div class="banner_info_fake">
                            <p style="font-weight: bold">Hãng máy tính bảng</p>
                            <p>iPad</p>
                            <p>Samsung</p>
                            <p>Xiaomi</p>
                            <p>Lenovo</p>
                            <p>Nokia</p>
                            <p>TCL</p>
                            <p>Masstel</p>
                            <p>Máy đọc sách</p>
                            <p>Kindle</p>
                            <p>Boox</p>
                        </div>
                        <div class="banner_info_fake">
                            <p style="font-weight: bold">Máy tính bảng HOT ⚡</p>
                            <p>iPad Air 2024 HOT and NEW</p>
                            <p>iPad Pro 2024 HOT and NEW</p>
                            <p>Galaxy Tab S9 FE 5G</p>
                            <p>Galaxy Tab S9 Ultra</p>
                            <p>Xiaomi Pad 6 256GB</p>
                            <p>Xiaomi Pad SE</p>
                            <p>Xiaomi Redmi Pad Pro</p>
                        </div>

                    </ul>
                </div>
            </div>
        @endforeach
    </div>

    <div class="swiper" style="margin: 0">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <div class="banner_img swiper-slide">
                <img src="{{asset('assets/frontend/images/banner/1.png')}}" alt="banner">
            </div>
            <div class="banner_img swiper-slide">
                <img src="{{asset('assets/frontend/images/banner/2.png')}}" alt="banner">
            </div>
            <div class="banner_img swiper-slide">
                <img src="{{asset('assets/frontend/images/banner/3.png')}}" alt="banner">
            </div>
            <div class="banner_img swiper-slide">
                <img src="{{asset('assets/frontend/images/banner/4.png')}}" alt="banner">
            </div>
        </div>
        <!-- If we need pagination -->
        {{--        <div class="swiper-pagination" style="color: #fff"></div>--}}

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev" style="color: #fff"></div>
        <div class="swiper-button-next" style="color: #fff"></div>

        <!-- If we need scrollbar -->
        {{--        <div class="swiper-scrollbar"></div>--}}
    </div>

    <div class="image_banner--sub">
        <div class="banner_img--left">
            <img src="{{asset('assets/frontend/images/banner/2.png')}}" alt="banner">
        </div>
        <div class="banner_img--left">
            <img src="{{asset('assets/frontend/images/banner/3.png')}}" alt="banner">
        </div>
        <div class="banner_img--left">
            <img src="{{asset('assets/frontend/images/banner/4.png')}}" alt="banner">
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const swiper = new Swiper('.swiper', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // And if we need scrollbar
            scrollbar: {
                el: '.swiper-scrollbar',
            },
            autoplay: {
                delay: 3000
            }
        });
    </script>
@endpush
