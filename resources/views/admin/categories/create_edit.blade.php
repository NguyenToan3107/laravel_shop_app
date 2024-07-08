@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5 d-flex justify-content-center margin_bottom_detail border_detail">
        <div class="border_create w-100">
            <h2 class="text-center mb-4">{{ isset($c) ? 'Cập nhật danh mục' : 'Tạo danh mục sản phẩm' }}</h2>

            @if(isset($c))
                {{ Form::open(['route' => ['categories.update', $c->slug], 'method' => 'PUT', 'id' => 'formMain']) }}
            @else
                {{ Form::open(['route' => 'categories.store', 'method' => 'POST', 'id' => 'formMain']) }}
            @endif

            @if(isset($c))
                <div class="form-group">
                    {{ Form::label('parent_id', 'Chọn danh mục cha') }}
                    <select class="form-control row" name="parent_id" id="parent_id">
                        @if($parent_category->parent_id === null)
                            <option value="{{null}}">Danh mục cha: {{$parent_category->title}}</option>
                        @else
                            <option value="{{$parent_category->id}}">Danh mục cha: {{$parent_category->title}}</option>
                        @endif
                        @foreach ($categories as $category)
                            <x-category-item :category="$category" :level="0" />
                        @endforeach
                    </select>
                </div>
            @else
                <div class="form-group">
                    {{ Form::label('parent_id', 'Chọn danh mục cha') }}
                    <select class="form-control row" name="parent_id" id="parent_id">
                        @foreach ($categories as $category)
                            <x-category-item :category="$category" :level="0" />
                        @endforeach
                    </select>
                </div>
            @endif
            <br>
            <div class="form-group">
                {{ Form::label('title', 'Tiêu đề') }}
                {{ Form::text('title', $c->title ?? '', ['class' => 'form-control', 'id' => 'title', 'required']) }}
            </div>
            <br>

            <div class="form-group">
                {{ Form::label('description', 'Mô tả') }}
                {{ Form::textarea('description', isset($c) ? $c->description : '', ['class' => 'form-control textarea', 'cols' => 30, 'rows' => 10]) }}
            </div>
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
                @if(isset($category) && $category->image)
                    <div id="imageDisplay_image" style="margin-top:15px;max-height:100px;margin-right: 20px">
                        <img src="{{ asset($category->image) }}" id="imageDisplay"
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
            <div class="text-center">
                {{ Form::button(isset($c) ? 'Cập nhật danh mục' : 'Tạo danh mục', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>

            {{ Form::close() }}
            <br>
            <button class="btn btn-secondary" style="margin-left: 10px"><a style="color: white" href="/admin/categories">Quay lại</a></button>
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
