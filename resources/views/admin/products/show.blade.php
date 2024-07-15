@extends('admin.layouts.app')

@section('content')

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 2000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "toastify-custom toastify-success"
                }).showToast();
            });
        </script>

    @elseif(session('delete'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Toastify({
                    text: "{{ session('delete') }}",
                    duration: 2000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "toastify-custom toastify-error"
                }).showToast();
            });
        </script>
    @endif

    <div class="container mt-5 d-flex justify-content-center margin_bottom_detail">
        <div class="row">
            <div class="col-md-4 text-center">
                <input type="hidden" id="product_sku_id" data-id="{{$product->id}}">
                <img src="{{$product->image}}" class="img-thumbnail user-image-detail"
                     alt="User Avatar">
            </div>
            <div class="col-md-8">
                <h2>{{ $product->title }} </h2>
                <div class="product_category">
                    <p>
                        {{ ($category->title)}}
                    </p>
                </div>
                {{--                <p><strong>Mô tả: </strong> {{ $product->description }}</p>--}}
                <p><strong>Giá bán: </strong> {{ number_format($product->price * 1000, 0) }}đ</p>
                <p><strong>Giá gốc: </strong> {{ number_format($product->price_old * 1000, 0) }}đ</p>
                <p><strong>Khuyến mãi: </strong> {{ number_format($product->percent_sale, 0) }}%</p>

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
                                <h3><span class="badge text-bg-secondary"
                                          style="margin-right: 4px">{{$product_attribute_value->value}}</span></h3>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="product_attribute-info">
                <p>Thông tin về biến thể sản phẩm</p>
            </div>

            <div style="display: flex; flex-direction: row; justify-content: flex-end; margin-bottom: 40px;">
                @can('create-product')
                    <a href="/admin/products/{{$product->id}}/product_skus/create"
                       class="btn btn-primary" style="width: 200px; margin-left: 750px;">
                        Tạo biến thể mới
                    </a>
                @endcan
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="product_skus-table" class="table">
                        <thead>
                        <tr>
                            <th><input type="checkbox" name="" id="select_all_ids_product_skus"/></th>
                            <th>Id</th>
                            <th>Thuộc tính</th>
                            <th>Giá mới</th>
                            <th>Khuyến mãi</th>
                            <th>Giá cũ</th>
                            <th>Số lượng</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-secondary"><a style="color: white" href="/admin/products">Quay lại</a></button>

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
    <script>
        $(document).ready(function () {
            let product_sku_id = $('#product_sku_id').data('id')
            $('#product_skus-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/admin/products/' + product_sku_id,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token vào header
                    },
                },
                scrollX: true,
                order: [[1, 'asc']],
                autoWidth: false,
                columns: [
                    {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'value', name: 'value'},
                    {data: 'price', name: 'price'},
                    {data: 'percent_sale', name: 'percent_sale'},
                    {data: 'price_old', name: 'price_old'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        })
    </script>
@endpush
