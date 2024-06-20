<header>
    <div class="header_nav">
        <div class="header_nav--logo">Exclusive</div>
        <div class="header_nav--nav">
            <a href="/">Home</a>
            <a href="/products">Sản phẩm</a>
            <a href="/">About</a>
            <a href="/contact">Liên hệ</a>
            @if(Auth::check() && Auth::user()->can('view-post'))
                <a href="/post">Bài viết</a>
            @endif
        </div>
        <div class="header_nav--right">
            <div class="input-group input-group-sm mb-3" style="margin-top: 14px">
                <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)"
                       placeholder="Bạn đang tìm kiếm thứ gì">
                <span class="input-group-text"><ion-icon name="search-outline"></ion-icon></span>
            </div>
            <span>
                <ion-icon name="heart-outline"></ion-icon>
            </span>
            <a href="/cart" style="text-decoration: none; color: black; margin-top: 4px">
                <ion-icon name="cart-outline"></ion-icon>
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
                    @else
                        <li><a class="dropdown-item" href="/login">Đăng nhập</a></li>
                    @endif
                    @if(Auth::check() && Auth::user()->can('view-dashboard'))
                        <li><a class="dropdown-item" href="/admin/dashboard">Admin</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</header>
<br>
<div class="horizontal-bar">
</div>
