@extends('layouts.app')

@section('content')
    <div class="container mt-5 d-flex justify-content-center margin_bottom_detail border_detail">
        <div class="border_create w-100">
            <h2 class="text-center mb-4">Tạo mới người dùng</h2>
            <form action="/users" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Tên</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="phoneNumber">Số điện thoại</label>
                    <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="age">Tuổi</label>
                    <input type="number" class="form-control" id="age" name="age" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <br>
{{--                <div class="form-group">--}}
{{--                    <label for="role">Role</label>--}}
{{--                    <select class="form-control" name="roles[]" multiple>--}}
{{--                        <option value="">Chọn vai trò</option>--}}
{{--                    @foreach($roles as $role)--}}
{{--                        <option value="{{$role}}">{{$role}}</option>--}}
{{--                    @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}
                <div class="form-group">
                    <label>Chọn vai trò</label>
                    @foreach($roles as $role)
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" name="roles[]" value="{{ $role }}" class="form-check-input">
                                {{ $role }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <br>
                <div class="form-group" style="display: flex; flex-direction: row; gap: 150px; align-items: center">
                    <div>
                        <label for="name">Ảnh</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <img src="{{ asset('images/users/default_user.jpg') }}" id="imageDisplay" class="img-thumbnail user-image-detail-80" alt="Avatar">
                </div>
                <br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Tạo mới</button>
                </div>
            </form>
            <button class="btn btn-secondary" style="margin-left: 10px"><a style="color: white" href="/users">Quay lại</a></button>
        </div>
    </div>
@endsection
