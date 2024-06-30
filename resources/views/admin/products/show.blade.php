@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5 d-flex justify-content-center margin_bottom_detail">
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="{{$product->image}}" class="img-thumbnail user-image-detail"
                     alt="User Avatar">
            </div>
            <div class="col-md-8">
                <h2>{{ $product->title }} </h2>
                <div class="product_category">
                    <p>
                        {{strtoupper($category->title)}}
                    </p>
                </div>
                <p><strong>Mô tả: </strong> {{ $product->description }}</p>
                <p><strong>Giá: </strong> {{ number_format($product->price * 1000, 0) }} đ</p>
                <p><strong>Khuyến mãi: </strong> {{ number_format($product->percent_sale, 0) }} %</p>

                <?php

                $statusLabels = [
                    1 => 'Hoạt động',
                    2 => 'Không hoạt động',
                    3 => 'Đợi',
                    4 => 'Xóa mềm'
                ];

                $status = $statusLabels[$product->status] ?? '';

                ?>
                <p><strong>Trạng thái:</strong> {{ $status }}</p>

                <a class="btn btn-primary" href="/admin/products/{{$product->id}}/edit"><i
                        class="fa-solid fa-wrench"></i></a>
                <button value="{{$product->id}}" data-id="{{$product->id}}"
                        class="btn btn-danger delete_button_product"><i class="fa-solid fa-trash"></i></button>
            </div>


            <div class="product_attribute-info">
                <p>Thông tin sản phẩm</p>
            </div>
            @foreach($product_attributes as $product_attribute)
                <div class="product_attribute">
                    <p>{{ucfirst($product_attribute->name)}}</p>
                    <div class="product_attribute_value card">
                        <div class="card-body d-flex">
                            @foreach($product_attribute->attributeValues as $product_attribute_value)
                                <h3><span class="badge text-bg-secondary" style="margin-right: 4px">{{$product_attribute_value->value}}</span></h3>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="product_attribute-info">
                <p>Thông tin về biến thể sản phẩm</p>
            </div>

            @can('create-product')
                <a href="/admin/products/{{$product->id}}/product_skus/create"
                   class="btn btn-primary" style="width: 200px; margin-left: 750px;">
                    Tạo biến thể mới
                </a>
            @endcan
            <br>
            <div class="row">
                <div class="col-md-12">
                    {{ $dataTable->table()}}
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-secondary"><a style="color: white" href="/admin/products">Quay lại</a></button>

    {{--    soft delete--}}
    <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Bạn có chắc muốn xóa không?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    (Hãy vào thùng rác để xóa nếu như bạn muốn chắc chắn xóa)
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" id="confirmDeleteButton_trash" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
