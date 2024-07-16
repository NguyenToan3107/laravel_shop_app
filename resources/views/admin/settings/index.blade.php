@extends('admin.layouts.app')

@section('title', 'Cấu hình chung')

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
                <h2 class="text-center">Danh sách cấu hình</h2>
            </div>
        </div>
        <br>

        <form action="/admin/settings/updateLogo" method="post">
            @csrf
            <h4>Logo Frontend</h4>
            <div class="form-group" style="display: flex; flex-direction: row; gap: 150px; align-items: center">
                <div class="input-group">
                    <span class="input-group-btn">
                     <a id="lfm_front" data-input="thumbnail_front" data-preview="imageDisplay_front" class="btn btn-secondary">
                       <i class="fa fa-picture-o"></i> Chọn
                     </a>
                   </span>
                    <input id="thumbnail_front" class="form-control" type="text" name="filepath_frontend">
                </div>
                @if(isset($frontendLogo))
                    <div id="imageDisplay_front" style="margin-top:15px;max-height:100px;margin-right: 20px">
                        <img src="{{ asset($frontendLogo) }}" id="imageDisplay"
                             class="img-thumbnail user-image-detail-80" alt="Avatar">
                    </div>
                @endif
            </div>

            <h4>Logo Admin</h4>
            <div class="form-group" style="display: flex; flex-direction: row; gap: 150px; align-items: center">
                <div class="input-group">
                    <span class="input-group-btn">
                     <a id="lfm_admin" data-input="thumbnail_admin" data-preview="imageDisplay_admin" class="btn btn-secondary">
                       <i class="fa fa-picture-o"></i> Chọn
                     </a>
                   </span>
                    <input id="thumbnail_admin" class="form-control" type="text" name="filepath_admin">
                </div>
                @if(isset($adminLogo))
                    <div id="imageDisplay_admin" style="margin-top:15px;max-height:100px;margin-right: 20px">
                        <img src="{{ asset($adminLogo) }}" id="imageDisplay"
                             class="img-thumbnail user-image-detail-80" alt="Avatar">
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-danger" style="width: 200px;">Cập nhật Logo</button>
        </form>


        {{--        <div class="setting">--}}
        {{--            <h4 class="setting-lable">Tạo cấu hình</h4>--}}
        {{--            <form >--}}
        {{--                @csrf--}}
        {{--                <div class="mb-3">--}}
        {{--                    <label for="key" class="form-label">Key</label>--}}
        {{--                    <input type="text" class="form-control" id="key" name="key" required>--}}
        {{--                    <label for="value" class="form-label">Giá trị</label>--}}
        {{--                    <input type="text" class="form-control" id="value" name="value" required>--}}
        {{--                </div>--}}
        {{--                <button type="submit" class="btn btn-primary">Tạo mới</button>--}}
        {{--            </form>--}}
        {{--        </div>--}}

        {{--        <div style="display: flex; flex-direction: row; justify-content: flex-end; gap: 10px">--}}
        {{--            --}}{{--            @can('delete-product')--}}
        {{--            <a class="btn btn-danger margin_bottom_detail" id="deleteAllSelectedSetting">--}}
        {{--                <i class="fa-solid fa-trash"></i>--}}
        {{--                Xóa những mục được chọn--}}
        {{--            </a>--}}
        {{--            --}}{{--            @endcan--}}
        {{--        </div>--}}

        {{--        <div class="row">--}}
        {{--            <div class="col-md-12">--}}
        {{--                <table id="settings-table" class="table">--}}
        {{--                    <thead>--}}
        {{--                    <tr>--}}
        {{--                        <th><input type="checkbox" name="" id="select_all_ids_setting"/></th>--}}
        {{--                        <th>Id</th>--}}
        {{--                        <th>Key</th>--}}
        {{--                        <th>Value</th>--}}
        {{--                        <th>Trạng thái</th>--}}
        {{--                        <th>Hành động</th>--}}
        {{--                    </tr>--}}
        {{--                    </thead>--}}
        {{--                    <tbody></tbody>--}}
        {{--                </table>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>

    {{--  Delete one  --}}
    <div class="modal fade" id="deleteSetting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
                    <button type="button" id="confirm_setting_button" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>

    {{--  Delete multiple  --}}
    <div class="modal fade" id="delete_multiple_setting" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1"
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
                    <button type="button" id="confirm_setting_multiple_button" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let datatable = $('#settings-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/admin/settings',
                    type: 'GET',
                    data: function (d) {
                        d.key = $('#key_setting').val();
                        d.value = $('#value_setting').val();
                        d.status = $('#status_setting').val();
                    }
                },
                order: [[1, 'asc']],
                autoWidth: false,
                columns: [
                    {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'key', name: 'key'},
                    {data: 'value', name: 'value'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            })

            /////////////////// DELETE POST
            $(document).on('click', '.delete_button_setting', function (event) {
                event.preventDefault();
                let id = $(this).val();
                $('#deleteSetting').modal('show')
                $('#confirm_setting_button').val(id)
            })
            $('#confirm_setting_button').on('click', function (event) {
                event.preventDefault();
                let id = $(this).val();

                $.ajax({
                    url: `/admin/settings/` + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    error: function (xhr, status, error) {
                        let errorMessage = xhr.status + ': ' + xhr.statusText
                        console.error('AJAX Error: ' + errorMessage);

                        $('#deleteSetting').modal('hide')
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

                        datatable.draw('page')
                    },
                    success: function () {
                        $('#deleteSetting').modal('hide')
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

                        datatable.draw('page')
                    }
                });
            });

            /////////////// DELETE MULTIPLE
            $(document).on('click', '#select_all_ids_setting', function () {
                $(".checkbox_ids_setting").prop('checked', $(this).prop('checked'));
            });
            $(document).on('click', '#deleteAllSelectedSetting', function (event) {
                event.preventDefault();
                let all_ids = []
                $('input:checked[name=ids_setting]:checked').each(function () {
                    all_ids.push($(this).val())
                })

                all_ids = all_ids.join(",")
                $('#delete_multiple_setting').modal('show')
                $('#confirm_setting_multiple_button').val(all_ids)
            })
            $(document).on('click', '#confirm_setting_multiple_button', function (e) {
                e.preventDefault();

                let id = $(this).val();

                $.ajax({
                    url: `/admin/settings/` + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    error: function (xhr, status, error) {
                        $('#delete_multiple_setting').modal('hide')
                        let existingToast = document.querySelector(".toastify");
                        if (existingToast) {
                            existingToast.remove();
                        }
                        Toastify({
                            text: "Đã xảy ra lỗi khi xóa",
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
                        $('#delete_multiple_setting').modal('hide')
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

                        datatable.draw('page')
                    }
                })
            })


            ///////////////////////// SEARCH SETTING
            $(document).on('submit', '#setting_search_form', function (e) {
                e.preventDefault();
                datatable.ajax.reload();
            });

            ///////////////////////// RESET SETTING
            const reset_btn_setting = document.getElementById('reset_btn_setting')

            if (reset_btn_setting) {
                reset_btn_setting.addEventListener('click', function (event) {
                    event.preventDefault();
                    document.getElementById('key_setting').value = '';
                    document.getElementById('value_setting').value = '';
                    document.getElementById('status_setting').value = '';

                    datatable.draw('page');
                });
            }

        })
    </script>

    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $(document).ready(function () {
            var route_prefix = "/laravel-filemanager";
            $('#lfm_front').filemanager('image', {prefix: route_prefix}, function (url, path) {
                console.log(url)
            });
            $('#lfm_admin').filemanager('image', {prefix: route_prefix}, function (url, path) {
                console.log(url)
            });
        })
    </script>
@endpush
