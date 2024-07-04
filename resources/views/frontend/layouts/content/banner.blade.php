<div class="banner">
    <div class="banner_category">
        @foreach($categories as $category)
            <div style="cursor: pointer" class="btn-group dropend banner_category--item">
                <div class="banner_category--subitem" data-bs-toggle="dropdown">
                    <div style="display: flex; flex-direction: row">
                        <img src="{{$category->image}}" alt="{{$category->title}}" class="banner_category--img">
                        <p>
                            {{$category->title}}
                        </p>
                    </div>
                    @if(count($category->children) > 0)
                        <span>
                            <i class="fa-solid fa-angle-right fa-lg" style="color: #a0a3a6;"></i>
                        </span>
                    @endif
                </div>
                <ul class="dropdown-menu">
                    <x-category-item-banner :category="$category"/>
                </ul>
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
