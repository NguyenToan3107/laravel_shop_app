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
                <h2 class="text-center">Danh sách bài viết</h2>
            </div>
        </div>
        <br>
        <form id="post_search_form">
            @csrf
            <div class="flex-button">
                <div class="input-group mb-3 width-300">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-check"></i></span>
                    <input type="text" class="form-control" id="title_post" name="title"
                           placeholder="Tìm theo tên bài viết" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3 width-300">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-user"></i></span>
                    <input type="text" class="form-control" id="author_post" name="author_name"
                           placeholder="Tìm theo tên tác giả" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3 width-300">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-brands fa-superpowers"></i></span>
                    <select class="form-control" id="status_post" name="status" aria-label="Large select example">
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
            <br>
            <div class="flex-button">
                <button type="submit" id="submit_post_search" class="btn btn-primary">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Tìm kiếm
                </button>
                <button class="btn btn-secondary" id="reset_btn_post">
                    <i class="fa-solid fa-xmark"></i>
                    Tải lại
                </button>
            </div>
        </form>
        <br>
        <div style="display: flex; flex-direction: row; justify-content: flex-end; gap: 10px">
            @can('create-post')
                <a href="/admin/posts/create"
                   class="btn btn-primary margin_bottom_detail">
                    <i class="fa-solid fa-plus"></i>
                    Tạo bài viết mới
                </a>
            @endcan
            @can('delete-post')
                <a id="deleteAllSelectedPost"
                   class="btn btn-danger margin_bottom_detail">
                    <i class="fa-solid fa-trash"></i>
                    Xóa những mục được chọn
                </a>
            @endcan
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="posts-table" class="table">
                    <thead>
                    <tr>
                        <th><input type="checkbox" name="" id="select_all_ids"/></th>
                        <th>Id</th>
                        <th>Ảnh</th>
                        <th>Title</th>
                        <th>Tác giả</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

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
                    @can('delete-post')
                        <button type="button" id="confirmDeleteButton_trash" class="btn btn-danger">Xóa</button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteMultipleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
                    @can('delete-post')
                        <button type="button" id="confirmDeleteButton_trash_multiple" class="btn btn-danger">Xóa</button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

    <script>
        $(document).ready(function () {
            let datatable = $('#posts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/admin/posts',
                    type: 'GET',
                    data: function(d) {
                        d.title = $('#title_post').val();
                        d.author_name = $('#author_post').val();
                        d.status = $('#status_post').val();
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
                    {data: 'author_id', name: 'author_id'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
            });

            ///////////////////////// RESET POST
            const reset_btn_post = document.getElementById('reset_btn_post')

            if (reset_btn_post) {
                reset_btn_post.addEventListener('click', function (event) {
                    event.preventDefault();
                    document.getElementById('title_post').value = '';
                    document.getElementById('author_post').value = '';
                    document.getElementById('status_post').value = '';
                    document.getElementById('start_date').value = '';
                    document.getElementById('ended_date').value = '';

                    datatable.draw('page');
                });
            }

            /////////////////// DELETE POST
            $(document).on('click', '.delete_button_post', function (event) {
                event.preventDefault();
                let id = $(this).val();
                $('#deleteModal').modal('show')
                $('#confirmDeleteButton_trash').val(id)
            })
            $('#confirmDeleteButton_trash').on('click', function (event) {
                event.preventDefault();
                let id = $(this).val();

                $.ajax({
                    url: `/admin/posts/` + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    error: function (xhr, status, error) {
                        let errorMessage = xhr.status + ': ' + xhr.statusText
                        console.error('AJAX Error: ' + errorMessage);

                        $('#deleteModal').modal('hide')
                        let existingToast = document.querySelector(".toastify");
                        if (existingToast) {
                            existingToast.remove();
                        }
                        Toastify({
                            text: "Đã xảy ra lỗi khi xóa bài viết",
                            duration: 2000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                            className: "toastify-custom toastify-error"
                        }).showToast();
                    },
                    success: function () {
                        $('#deleteModal').modal('hide')
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
                        datatable.draw(false);
                    }
                });
            });


            /////////////// DELETE MULTIPLE
            $(document).on('click', '#select_all_ids', function () {
                $(".checkbox_ids").prop('checked', $(this).prop('checked'));
            });
            $(document).on('click', '#deleteAllSelectedPost', function (event) {
                event.preventDefault();
                let all_ids = []
                $('input:checked[name=ids_post]:checked').each(function () {
                    all_ids.push($(this).val())
                })

                all_ids = all_ids.join(",")
                $('#deleteMultipleModal').modal('show')
                $('#confirmDeleteButton_trash_multiple').val(all_ids)
            })
            $(document).on('click', '#confirmDeleteButton_trash_multiple', function (e) {
                e.preventDefault();

                let id = $(this).val();
                console.log(id);

                $.ajax({
                    url: `/admin/posts/` + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    error: function (xhr, status, error) {
                        $('#deleteMultipleModal').modal('hide')
                        let existingToast = document.querySelector(".toastify");
                        if (existingToast) {
                            existingToast.remove();
                        }
                        Toastify({
                            text: "Đã xảy ra lỗi khi xóa bài viết",
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
                        $('#deleteMultipleModal').modal('hide')
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
            //////////////////////////

            ///////////////////////// SEARCH POST
            $(document).on('submit', '#post_search_form', function (e) {
                e.preventDefault();
                datatable.ajax.reload();
            });
        });
    </script>
@endpush
