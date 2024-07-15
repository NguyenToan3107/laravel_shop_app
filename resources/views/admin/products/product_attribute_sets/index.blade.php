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
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="text-center">Danh sách bộ thuộc tính</h2>
            </div>
        </div>
        <br>
        @can('create-attribute-set')
            <div class="product_attribute_set_create">
                <button class="product_attribute_set_create--lable btn btn-secondary">Tạo bộ thuộc tính mới</button>

                <form action="/admin/product_attribute_sets" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name-product-attribute-set" class="form-label">Tên bộ thuộc tính</label>
                        <input type="text" class="form-control" id="name-product-attribute-set" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tạo mới</button>
                </form>
            </div>
        @endcan
        <br>
        <br>
        <div class="row">
            <div class="col-md-12">
                <table id="product_attribute_set-table" class="table">
                    <thead>
                    <tr>
                        <th><input type="checkbox" name="" id="select_all_ids_product_attribute_set"/></th>
                        <th>Id</th>
                        <th>Tên bộ thuộc tính</th>
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
            let datatable = $('#product_attribute_set-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/admin/product_attribute_sets',
                    type: 'GET',
                },
                scrollX: true,
                order: [[1, 'asc']],
                autoWidth: false,
                columns: [
                    {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            })
        })
    </script>
@endpush

