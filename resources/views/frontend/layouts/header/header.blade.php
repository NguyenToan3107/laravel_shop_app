<header>
    <div class="header_nav">
        <div class="header_nav--logo" style="cursor: pointer"><a style="text-decoration: none; color: black" href="/">Exclusive</a>
        </div>
        <div class="header_nav--nav">
            {{--            <a href="/">Home</a>--}}
            <a href="/products">Sản phẩm</a>
            <a href="/">About</a>
            <a href="/contact">Liên hệ</a>
            @if(Auth::check() && Auth::user()->can('view-post'))
                <a href="/posts">Bài viết</a>
            @endif
        </div>
        <div class="header_nav--right">
            <div class="input-group input-group-sm mb-3 header_nav--right--hidden" style="margin-top: 14px;">
                <form method="GET" class="form-search-global">
                    <div class="row">
                        <div class="form-group">
                            <input type="text" name="titlesearch" class="form-control search_product"
                                   id="search_product" placeholder="Enter Title For Search"
                                   value="{{ old('titlesearch') }}">
                        </div>
                    </div>
                    @if(isset($items))
                        <ul class="search_list" id="search_list">
                            @foreach($items as $item)
                                <a href="/product_detail/{{$item->slug}}" class="search_item">
                                    <img src="{{$item->image}}" alt="{{$item->title}}">
                                    <div class="search_item--info">
                                        <p>{{$item->title}}</p>
                                        <div class="search_item--price">
                                            <p class="search_price_new">{{number_format($item->price * 1000, 0)}} đ</p>
                                            <p class="search_price_old">{{number_format($item->price_old * 1000, 0)}}
                                                đ</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                            {{-- spinner --}}
                            <div id="overlay1">
                                <div class="cv-spinner1">
                                    <span class="spinner1"></span>
                                </div>
                            </div>

                            <div id="overlay2">
                                <div class="cv-spinner2">
                                    <span class="spinner2"></span>
                                </div>
                            </div>
                        </ul>
                    @endif
                </form>
            </div>
            <span class="header_nav--right--hidden header_heart_icon">
                <i class="fa-regular fa-heart"></i>
            </span>
            <a href="/cart" class="header_identify header_count_cart"
               style="text-decoration: none; color: black; margin-top: 4px">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
            <div class="dropdown">

                @if(Auth::check())
                    <img src="{{Auth::user()->image_path}}" alt="{{Auth::user()->name}}"
                         class="dropdown-toggle" data-bs-toggle="dropdown">
                @else
                    <img src="{{asset('images/users/default_user.jpg')}}" alt="Default User"
                         class="dropdown-toggle" data-bs-toggle="dropdown">
                @endif

                <ul class="dropdown-menu" style="width: 50px">
                    @if(Auth::check())
                        <li><a class="dropdown-item" href="/profile">Hồ Sơ</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{route('logout')}}" onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                   style="margin-left: 16px; text-decoration: none; color: black">
                                    Đăng xuất
                                </a>
                            </form>
                        </li>
                        <li><a class="dropdown-item" href="/orders/my-order">Đơn mua</a></li>
                    @else
                        <li><a class="dropdown-item" href="/login">Đăng nhập</a></li>
                    @endif
                    @if(Auth::check() && Auth::user()->can('view-dashboard'))
                        <li><a class="dropdown-item" href="/admin/dashboard">Admin</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <button class="menu-toggle" id="menu-toggle">☰</button>
    </div>
</header>
<div class="horizontal-bar">
</div>

