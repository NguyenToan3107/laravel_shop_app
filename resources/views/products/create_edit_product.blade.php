@extends('layouts.app')

@section('content')
    <div class="container mt-5 d-flex justify-content-center margin_bottom_detail border_detail">
        <div class="border_create w-100">
            <h2 class="text-center mb-4">{{ isset($product) ? 'Update Product' : 'Create Product' }}</h2>

            @if(isset($product))
                {{ Form::open(['route' => ['products.update', $product->id], 'method' => 'PUT', 'id' => 'formMain', 'enctype' => 'multipart/form-data', 'files' => true]) }}
            @else
                {{ Form::open(['route' => 'products.store', 'method' => 'POST', 'id' => 'formMain', 'enctype' => 'multipart/form-data']) }}
            @endif

            @if(isset($product))
                <div class="form-group">
                    {{ Form::label('category_id', 'Choose Category Parent') }}
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
                    {{ Form::label('category_id', 'Choose Category Parent') }}
                    <select class="form-control row" name="category_id" id="category_id">
                        @foreach ($categories as $category)
                            <x-category-item :category="$category" :level="0" />
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="form-group">
                {{ Form::label('title', 'Title') }}
                {{ Form::text('title', $product->title ?? '', ['class' => 'form-control', 'id' => 'title', 'required']) }}
            </div>

            <div class="form-group">
                {{ Form::label('description', 'Description') }}
                {{ Form::textarea('description', isset($product) ? $product->description : '', ['class' => 'form-control textarea', 'cols' => 30, 'rows' => 10]) }}
            </div>

            <div class="form-group">
                {{ Form::label('price', 'Price') }}
                {{ Form::text('price', $product->price ?? '', ['class' => 'form-control', 'id' => 'price', 'required']) }}
            </div>

            <div class="form-group">
                {{ Form::label('percent_sale', 'Percent Sale') }}
                {{ Form::text('percent_sale', $product->percent_sale ?? '', ['class' => 'form-control', 'id' => 'percent_sale', 'required']) }}
            </div>

            @if(isset($product))
                <div class="form-group">
                    {{ Form::label('status', 'Choose a status:') }}
                    {{ Form::select('status', [
                        '1' => 'Active',
                        '2' => 'Inactive',
                        '3' => 'Pending',
                    ], isset($product) ? $product->status : 1, ['class' => 'form-control']) }}
                </div>
            @endif

            <br>
            <div class="form-group" style="display: flex; flex-direction: row; gap: 150px; align-items: center">
                <div>
                    {{ Form::label('image', 'Image') }}
                    {{ Form::file('image', ['class' => 'form-control', 'id' => 'image']) }}
                </div>
                @if(isset($product) && $product->image)
                    <img src="{{ asset('images/products/' . $product->image) }}" id="imageDisplay" class="img-thumbnail user-image-detail-80" alt="Avatar">
                @else
                    <img src="{{ asset('images/products/empty-photo.jpg') }}" id="imageDisplay" class="img-thumbnail user-image-detail-80" alt="Avatar">
                @endif
            </div>

            <div class="text-center">
                {{ Form::button(isset($product) ? 'Update Product' : 'Create Product', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>

            {{ Form::close() }}
        </div>
    </div>
@endsection
