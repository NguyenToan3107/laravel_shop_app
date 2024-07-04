@extends('frontend.layouts.app')


@section('content')
    {{-- BANNER--}}
    @include('frontend.layouts.content.banner')

{{--    @include('frontend.layouts.content.category')--}}

    @include('frontend.layouts.content.product.product_minimal.product_minimal')

    @include('frontend.layouts.content.guarantee')
@endsection
