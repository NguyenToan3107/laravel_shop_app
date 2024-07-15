@extends('admin.layouts.app')

@section('content')
    <form action="/admin/products/{{$product->id}}/product_skus" method="post">
        @csrf
        @foreach($product_attributes as $product_attribute)
            <div class="form-group" style="margin-bottom: 10px">
                <label for="{{$product_attribute->name}}">{{ucwords($product_attribute->name)}}</label>
                <select class="row form-control" name="{{$product_attribute->name}}" id="{{$product_attribute->name}}" style="margin-left: 0">
                    @foreach ($product_attribute->attributeValues as $value)
                        @can('create-product')
                            <option value="{{$value->id}}">{{$value->value}}</option>
                        @endcan
                    @endforeach
                </select>
            </div>
        @endforeach
        <div class="mb-3">
            <label for="price" class="form-label">Giá mới (x1000)</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="mb-3">
            <label for="percent_sale" class="form-label">Khuyến mãi</label>
            <input type="number" class="form-control" id="percent_sale" name="percent_sale" required>
        </div>
        <div class="mb-3">
            <label for="price_old" class="form-label">Giá cũ (x1000)</label>
            <input type="number" class="form-control" id="price_old" name="price_old" required>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Số lượng</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>
        <button type="submit" class="btn btn-primary">Tạo mới</button>
    </form>
    <br>
    <a style="float: right" class="btn btn-secondary" href="/admin/products/{{$product->id}}">Quay lại</a>
@endsection


