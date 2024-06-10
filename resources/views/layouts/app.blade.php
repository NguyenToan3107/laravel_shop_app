<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    {{--     data table--}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    {{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>--}}
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.8/sb-1.7.1/datatables.min.css" rel="stylesheet">

    <script src="{{asset('assets/js/display_image.js')}}" defer></script>

    <script src="https://cdn.datatables.net/v/dt/dt-2.0.8/sb-1.7.1/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    {{--    <script src="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css"></script>--}}

    {{--    tiny mce--}}
    <script src="https://cdn.tiny.cloud/1/p4pd0kdmn0lef2fn8v8fn4teyk9zypqxwcpckps4lyygmce8/tinymce/7/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '.textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss markdown',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [
                {value: 'First.Name', title: 'First Name'},
                {value: 'Email', title: 'Email'},
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
        });
    </script>

    <link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}}">
{{--    <script src="{{asset('assets/js/dashboard.js')}}" defer></script>--}}

    <title>Document</title>

</head>
<body>
<div class="wrapper">
    @include('layouts.sidebar')
    <div class="main">
        @include('layouts.header')
        <div style="margin-bottom: 80px"></div>
        @yield('content')
    </div>
</div>
@include('layouts.footer')

@stack('scripts')

</body>
</html>
