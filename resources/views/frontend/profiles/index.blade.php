@extends('frontend.layouts.app')

@section('title', 'Hồ sơ')

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

    @elseif(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Toastify({
                    text: "{{ session('error') }}",
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

    <div class="detail_nav">
        <a href="/">Trang chủ</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="/profile">Tài khoản của tôi</a>
        <i class="fa-solid fa-chevron-right"></i>
    </div>
    <div class="profile">
        <div>
            <div class="profile_account">
                <h6>Khoản lý tài khoản</h6>
                <ul>
                    <li><a style="color: #DB4444" href="#">Tài khoản</a></li>
                    <li><a href="#">Địa chỉ sách</a></li>
                    <li><a href="#">Tùy chọn thanh toán</a></li>
                </ul>
            </div>
            <div class="profile_account">
                <h6>Đơn đặt hàng</h6>
                <ul>
                    <li><a href="#">Đã mua</a></li>
                    <li><a href="#">Đang chờ duyệt</a></li>
                    <li><a href="#">Đơn đã hủy</a></li>
                </ul>
            </div>
            <div class="profile_account">
                <h6>Danh sách sản phẩm yêu thích</h6>
            </div>
        </div>
        <div class="profile_form">
            <h5>Chỉnh sửa hồ sơ</h5>
            <form action="/profile/change-password" method="post">
                @csrf
                @method("put")
                <div class="mb-3">
                    <label for="" class="form-label">Tên</label>
                    <input type="text" class="form-control" placeholder="{{$user->name}}">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="{{$user->email}}">
                    <div id="emailHelp" class="form-text">Chúng tôi sẽ không bao giờ chia sẻ email của bạn với bất kỳ ai.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Thay đổi mật khẩu</label>
                    <input type="password" name="current_password" required class="form-control" id="exampleInputPassword1" placeholder="Mật khẩu hiện tại">
                    <br>
                    <input type="password" name="new_password" required class="form-control" placeholder="Mật khẩu mới">
                    <br>
                    <input type="password" name="new_password_confirmation" required class="form-control" placeholder="Nhập lại mật khẩu">
                </div>

                <button type="submit" class="btn btn-secondary">Hủy</button>
                <button style="margin-left: 6px;" type="submit" class="btn btn-danger">Lưu</button>
            </form>
        </div>
    </div>
@endsection
