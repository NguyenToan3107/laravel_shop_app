{{--<div>--}}
{{--    <h2>{{ $data['type'] }}</h2>--}}
{{--    <p> <b>{{ $data['task'] }}</b> {{ $data['content'] }}</p>--}}
{{--</div>--}}

<div class="container">
    <div class="header">
        <h1>Xác nhận đơn hàng</h1>
    </div>
    <div class="content">
        <h2>Xin chào {{$data['name']}}</h2>
        <p>Cảm ơn bạn đã đặt hàng! Mã đơn hàng của bạn là <strong>#{{$data['order']->id}}</strong>.</p>
        <div class="order-details">
            <h2>Chi tiết đơn hàng</h2>
            <table>
                <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['order']->orderDetails as $order_detail)
                    <tr>
                        <td>{{$order_detail->products->title}}</td>
                        <td>{{$order_detail->quantity}}</td>
                        <td>{{number_format($order_detail->unit_price * 1000, 0)}} đ</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="2">Phí vận chuyển (Giao hàng toàn quốc)</th>
                    <th>30,000đ</th>
                </tr>
                <tr>
                    <th colspan="2">Tổng tiền</th>
                    <th>{{number_format($data['order']->price * 1000 - 30000, 0)}} đ</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <p>Nếu bạn có bất kì câu hỏi nào, vui lòng liên hệ đội ngũ hỗ trợ.</p>
    </div>
    <div class="footer">
        <p>&copy; 2024 công ty EXCLUSIVE, nhà phân phối toàn quốc.</p>
    </div>
</div>
