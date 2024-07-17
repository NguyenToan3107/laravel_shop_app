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

        <form action="/admin/settings/updateLogo" method="post" class="form-setting">
            @csrf
            <p>Tiêu đề trang: </p>
            <input class="form-control" type="text" name="sys_title" id="" value="{{config('app.sys_title')}}">
            <br>
            <p>Địa chỉ: </p>
            <input class="form-control" type="text" name="sys_address" id="" value="{{config('app.sys_address')}}">
            <br>
            <div style="display:flex; justify-content: space-between; flex-direction: row; gap: 40px">
                <div style="flex: 1">
                    <p>Số điện thoại: </p>
                    <input class="form-control" type="text" name="sys_phone" id="" value="{{config('app.sys_phone')}}">
                </div>
                <div style="flex: 1">
                    <p>Số hotline: </p>
                    <input class="form-control" type="text" name="sys_hotline" id="" value="{{config('app.sys_hotline')}}">
                </div>
            </div>
            <br>
            <p>Thời gian làm việc: </p>
            <input class="form-control" type="text" name="sys_worktime" id="" value="{{config('app.sys_worktime')}}">
            <br>
            <p>Địa chỉ email: </p>
            <input class="form-control" type="text" name="sys_mail" id="" value="{{config('app.sys_mail')}}">
            <br>

            <div style="display:flex; justify-content: space-between; flex-direction: row; gap: 40px">
                <div style="flex: 1">
                    <p>Facebook: </p>
                    <input class="form-control" type="text" name="sys_fanpage" id="" value="{{config('app.sys_fanpage')}}">
                </div>
                <div style="flex: 1">
                    <p>Youtube: </p>
                    <input class="form-control" type="text" name="sys_youtube" id="" value="{{config('app.sys_youtube')}}">
                </div>
            </div>
            <br>
            <p>Keyword: </p>
            <textarea name="sys_keyword" id="sys_footer" class="textarea" cols="30" rows="10">
                {{config('app.sys_keyword')}}
            </textarea>
            <br>
            <div style="display: flex; flex-direction: row; justify-content: space-between">
                <div class="form-group img_setting">
                    <p>Ảnh logo: </p>
                    @if(isset($sys_logo))
                        <div id="imageDisplay_logo">
                            <img src="{{ asset($sys_logo) }}" id="imageDisplay"
                                 class="img-thumbnail user-image-detail-80" alt="Avatar">
                        </div>
                    @endif
                    <div class="input-group">
                        <span class="input-group-btn">
                         <a id="lfm_logo" data-input="thumbnail_logo" data-preview="imageDisplay_logo"
                            class="btn_setting">Thay đổi</a>
                            <button class="btn_setting">Xóa</button>
                       </span>
                        <input id="thumbnail_logo" hidden class="form-control" type="text" name="filepath_logo">
                    </div>
                </div>
                <div class="form-group img_setting">
                    <p>Ảnh Logo Mobile: </p>
                    @if(isset($sys_logo_mobile))
                        <div id="imageDisplay_logo_mobile">
                            <img src="{{ asset($sys_logo_mobile) }}" id="imageDisplay"
                                 class="img-thumbnail user-image-detail-80" alt="Avatar">
                        </div>
                    @endif
                    <div class="input-group">
                        <span class="input-group-btn">
                         <a id="lfm_logo_mobile" data-input="thumbnail_logo_mobile" data-preview="imageDisplay_logo_mobile"
                            class="btn_setting">Thay đổi</a>
                            <button class="btn_setting">Xóa</button>
                       </span>
                        <input id="thumbnail_logo_mobile" hidden class="form-control" type="text" name="filepath_logo_mobile">
                    </div>
                </div>
                <div class="form-group img_setting">
                    <p>Ảnh Favicon: </p>
                    @if(isset($sys_favicon))
                        <div id="imageDisplay_favicon">
                            <img src="{{ asset($sys_favicon) }}" id="imageDisplay"
                                 class="img-thumbnail user-image-detail-80" alt="Avatar">
                        </div>
                    @endif
                    <div class="input-group">
                        <span class="input-group-btn">
                         <a id="lfm_favicon" data-input="thumbnail_favicon" data-preview="imageDisplay_favicon"
                            class="btn_setting">Thay đổi</a>
                            <button class="btn_setting">Xóa</button>
                       </span>
                        <input id="thumbnail_favicon" hidden class="form-control" type="text" name="filepath_favicon">
                    </div>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-danger" style="width: 200px;">Cập nhật</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $(document).ready(function () {
            var route_prefix = "/laravel-filemanager";
            $('#lfm_logo').filemanager('image', {prefix: route_prefix}, function (url, path) {
                console.log(url)
            });
            $('#lfm_logo_mobile').filemanager('image', {prefix: route_prefix}, function (url, path) {
                console.log(url)
            });
            $('#lfm_favicon').filemanager('image', {prefix: route_prefix}, function (url, path) {
                console.log(url)
            });
        })
    </script>
@endpush

