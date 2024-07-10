@extends('frontend.layouts.app')

@section('content')
    <p class="category_page_title">Danh mục sản phẩm</p>
    <div class="category_page">
        <div class="category_parent">
            @foreach($category_parents as $category_parent)
                <a data-slug="{{$category_parent->slug}}" class="category_parent--item">
                    <img src="{{$category_parent->image}}" alt="{{$category_parent->title}}">
                    <p>{{$category_parent->title}}</p>
                </a>
            @endforeach
        </div>
        <div class="category_child" id="category_child">
            <p>Danh mục</p>
            <div class="category_child--cate">
                @foreach($category_children as $category_child)
                    <a href="/products/{{$category_child->slug}}" class="category_child--item">
                        <img src="{{$category_child->image}}" alt="{{$category_child->title}}">
                    </a>
                @endforeach
            </div>
            <div class="category_child--product--hot">
                <p>Sản phẩm Hot</p>
                <div class="category_product--hot">
                    @foreach($products_hots as $products_hot)
                        <a href="/product_detail/{{$products_hot->slug}}" class="category_product--hot--item">
                            <img src="{{$products_hot->image}}" alt="{{$products_hot->title}}">
                            <p>{{$products_hot->title}}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
