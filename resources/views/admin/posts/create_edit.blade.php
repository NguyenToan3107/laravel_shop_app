@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5 d-flex justify-content-center margin_bottom_detail">
        <div class="border_create w-100">
            <h2 class="text-center mb-4">{{ isset($post) ? 'Cập nhật bài viết' : 'Tạo mới bài viết' }}</h2>

            @if(isset($post))
                {{ Form::open(['route' => ['posts.update', $post->id], 'method' => 'POST', 'id' => 'formMain_update', 'enctype' => 'multipart/form-data', 'files' => true]) }}
                @method('PUT')
            @else
                {{ Form::open(['route' => 'posts.store', 'method' => 'POST', 'id' => 'formMain_create', 'enctype' => 'multipart/form-data']) }}
            @endif

            @if(isset($post))
                <input type="hidden" name="{{$post->id}}" value="{{$post->id}}" id="post_update_id">
            @endif

            @if(isset($user))
                <div class="form-group">
                    {{ Form::label('author_id', 'Ai là người tạo bài viết') }}
                    <select class="row form-control" name="author_id" id="author_id" style="margin-left: 0">
                        <option value="{{$user->id}}">Hiện tại: {{$user->name}}</option>
                        @foreach ($users as $u)
                            @can('create-post')
                                <option value="{{$u->id}}">Tên: {{$u->name}}</option>
                            @endcan
                        @endforeach
                    </select>
                </div>
            @else
                <div class="form-group">
                    {{ Form::label('author_id', 'Ai là người tạo bài viết') }}
                    <select class="row form-control" name="author_id" id="author_id" style="margin-left: 0">
                        @foreach ($users as $user)
                            @can('create-post')
                                <option value="{{$user->id}}">Tên: {{$user->name}}</option>
                            @endcan
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
                {{ Form::textarea('description', isset($post) ? $post->description : '', ['class' => 'form-control textarea', 'id' => 'description', 'cols' => 30, 'rows' => 10]) }}
            </div>
            <br>
            <div class="form-group">
                {{ Form::label('content', 'Nội dung') }}
                {{ Form::textarea('content', isset($post) ? $post->content : '', ['class' => 'form-control textarea', 'id' => 'content', 'cols' => 30, 'rows' => 10]) }}
            </div>
            <br>
            @if(isset($post))
                <div class="form-group">
                    {{ Form::label('status', 'Chọn trạng thái') }}
                    {{ Form::select('status', [
                        '1' => 'Hoạt động',
                        '2' => 'Không hoạt động',
                        '3' => 'Đợi',
                    ], isset($post) ? $post->status : 1, ['class' => 'form-control', 'id' => 'status']) }}
                </div>
            @endif

            <br>
            <div class="form-group" style="display: flex; flex-direction: row; gap: 150px; align-items: center">
                <div class="input-group">
                    <span class="input-group-btn">
                     <a id="lfm" data-input="thumbnail" data-preview="imageDisplay_image" class="btn btn-primary">
                       <i class="fa fa-picture-o"></i> Chọn
                     </a>
                   </span>
                    <input id="thumbnail" class="form-control" type="text" name="filepath">
                </div>
                @if(isset($post) && $post->image)
                    <div id="imageDisplay_image" style="margin-top:15px;max-height:100px;margin-right: 20px">
                        <img src="{{ asset($post->image) }}" id="imageDisplay"
                             class="img-thumbnail user-image-detail-80" alt="Avatar">
                    </div>
                @else
                    <div id="imageDisplay_image" style="margin-top:15px;margin-right: 20px">
                        <img src="{{ asset('storage/photos/posts/default_post.png') }}" id="imageDisplay"
                             class="img-thumbnail user-image-detail-80" alt="Avatar">
                    </div>
                @endif
            </div>

            <div id="holder" style="margin-top:15px;max-height:100px;"></div>

            <br>
            <br>
            <div class="text-center">
                {{ Form::button(isset($post) ? 'Cập nhật bài viết' : 'Tạo mới bài viết', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>

            {{ Form::close() }}
            <button class="btn btn-secondary" style="margin-left: 10px"><a style="color: white" href="/admin/posts">Quay
                    lại</a></button>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $(document).ready(function () {
            var route_prefix = "/laravel-filemanager";
            $('#lfm').filemanager('image', {prefix: route_prefix}, function (url, path) {
                console.log(url)
            });
        })
    </script>
@endpush
