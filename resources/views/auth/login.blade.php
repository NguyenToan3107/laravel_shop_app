@extends('admin.layouts.guest')

@section('content_login')
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <div class="container">
        <div class="logo">
            <img src="{{asset('assets/frontend/images/background.png')}}" alt="">
        </div>

        <div class="form_login">

            <div class="header_nav">
                <div class="">
                    <h2 class="">Welcome👋</h2>
                    <p class="">Please login here </p>
                </div>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required autofocus autocomplete="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" name="password"
                           required autocomplete="current-password">
                </div>

                <div style="display: flex; flex-direction: row; justify-content: space-between">
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
                        <label class="form-check-label" for="exampleCheck1">Remember me</label>
                    </div>
                    <div class="forget_password">
                        @if (Route::has('password.request'))
                            <a style="margin-right: 10px"
                               class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                               href="{{ route('password.request') }}">
                                {{ __('Quên mật khẩu?') }}
                            </a>
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%">ĐĂNG NHẬP</button>

            </form>

            <div class="social_media">
                <a href="{{ url('auth/facebook') }}">
                    <i class="fa-brands fa-facebook" style="color: #005af5;"></i>
                    Facebook
                </a>
                <a href="{{ url('auth/google') }}">
                    <i class="fa-brands fa-google" style="color: #408bc4;"></i>
                    Google
                </a>
            </div>

            <a class="btn btn-secondary register_button" href="/register">Đăng ký</a>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .container {
            width: 900px;
            height: auto;
            margin: 70px auto 0;
            display: flex;
            flex-direction: row;
            gap: 20px;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .logo img{
            width: 460px;
            height: auto;
        }

        .form_login {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .forget_password a{
            text-decoration: none;
            color: #6c6b6b;
            font-style: italic;
        }
        .social_media {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            margin: 20px 0;
        }

        .social_media a{
            text-decoration: none;
            color: black;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 10px;
            padding: 5px 36px;
            border: 1px solid #BDBDBD;
            border-radius: 3px;
            cursor: pointer;
        }

        .social_media a:hover {
            background-color: #f6f3f3;
        }

        .social_media a i {
            font-size: 1.4rem;
        }

        .register_button {
            margin-top: auto;
            width: 100px;
            margin-left: auto;
        }
    </style>
@endpush




