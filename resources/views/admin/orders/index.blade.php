@extends('admin.layouts.app')

@section('title', 'Đơn đặt hàng')

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
                <h2 class="text-center">Danh sách đơn đặt hàng</h2>
            </div>
        </div>
        <br>
        <form id="order_search_form">
            @csrf
            <div class="flex-button">
                <div class="input-group mb-3 width-300">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-check"></i></span>
                    <input type="text" class="form-control" id="full_name_order" name="full_name"
                           placeholder="Tìm theo tên" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3 width-300">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-check"></i></span>
                    <input type="text" class="form-control" id="email_order" name="email"
                           placeholder="Tìm theo email" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3 width-300">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-user"></i></span>
                    <input type="text" class="form-control" id="phone_order" name="phone"
                           placeholder="Tìm theo số điện thoại" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3 width-300">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-brands fa-superpowers"></i></span>
                    <select class="form-control" id="status_order" name="status" aria-label="Large select example">
                        <option value="">--Tất cả trạng thái --</option>
                        <option value="1">Chờ xử lý</option>
                        <option value="2">Đã xác nhận</option>
                        <option value="3">Đang xử lý</option>
                        <option value="4">Đã giao hàng</option>
                        <option value="5">Hoàn thành</option>
                        <option value="6">Đã hủy</option>
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
                <button type="submit" id="submit_order_search" class="btn btn-primary">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Tìm kiếm
                </button>
                <button class="btn btn-secondary" id="reset_btn_order">
                    <i class="fa-solid fa-xmark"></i>
                    Tải lại
                </button>
            </div>
        </form>
        <br>
        <br>
        <br>
        <div>
            <p>Tổng số đơn hàng: {{$count_order}}</p>
            <p>Tổng tiền: {{number_format($total_order * 1000, 0)}} đ</p>
        </div>

        <div style="display: flex; flex-direction: row; justify-content: flex-end; gap: 10px">
            @can('create-order')
                <a href="/admin/orders/create"
                   class="btn btn-primary margin_bottom_detail"
                >
                    <i class="fa-regular fa-square-plus"></i>
                    Tạo đơn hàng mới
                </a>
            @endcan
            @can('view-order')
                <a href="/admin/orders/export" class="btn btn-secondary margin_bottom_detail">
                    <i class="fa-solid fa-download"></i>
                    In excel
                </a>
            @endcan
            @can('delete-order')
                <a id="deleteAllSelectedOrder" class="btn btn-danger margin_bottom_detail">
                    <i class="fa-solid fa-trash"></i>
                    Xóa những mục đã chọn
                </a>
            @endcan
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="orders-table" class="table">
                    <thead>
                    <tr>
                        <th><input type="checkbox" name="" id="select_all_ids_orders"/></th>
                        <th>Id</th>
                        <th>Tên</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Khuyến mãi</th>
                        <th>Giá</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    {{--  Delete One  --}}
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

    {{--  Delete Multiple  --}}
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
                    <button type="button" id="confirmDeleteMultiple_trash" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let datatable = $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/admin/orders',
                    type: 'GET',
                    data: function (d) {
                        d.fullname = $('#full_name_order').val();
                        d.email = $('#email_order').val();
                        d.phone = $('#phone_order').val();
                        d.status = $('#status_order').val();
                        d.started_at = $('#start_date').val();
                        d.ended_at = $('#ended_date').val();
                    }
                },
                scrollX: true,
                order: [[7, 'asc']],
                autoWidth: false,
                columns: [
                    {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'fullname', name: 'fullname'},
                    {data: 'phone', name: 'phone'},
                    {data: 'address', name: 'address'},
                    {data: 'percent_sale', name: 'percent_sale'},
                    {data: 'price', name: 'price'},
                    {data: 'status', name: 'status'},
                    {data: 'updated_at', name: 'updated_at'},
                    {data: 'action', name: 'action'}
                ]
            });

            ///////////////// RESET ORDER
            const reset_btn_order = document.getElementById('reset_btn_order')

            if (reset_btn_order) {
                reset_btn_order.addEventListener('click', function (event) {
                    event.preventDefault();
                    document.getElementById('full_name_order').value = '';
                    document.getElementById('email_order').value = '';
                    document.getElementById('phone_order').value = '';
                    document.getElementById('status_order').value = '';
                    document.getElementById('start_date').value = '';
                    document.getElementById('ended_date').value = '';

                    datatable.draw('page')
                });
            }

            ////////////////// SEARCH ORDER
            $(document).on('submit', '#order_search_form', function (event) {
                event.preventDefault();
                datatable.ajax.reload();
            })

            ///////////////// DELETE ORDER
            $(document).on('click', '.trash_button_order', function (event) {
                event.preventDefault();
                let order_id = $(this).val();
                $('#deleteModal').modal('show')
                $('#confirmDeleteButton_trash').val(order_id)
            })
            $('#confirmDeleteButton_trash').on('click', function (event) {
                event.preventDefault();
                let order_id = $(this).val();

                $.ajax({
                    url: `/admin/orders/` + order_id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    error: function (xhr, status, error) {
                        $('#deleteModal').modal('hide')
                        let existingToast = document.querySelector(".toastify");
                        if (existingToast) {
                            existingToast.remove();
                        }
                        Toastify({
                            text: "Đã xảy ra lỗi khi xóa đơn hàng",
                            duration: 2000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                            className: "toastify-custom toastify-error"
                        }).showToast();

                        datatable.draw('page')
                    },
                    success: function () {
                        $('#deleteModal').modal('hide')
                        let existingToast = document.querySelector(".toastify");
                        if (existingToast) {
                            existingToast.remove();
                        }
                        Toastify({
                            text: "Xóa đơn hàng thành công",
                            duration: 2000,
                            close: true,
                            gravity: "top", // `top` or `bottom`
                            position: "right", // `left`, `center` or `right`
                            stopOnFocus: true, // Prevents dismissing of toast on hover
                            className: "toastify-custom toastify-success"
                        }).showToast();

                        datatable.draw('page')
                    }
                })
            })

            //////////////// DELETE MULTIPLE ORDER
            $(document).on('click', '#select_all_ids_orders', function () {
                $(".checkbox_ids_orders").prop('checked', $(this).prop('checked'));
            });
            $(document).on('click', '#deleteAllSelectedOrder', function (event) {
                event.preventDefault();

                let all_ids = []
                $('input:checked[name=ids_order]:checked').each(function () {
                    all_ids.push($(this).val())
                })
                all_ids = all_ids.join(',')

                $('#delete_multiple_modal').modal('show')
                $('#confirmDeleteMultiple_trash').val(all_ids)
            })
            $(document).on('click', '#confirmDeleteMultiple_trash', function (e) {
                e.preventDefault();

                let order_id = $(this).val();

                $.ajax({
                    url: `/admin/orders/` + order_id,
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
                            text: "Đã xảy ra lỗi khi xóa đơn hàng",
                            duration: 2000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                            className: "toastify-custom toastify-error"
                        }).showToast();

                        datatable.draw('page')
                    },
                    success: function () {
                        $('#delete_multiple_modal').modal('hide')
                        let existingToast = document.querySelector(".toastify");
                        if (existingToast) {
                            existingToast.remove();
                        }
                        Toastify({
                            text: "Xóa đơn hàng thành công",
                            duration: 2000,
                            close: true,
                            gravity: "top", // `top` or `bottom`
                            position: "right", // `left`, `center` or `right`
                            stopOnFocus: true, // Prevents dismissing of toast on hover
                            className: "toastify-custom toastify-success"
                        }).showToast();

                        datatable.draw('page')
                    }
                })

            })
        })
    </script>
@endpush
