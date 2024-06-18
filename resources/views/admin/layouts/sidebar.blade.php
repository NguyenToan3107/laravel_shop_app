<aside id="sidebar">
    <div class="h-100">
        <div class="sidebar-logo">
            <a href="#">ADMIN</a>
        </div>
        <!-- Sidebar Navigation -->
        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Công cụ và thành phần hỗ trợ
            </li>
            <li class="sidebar-item">
                <a href="{{route('profile.edit')}}" class="sidebar-link">
                    <i class="fa-solid fa-list pe-2"></i>
                    Hồ sơ
                </a>
            </li>
            @can('view-dashboard')
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard"
                       aria-expanded="false" aria-controls="dashboard">
                        <i class="fa-solid fa-sliders pe-2"></i>
                        Dashboard
                    </a>
                    <ul id="dashboard" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="/dashboard" class="sidebar-link">--Dashboard</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">--Dashboard Analytics</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">--Dashboard Ecommerce</a>
                        </li>
                    </ul>
                </li>
            @endcan

            @if(Auth::user()->can('view-product'))
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#pages"
                       aria-expanded="false" aria-controls="pages">
                        <i class="fa-brands fa-product-hunt"></i>
                        Quản lí sản phẩm
                    </a>
                    <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="/admin/categories" class="sidebar-link">--Danh mục sản phẩm</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/admin/products" class="sidebar-link">--Sản phẩm</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(Auth::user()->can('view-post'))
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#posts"
                       aria-expanded="false" aria-controls="posts">
                        <i class="fa-regular fa-file-lines pe-2"></i>
                        Quản lí bài viết
                    </a>
                    <ul id="posts" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="/admin/posts" class="sidebar-link">--Bài viết</a>
                        </li>
                    </ul>
                </li>
            @endif

            @can('view-user')
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#manage"
                       aria-expanded="false" aria-controls="auth">
                        <i class="fa-regular fa-user pe-2"></i>
                        Quản lý người dùng
                    </a>
                    <ul id="manage" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="/admin/users" class="sidebar-link">--Người dùng</a>
                        </li>
                        @can('view-role')
                            <li class="sidebar-item">
                                <a href="/admin/roles" class="sidebar-link">--Vai trò</a>
                            </li>
                        @endcan
                        @can('view-permission')
                            <li class="sidebar-item">
                                <a href="/admin/permissions" class="sidebar-link">--Quyền</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            <br>
            <br>
            <li class="sidebar-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{route('logout')}}" onclick="event.preventDefault();
                                                this.closest('form').submit();"
                       style="margin-left: 25px"
                    >
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Đăng xuất
                    </a>
                </form>
            </li>
        </ul>
    </div>
</aside>