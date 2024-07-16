@extends('frontend.layouts.app')

@section('title', 'Danh sách bài viết')

@section('content')
    <div class="post_header">
        <p>Các bài viết về sản phẩm</p>
    </div>

    <div class="post_body">
        <div class="post_feature">
            <div class="post_feature--item dropdown">
                <a class="post_feature--link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="post_feature--link--div">
                        <img src="{{asset('assets/frontend/images/categories/phone.png')}}" alt="">
                        <p>Điện thoại</p>
                    </div>
                </a>
                <ul class="post_feature--post dropdown-menu">
                    <li><a class="dropdown-item" href="#">Sản phẩm - Phiên bản mới</a></li>
                    <li><a class="dropdown-item" href="#">Lỗi thường gặp</a></li>
                    <li><a class="dropdown-item" href="#">Thủ thuật, mẹo - Hướng dẫn sử dụng</a></li>
                </ul>
            </div>
            <div class="post_feature--item dropdown">
                <a class="post_feature--link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="post_feature--link--div">
                        <img src="{{asset('assets/frontend/images/categories/smartwatch.png')}}" alt="">
                        <p>Smartwatch</p>
                    </div>
                </a>
                <ul class="post_feature--post dropdown-menu">
                    <li><a class="dropdown-item" href="#">Thương hiệu - sản phẩm nổi bật</a></li>
                    <li><a class="dropdown-item" href="#">Mẹo sử dụng</a></li>
                    <li><a class="dropdown-item" href="#">Tư vấn chọn mua</a></li>
                </ul>
            </div>
            <div class="post_feature--item dropdown">
                <a class="post_feature--link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="post_feature--link--div">
                        <img src="{{asset('assets/frontend/images/categories/computer.png')}}" alt="">
                        <p>Laptop</p>
                    </div>
                </a>
                <ul class="post_feature--post dropdown-menu">
                    <li><a class="dropdown-item" href="#">Máy Mac, MacBook (macOS)</a></li>
                    <li><a class="dropdown-item" href="#">PC - Laptop Windows</a></li>
                </ul>
            </div>
        </div>
        <div class="post_content">
            @foreach($posts as $post)
                <a href="/posts/{{$post->slug}}" class="post_content--item">
                    <img src="{{$post->image}}" alt="{{$post->tilte}}">
                    <div class="post_content--content">
                        <p class="post_content--content--title">{{$post->title}}</p>
                        <p>{{ucwords($post->users->name)}}</p>
                        <?php
                            $date = now()->diffInDays($post->created_at)
                            ?>
                        <p class="post_content--content--date">{{$date <= 0 ? 'Hôm nay' : $date . ' ngày trước'}}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

@endsection

