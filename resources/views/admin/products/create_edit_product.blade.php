@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5 d-flex justify-content-center margin_bottom_detail border_detail">
        <div class="border_create w-100">
            <h2 class="text-center mb-4">{{ isset($product) ? 'Cập nhật sản phẩm' : 'Tạo mới sản phẩm' }}</h2>

            @if(isset($product))
                {{ Form::open(['route' => ['products.update', $product->id], 'method' => 'PUT', 'id' => 'formMain', 'enctype' => 'multipart/form-data', 'files' => true]) }}
            @else
                {{ Form::open(['route' => 'products.store', 'method' => 'POST', 'id' => 'formMain', 'enctype' => 'multipart/form-data']) }}
            @endif

            @if(isset($product))
                <div class="form-group">
                    {{ Form::label('category_id', 'Chọn danh mục sản phẩm') }}
                    <select class="form-control row" name="category_id" id="category_id">
                        @if(isset($c))
                            <option value="{{$c->id}}">{{$c->title}}</option>
                        @endif
                        @foreach ($categories as $category)
                            <x-category-item :category="$category" :level="0"/>
                        @endforeach
                    </select>
                </div>
            @else
                <div class="form-group">
                    {{ Form::label('category_id', 'Chọn danh mục sản phẩm') }}
                    <select class="form-control row" name="category_id" id="category_id">
                        @foreach ($categories as $category)
                            <x-category-item :category="$category" :level="0"/>
                        @endforeach
                    </select>
                </div>
            @endif
            <br>
            <div class="form-group">
                {{ Form::label('title', 'Tiêu đề') }}
                {{ Form::text('title', $product->title ?? '', ['class' => 'form-control', 'id' => 'title', 'required']) }}
            </div>
            <br>
            <div class="form-group">
                {{ Form::label('description', 'Mô tả') }}
                {{ Form::textarea('description', isset($product) ? $product->description : '', ['class' => 'form-control textarea', 'cols' => 30, 'rows' => 10]) }}
            </div>
            <br>
            <div class="form-group">
                {{ Form::label('price', 'Giá') }}
                {{ Form::text('price', $product->price ?? '', ['class' => 'form-control', 'id' => 'price', 'required']) }}
            </div>
            <br>
            <div class="form-group">
                {{ Form::label('percent_sale', 'Phần trăm giảm giá') }}
                {{ Form::text('percent_sale', $product->percent_sale ?? '', ['class' => 'form-control', 'id' => 'percent_sale', 'required']) }}
            </div>

            @if(isset($product))
                <div class="form-group">
                    {{ Form::label('status', 'Chọn trạng thái') }}
                    {{ Form::select('status', [
                        '1' => 'Hoạt động',
                        '2' => 'Không hoạt động',
                        '3' => 'Đợi',
                    ], isset($product) ? $product->status : 1, ['class' => 'form-control']) }}
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
                @if(isset($product) && $product->image)
                    <div id="imageDisplay_image" style="margin-top:15px;max-height:100px;margin-right: 20px">
                        <img src="{{ asset($product->image) }}" id="imageDisplay"
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
                {{ Form::button(isset($product) ? 'Cập nhật sản phẩm' : 'Tạo mới sản phẩm', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>

            {{ Form::close() }}
            <br>
            <button class="btn btn-secondary" style="margin-left: 10px"><a style="color: white" href="/admin/products">Quay lại</a></button>
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
