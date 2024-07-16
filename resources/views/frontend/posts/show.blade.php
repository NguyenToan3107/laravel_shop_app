@extends('frontend.layouts.app')

@section('title', $post->title)

@section('content')
    <div class="post_detail--header">
        <p class="post_detail--title">{{$post->title}}</p>
        <?php
            $timestamp = $post->created_at; // Timestamp cần chuyển đổi
            $date = $post->created_at->locale('vi')->isoFormat('DD MMMM, YYYY');
        ?>
        <p>Đăng ngày {{$date}} bởi {{$post->users->name}}</p>

    </div>
    <div class="post_detail">
        <div class="post_detail--left">
            <img class="post_detail--left--img" src="{{$post->image}}" alt="">
            <p>{!! $post->description !!}</p>
            <p>{!! $post->content !!}</p>
        </div>
        <div class="post_detail--right">
            <p>Các bài viết khác</p>
            <div class="post_detail--involve">
                @foreach($involve_posts as $post)
                    <a href="/posts/{{$post->slug}}" class="post_detail--item">
                        <img src="{{$post->image}}" alt="{{$post->tilte}}">
                        <div class="post_detail--item--content">
                            <p class="post_detail--item--title">{{$post->title}}</p>
                            <p>{{ucwords($post->users->name)}}</p>
                                <?php
                                $date = now()->diffInDays($post->created_at)
                                ?>
                            <p class="post_detail--item--date">{{$date <= 0 ? 'Hôm nay' : $date . ' ngày trước'}}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
