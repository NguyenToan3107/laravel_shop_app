<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Họ và tên</th>
        <th>Số điện thoại</th>
        <th>Địa chỉ</th>
        <th>Khuyến mãi</th>
        <th>Giá</th>
        <th>Trạng thái</th>
        <th>Ngày đặt</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->fullname }}</td>
            <td>{{ $order->phone }}</td>
            <td>{{ $order->phone }}</td>
            <td>{{ $order->percent_sale }}%</td>
            <td>{{ number_format($order->price * 1000, 0) }}đ</td>
                <?php
                $status = '';
                $message = [
                    1 => 'Chờ xác nhận',
                    2 => 'Đã xác nhận',
                    3 => 'Đang xử lý',
                    4 => 'Đã giao hàng',
                    5 => 'Hoàn thành',
                    6 => 'Đã hủy'
                ];

                if (isset($message[$order->status])) {
                    $status = $message[$order->status];
                } else {
                    $status = 'Trạng thái không xác định'; // Default message for undefined statuses
                }
                ?>
            <td>{{ $status }}</td>
            <td>{{ $order->updated_at->format('d/m/Y') }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>

    <tr>
        <th colspan="2">Tổng tiền</th>

        <th>{{number_format($total_price * 1000, 0)}} đ</th>
    </tr>
    </tfoot>
</table>

