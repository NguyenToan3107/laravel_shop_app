@extends('layouts.app')

@section('content')

    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="text-center">Product List</h2>
            </div>
        </div>
{{--                <div class="flex-button">--}}
{{--                    @foreach($categories as $category)--}}
{{--                        <button class="btn_custom_categories" name="{{$category->id}}">{{$category->title}}</button>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
        <br>
        <form id="product_search_form">
            @csrf
            <div class="flex-button">
                <div class="input-group mb-3 width-300">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-check"></i></span>
                    <input type="text" class="form-control" id="title_product" name="title"
                           placeholder="Tìm theo tên" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3 width-300">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-user"></i></span>
                    <input type="text" class="form-control" id="price_product" name="price" value="{{request('price')}}"
                           placeholder="Tìm theo giá" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3 width-300">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-brands fa-superpowers"></i></span>
                    <select class="form-control" id="status_product" name="status" aria-label="Large select example">
                        <option value="">Open this select status</option>
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                        <option value="3">Pending</option>
                    </select>
                </div>
                <div class="input-group mb-3 width-300">
                    <span class="input-group-text" id="basic-addon1">Từ</span>
                    <input type="datetime-local" id="start_date" name="start_date" class="form-control" placeholder="" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3 width-300">
                    <span class="input-group-text" id="basic-addon1">Tới</span>
                    <input type="datetime-local" id="ended_date" name="end_date" class="form-control" placeholder="" aria-describedby="basic-addon1">
                </div>
            </div>
            <br>
            <div class="flex-button">
                <button type="submit" id="submit_product_search" class="btn btn-primary">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Tìm kiếm
                </button>
                <button class="btn btn-secondary" id="reset_btn">
                    <i class="fa-solid fa-xmark"></i>
                    Reset
                </button>
            </div>
        </form>
        <a href="products/create"
           class="btn btn-primary margin_bottom_detail"
           style="margin-left: 830px"
        >
            Create a new Product
        </a>
        <div class="row">
            <div class="col-md-12">
                {{ $dataTable->table()}}
            </div>
        </div>
    </div>
@endsection

{{--@push('scripts')--}}
{{--    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}--}}
{{--@endpush--}}
@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
