<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <title>Chi tiết hóa đơn</title>
    <style>
        body {
            /*font-family: 'DejaVu Sans', sans-serif;*/
            font-family: DejaVu Sans, sans-serif;
        }
        .order_info {
            display: flex;
            flex-direction: row;
            gap: 100px;
            margin: 50px 0;
        }
        .order_info--user {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .order_payment {
            margin-top: 50px;
            display: flex;
            flex-direction: column;
            float: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Đơn hàng số #{{ $order->id }}</h1>
        <h2>Chi tiết nội dung đơn hàng</h2>
        <div class="order_info">
            <div class="order_info--user">
                @if(isset($user))
{{--                    <img class="order_info--user--image" src="{{$user->image_path}}" alt="{{$user->name}}">--}}
                    <p class="order_info--user--name">Tên: {{$user->name}}</p>
                    <p class="order_info--user--email">Email: {{$user->email}}</p>
                @else
{{--                    <img class="order_info--user--image" src="{{asset('images/users/default_user.jpg')}}" alt="Ẩn danh">--}}
                    <p class="order_info--user--name">Tên: Ẩn danh</p>
                    <p class="order_info--user--email">Email: Ẩn danh</p>
                @endif
            </div>
            <div class="order_info--order">
                <p>Tên đặt hàng: {{$order->fullname}}</p>
                <p>Số điện thoại đặt hàng: {{$order->phone}}</p>
                <p>Địa chỉ đặt hàng: {{$order->address}}</p>
            </div>
        </div>

        <table>
            <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Giá tiền(đ)</th>
                <th>Số lượng</th>
                <th>Khuyến mãi</th>
                <th>Tổng tiền(đ)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->orderDetails as $order_detail)
                <tr>
                    <td>{{ $order_detail->products->title }}</td>
                    <td>{{ number_format($order_detail->products->price * 1000, 0) }}</td>
                    <td>{{ $order_detail->quantity }}</td>
                    <td>{{ $order_detail->products->percent_sale }}%</td>
                    <td>{{ number_format($order_detail->unit_price * 1000, 0) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="order_payment">
                <?php
                $sub_total = number_format($order->price * 1000, 0);
                $discount = number_format(($order->percent_sale / 100) * $order->price * 1000, 0);
                $total =number_format(($order->price - (($order->percent_sale / 100) * $order->price) - 30) * 1000, 0);
                ?>
            <p>Tổng phụ: {{$sub_total}} đ</p>
            <p>Khuyến mãi: {{$discount}} đ</p>
            <p>Phí vận chuyển: 30,000 đ</p>
            <p style="font-weight: bold">Tổng tiền: {{$total}} đ</p>
        </div>
    </div>
</body>
</html>
