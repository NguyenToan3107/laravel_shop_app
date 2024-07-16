@extends('admin.layouts.app')

@section('title', 'Đơn đặt ' . ucwords($user->name))

@section('content')
    <div class="container">
        <h1 class="order_detail_id" data-id="{{$order->id}}">Đơn hàng số #{{ $order->id }}</h1>
        <h2>Chi tiết nội dung đơn hàng</h2>
        <div class="order_info">
            <div class="order_info--user">
                @if(isset($user))
                    <img class="order_info--user--image" src="{{$user->image_path}}" alt="{{$user->name}}">
                    <p class="order_info--user--name">Tên: {{$user->name}}</p>
                    <p class="order_info--user--email">Email: {{$user->email}}</p>
                @else
                    <img class="order_info--user--image" src="{{asset('images/users/default_user.jpg')}}" alt="Ẩn danh">
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
        @can('view-order-detail')
            <a href="/admin/orders/order_detail/{{$order->id}}" class="btn btn-secondary margin_bottom_detail" style="margin-left: 770px">
                <i class="fa-solid fa-download"></i>
                In hóa đơn
            </a>
        @endcan
        <div class="row">
            <div class="col-md-12">
{{--                {{ $dataTable->table()}}--}}
                <table id="orderdetails-table" class="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá tiền</th>
                        <th>Số lượng</th>
                        <th>Khuyến mãi</th>
                        <th>Tổng giá</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

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

        @can('view-order')
        <button class="btn btn-secondary">
            <a style="text-decoration: none; color: white; font-weight: 500" href="/admin/orders">
                <i class="fa-regular fa-circle-left"></i>
                Quay lại
            </a>
        </button>
        @endcan
    </div>
@endsection

@push('scripts')
{{--    {{ $dataTable->scripts() }}--}}
<script>
    $(document).ready(function () {
        let order_detail_id = $('.order_detail_id').data('id')

        $('#orderdetails-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/admin/orders/' + order_detail_id,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token vào header
                },
            },
            scrollX: true,
            order: [[0, 'asc']],
            autoWidth: false,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'image', name: 'fullname'},
                {data: 'product_title', name: 'phone'},
                {data: 'product_price', name: 'address'},
                {data: 'quantity', name: 'percent_sale'},
                {data: 'product_percent_sale', name: 'price'},
                {data: 'total', name: 'status'},
            ]
        });
    })

</script>
@endpush
