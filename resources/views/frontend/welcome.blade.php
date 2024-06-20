@extends('frontend.layouts.app')


@section('content')
    {{-- BANNER--}}
    @include('frontend.layouts.content.banner')

    <div style="margin-top: 140px"></div>
    @include('frontend.layouts.content.category')

    @include('frontend.layouts.content.product.product_minimal.product_minimal')

    @include('frontend.layouts.content.guarantee')
@endsection
