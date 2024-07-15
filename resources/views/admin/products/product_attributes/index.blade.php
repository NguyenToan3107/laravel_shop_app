@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="text-center">Danh sách thuộc tính</h2>
            </div>
        </div>
        <br>
        @can('create-attribute')
            <div class="product_attribute_set_create">
                <button class="product_attribute_set_create--lable btn btn-secondary">Tạo thuộc tính</button>

                <form action="/admin/product_attributes" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name-product-attribute" class="form-label">Tên thuộc tính</label>
                        <input type="text" class="form-control" id="name-product-attribute" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tạo mới</button>
                </form>
            </div>
        @endcan
        <br>
        <br>
        <div class="row">
            <div class="col-md-12">
                <table id="product_attribute-table" class="table">
                    <thead>
                    <tr>
                        <th><input type="checkbox" name="" id="select_all_ids_product_attributes"/></th>
                        <th>Id</th>
                        <th>Tên thuộc tính</th>
                        <th>Giá trị</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let datatable = $('#product_attribute-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/admin/product_attributes',
                    type: 'GET',
                },
                scrollX: true,
                order: [[1, 'asc']],
                autoWidth: false,
                columns: [
                    {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'value', name: 'value'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            })
        })
    </script>
@endpush


