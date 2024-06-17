@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5 d-flex justify-content-center margin_bottom_detail">
        <div class="border_detail">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{asset('images/products/' . $product->image)}}" class="img-thumbnail user-image-detail" alt="User Avatar">
                </div>
                <div class="col-md-8">
                    <h2>{{ $product->title }}</h2>
                    <p><strong>Description:</strong> {{ $product->description }}</p>
                    <p><strong>Price:</strong> {{ $product->price }}</p>
                    <a class="btn btn-primary" href="/products/{{$product->id}}/edit">Edit Product</a>
                    <button class="btn btn-danger">Delete Product</button>
                </div>
            </div>
        </div>
    </div>
@endsection

