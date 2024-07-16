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
                <h2 class="text-center">Danh sách sản phẩm</h2>
            </div>
        </div>
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
                        <option value="">--Tất cả trạng thái --</option>
                        <option value="1">Hoạt động</option>
                        <option value="2">Không hoạt động</option>
                        <option value="3">Đợi</option>
                        <option value="4">Thùng rác</option>
                    </select>
                </div>
                <div class="input-group mb-3 width-300">
                    <span class="input-group-text" id="basic-addon1">Từ</span>
                    <input type="datetime-local" id="start_date" name="start_date" class="form-control" placeholder=""
                           aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3 width-300">
                    <span class="input-group-text" id="basic-addon1">Tới</span>
                    <input type="datetime-local" id="ended_date" name="end_date" class="form-control" placeholder=""
                           aria-describedby="basic-addon1">
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
                    Tải lại
                </button>
            </div>
        </form>
        <br>
        <div style="display: flex; flex-direction: row; justify-content: flex-end; gap: 10px">
            @can('create-product')
                <a href="/admin/products/create"
                   class="btn btn-primary margin_bottom_detail">
                    <i class="fa-regular fa-square-plus"></i>
                    Tạo mới
                </a>
            @endcan
            @can('view-product')
                <a class="btn btn-secondary margin_bottom_detail" data-bs-toggle="modal" data-bs-target="#importData">
                    <i class="fa-solid fa-file-import"></i>
                    Tải tệp lên
                </a>
            @endcan
            @can('delete-product')
                <a class="btn btn-danger margin_bottom_detail" id="deleteAllSelectedProduct">
                    <i class="fa-solid fa-trash"></i>
                    Xóa những mục được chọn
                </a>
            @endcan
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="products-table" class="table">
                    <thead>
                    <tr>
                        <th><input type="checkbox" name="" id="select_all_ids_products"/></th>
                        <th>Id</th>
                        <th>Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá gốc (đ)</th>
                        <th>Khuyến mãi</th>
                        <th>Giá bán (đ)</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    {{--  Delete one  --}}
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

    {{--  Delete multiple  --}}
    <div class="modal fade" id="delete_multiple_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
                    <button type="button" id="confirmDeleteMultipleButton_trash" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import data -->
    <div class="modal fade" id="importData" tabindex="-1" aria-labelledby="importDataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="importDataModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card d-flex flex-column h-100">
                        <div class="card-body">
                            <form action="/admin/products/import" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <input type="file" name="import_file" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Import</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let datatable = $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/admin/products',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token vào header
                    },
                    data: function (d) {
                        d.title = $('#title_product').val();
                        d.price = $('#price_product').val();
                        d.status = $('#status_product').val();
                        d.started_at = $('#start_date').val();
                        d.ended_at = $('#ended_date').val();
                    }
                },
                scrollX: true,
                order: [[1, 'asc']],
                autoWidth: false,
                columns: [
                    {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'image', name: 'image'},
                    {data: 'title', name: 'title'},
                    {data: 'price_old', name: 'price_old'},
                    {data: 'percent_sale', name: 'percent_sale'},
                    {data: 'price', name: 'price'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            //////////////////////// RESET PRODUCT
            const reset_btn_product = document.getElementById('reset_btn')
            if (reset_btn_product) {
                reset_btn_product.addEventListener('click', function (event) {
                    event.preventDefault();
                    document.getElementById('title_product').value = '';
                    document.getElementById('price_product').value = '';
                    document.getElementById('status_product').value = '';
                    document.getElementById('start_date').value = '';
                    document.getElementById('ended_date').value = '';

                    datatable.draw('page')
                })
            }

            //////////////////////// SEARCH PRODUCT
            const product_search_form = document.getElementById('product_search_form')
            if (product_search_form) {
                product_search_form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    datatable.ajax.reload();
                });
            }

            ////////////////////// DELETE PRODUCT
            $(document).on('click', '.delete_button_product', function (event) {
                event.preventDefault();
                let id = $(this).val();
                $('#deleteModal').modal('show')
                $('#confirmDeleteButton_trash').val(id)
            })
            $('#confirmDeleteButton_trash').on('click', function (event) {
                event.preventDefault();
                let id = $(this).val();

                $.ajax({
                    url: `/admin/products/` + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    error: function (xhr, status, error) {
                        let existingToast = document.querySelector(".toastify");
                        if (existingToast) {
                            existingToast.remove();
                        }
                        Toastify({
                            text: "Đã xảy ra lỗi khi xóa sản phẩm",
                            duration: 2000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                            className: "toastify-custom toastify-error"
                        }).showToast();

                        datatable.draw(false)
                    },
                    success: function () {
                        let existingToast = document.querySelector(".toastify");
                        if (existingToast) {
                            existingToast.remove();
                        }
                        Toastify({
                            text: "Xóa thành công",
                            duration: 2000,
                            close: true,
                            gravity: "top", // `top` or `bottom`
                            position: "right", // `left`, `center` or `right`
                            stopOnFocus: true, // Prevents dismissing of toast on hover
                            className: "toastify-custom toastify-success"
                        }).showToast();

                        datatable.draw(false)
                    }
                })
                $('#deleteModal').modal('hide')
            })

            //////////////// DELETE MULTIPLE PRODUCT
            $(document).on('click', '#select_all_ids_products', function () {
                $(".checkbox_ids_products").prop('checked', $(this).prop('checked'));
            });
            $(document).on('click', '#deleteAllSelectedProduct', function (event) {
                event.preventDefault();

                let all_ids = []
                $('input:checked[name=ids_product]:checked').each(function () {
                    all_ids.push($(this).val())
                })
                all_ids = all_ids.join(',')

                $('#delete_multiple_modal').modal('show')
                $('#confirmDeleteMultipleButton_trash').val(all_ids)
            })
            $(document).on('click', '#confirmDeleteMultipleButton_trash', function (e) {
                e.preventDefault();

                let id = $(this).val();

                $.ajax({
                    url: `/admin/products/` + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    error: function (xhr, status, error) {
                        $('#delete_multiple_modal').modal('hide')
                        let existingToast = document.querySelector(".toastify");
                        if (existingToast) {
                            existingToast.remove();
                        }
                        Toastify({
                            text: "Đã xảy ra lỗi khi xóa sản phẩm",
                            duration: 2000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                            className: "toastify-custom toastify-error"
                        }).showToast();

                        datatable.draw(false)
                    },
                    success: function () {
                        $('#delete_multiple_modal').modal('hide')
                        let existingToast = document.querySelector(".toastify");
                        if (existingToast) {
                            existingToast.remove();
                        }
                        Toastify({
                            text: "Xóa thành công",
                            duration: 2000,
                            close: true,
                            gravity: "top", // `top` or `bottom`
                            position: "right", // `left`, `center` or `right`
                            stopOnFocus: true, // Prevents dismissing of toast on hover
                            className: "toastify-custom toastify-success"
                        }).showToast();

                        datatable.draw(false)
                    }
                })
            })
        })
    </script>
@endpush
