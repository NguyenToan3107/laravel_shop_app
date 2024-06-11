@extends('layouts.app')

@section('content')
    <div class="container mt-5 d-flex justify-content-center margin_bottom_detail border_detail">
        <div class="border_create w-100">
            <h2 class="text-center mb-4">{{ isset($post) ? 'Cập nhật bài viết' : 'Tạo mới bài viết' }}</h2>

            @if(isset($post))
                {{ Form::open(['route' => ['posts.update', $post->id], 'method' => 'PUT', 'id' => 'formMain', 'enctype' => 'multipart/form-data', 'files' => true]) }}
            @else
                {{ Form::open(['route' => 'posts.store', 'method' => 'POST', 'id' => 'formMain', 'enctype' => 'multipart/form-data']) }}
            @endif

            @if(isset($user))
                <div class="form-group">
                    {{ Form::label('author_id', 'Ai là người tạo bài viêết') }}
                    <select class="row" name="author_id" id="author_id">
                        <option value="{{$user->id}}">Current: {{$user->name}}</option>
                        @foreach ($users as $u)
                            <option value="{{$u->id}}">--{{$u->name}}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <div class="form-group">
                    {{ Form::label('author_id', 'Ai là người tạo bài viêết') }}
                    <select class="row" name="author_id" id="author_id">
                        @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <br>
            <div class="form-group">
                {{ Form::label('title', 'Tiêu đề') }}
                {{ Form::text('title', $post->title ?? '', ['class' => 'form-control', 'id' => 'title', 'required']) }}
            </div>
            <br>
            <div class="form-group">
                {{ Form::label('description', 'Mô tả') }}
                {{ Form::textarea('description', isset($post) ? $post->description : '', ['class' => 'form-control textarea', 'cols' => 30, 'rows' => 10]) }}
            </div>
            <br>
            <div class="form-group">
                {{ Form::label('content', 'Nội dung') }}
                {{ Form::textarea('content', isset($post) ? $post->content : '', ['class' => 'form-control textarea', 'cols' => 30, 'rows' => 10]) }}
            </div>
            <br>
{{--            <div class="form-group">--}}
{{--                {{ Form::label('price', 'Giá') }}--}}
{{--                {{ Form::text('price', $post->price ?? '', ['class' => 'form-control', 'id' => 'price', 'required']) }}--}}
{{--            </div>--}}
{{--            <br>--}}
{{--            <div class="form-group">--}}
{{--                {{ Form::label('percent_sale', 'Phần trăm giảm giá') }}--}}
{{--                {{ Form::text('percent_sale', $post->percent_sale ?? '', ['class' => 'form-control', 'id' => 'percent_sale', 'required']) }}--}}
{{--            </div>--}}

            @if(isset($post))
                <div class="form-group">
                    {{ Form::label('status', 'Chọn trạng thái') }}
                    {{ Form::select('status', [
                        '1' => 'Hoạt động',
                        '2' => 'Không hoạt động',
                        '3' => 'Đợi',
                    ], isset($post) ? $post->status : 1, ['class' => 'form-control']) }}
                </div>
            @endif

            <br>
            <div class="form-group" style="display: flex; flex-direction: row; gap: 150px; align-items: center">
                <div>
                    {{ Form::label('image', 'Ảnh') }}
                    {{ Form::file('image', ['class' => 'form-control', 'id' => 'image']) }}
                </div>
                @if(isset($post) && $post->image)
                    <img src="{{ asset('images/posts/' . $post->image) }}" id="imageDisplay" class="img-thumbnail user-image-detail-80" alt="Avatar">
                @else
                    <img src="{{ asset('images/posts/default_post.png') }}" id="imageDisplay" class="img-thumbnail user-image-detail-80" alt="Avatar">
                @endif
            </div>
            <br>
            <br>
            <div class="text-center">
                {{ Form::button(isset($post) ? 'Cập nhật bài viết' : 'Tạo mới bài viết', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                <button class="btn btn-secondary" style="margin-left: 10px"><a style="color: white" href="/posts">Quay lại</a></button>
            </div>

            {{ Form::close() }}
        </div>
    </div>
@endsection
