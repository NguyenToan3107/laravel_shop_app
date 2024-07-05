<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Anon - eCommerce Website</title>

    {{--  AJAX  --}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{--favicon--}}
    <link rel="shortcut icon" href="{{asset('assets/frontend/images/logo/favicon.ico')}}" type="image/x-icon">

    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">

    <script src="{{asset('assets/frontend/js/script.js')}}" defer></script>
    {{-- google font link  --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">

    {{--  Boottstrap  --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

    {{-- Fontaweome --}}
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>

    {{-- Toast --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js" defer></script>

    {{--  slide swiper  --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>

    @stack('style')


</head>

<body>

{{-- TOP HEADER --}}
<div class="header_top">
    <p>Summer Sale For All Swim Suits And Free Express Delivery - OFF 50%! <span style="margin-left: 10px">ShopNow</span></p>

    <select class="select_language" aria-label="Small select example">
        <option value="1">English</option>
        <option value="2">Việt Nam</option>
        <option value="3">Nhật Bản</option>
    </select>
</div>

{{-- HEADER --}}
@include('frontend.layouts.header.header')

<div class="main">
    @yield('content')
</div>

@include('frontend.layouts.footer.footer')

@stack('scripts')

<script src="{{asset('assets/frontend/js/script.js')}}"></script>
<!--
  - ionicon link
-->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
@stack('scripts')

</body>

</html>

