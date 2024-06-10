@extends('layouts.app')

@section('content')
    <div class="container mt-5 d-flex justify-content-center margin_bottom_detail border_detail">
        <div class="border_create w-100">
            <h2 class="text-center mb-4">{{ isset($c) ? 'Cập nhật danh mục' : 'Tạo danh mục sản phẩm' }}</h2>

            @if(isset($c))
                {{ Form::open(['route' => ['categories.update', $c->id], 'method' => 'PUT', 'id' => 'formMain']) }}
            @else
                {{ Form::open(['route' => 'categories.store', 'method' => 'POST', 'id' => 'formMain']) }}
            @endif

            <div class="form-group">
                {{ Form::label('parent_id', 'Chọn danh mục cha') }}
                <select class="form-control row" name="parent_id" id="parent_id">
                    @foreach ($categories as $category)
                        <x-category-item :category="$category" :level="0" />
                    @endforeach
                </select>
            </div>
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
            <div class="text-center">
                {{ Form::button(isset($c) ? 'Cập nhật danh mục' : 'Tạo danh mục', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                <button class="btn btn-secondary" style="margin-left: 10px"><a style="color: white" href="/categories">Quay lại</a></button>
            </div>

            {{ Form::close() }}
        </div>
    </div>
@endsection
