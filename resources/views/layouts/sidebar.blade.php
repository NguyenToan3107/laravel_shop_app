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
                <a href="#" class="sidebar-link">
                    <i class="fa-solid fa-list pe-2"></i>
                    Hồ sơ
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard"
                   aria-expanded="false" aria-controls="dashboard">
                    <i class="fa-solid fa-sliders pe-2"></i>
                    Dashboard
                </a>
                <ul id="dashboard" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="/" class="sidebar-link">--Dashboard</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/users" class="sidebar-link">--Quản lý người dùng</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">--Dashboard Analytics</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">--Dashboard Ecommerce</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#pages"
                   aria-expanded="false" aria-controls="pages">
                    <i class="fa-brands fa-product-hunt"></i>
                    Quản lí sản phẩm
                </a>
                <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="/categories" class="sidebar-link">--Danh mục sản phẩm</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/products" class="sidebar-link">--Sản phẩm</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#posts"
                   aria-expanded="false" aria-controls="posts">
                    <i class="fa-regular fa-file-lines pe-2"></i>
                    Quản lí bài viết
                </a>
                <ul id="posts" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
{{--                    <li class="sidebar-item">--}}
{{--                        <a href="/categories" class="sidebar-link">--Quản lý bài viết</a>--}}
{{--                    </li>--}}
                    <li class="sidebar-item">
                        <a href="/posts" class="sidebar-link">--Bài viết</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#trash"
                   aria-expanded="false" aria-controls="trash">
                    <i class="fa-solid fa-trash"></i>
                    Thùng rác
                </a>
                <ul id="trash" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="/categories" class="sidebar-link">--Danh mục sản phẩm</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/products/trash" id="trash_link" class="sidebar-link">--Sản phẩm xóa</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#auth"
                   aria-expanded="false" aria-controls="auth">
                    <i class="fa-regular fa-user pe-2"></i>
                    Auth
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="/auth/login" class="sidebar-link">--Đăng nhập</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/auth/register" class="sidebar-link">--Đăng ký</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-header">
                Multi Level Nav
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#multi"
                   aria-expanded="false" aria-controls="multi">
                    <i class="fa-solid fa-share-nodes pe-2"></i>
                    Multi Level
                </a>
                <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                           data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                            Two Links
                        </a>
                        <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Link 1</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Link 2</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Thoát
                </a>
            </li>
        </ul>
    </div>
</aside>
