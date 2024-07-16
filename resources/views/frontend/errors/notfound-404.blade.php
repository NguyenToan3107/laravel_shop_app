<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>

    {{--  Boottstrap  --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
</head>
<body>
<div style="display: flex; flex-direction: row; justify-content: center; align-items: center; width: 100%; height: 100vh;">
    <div class="container text-center">
        <h1>404</h1>
        <h3>Trang không tồn tại</h3>
        <p>Xảy ra lỗi, trang tìm kiếm không tồn tại</p>
        <a href="{{ url('/') }}" class="btn btn-danger">Về trang chủ</a>
    </div>
</div>
</body>
</html>

