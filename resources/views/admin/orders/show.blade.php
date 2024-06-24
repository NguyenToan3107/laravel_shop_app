@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Đơn hàng số #{{ $order->id }}</h1>
        <h2>Chi tiết nội dung đơn hàng</h2>
        <div class="order_info">
            <div class="order_info--user">
                <img class="order_info--user--image" src="{{$user->image_path}}" alt="{{$user->name}}">
                <p class="order_info--user--name">Tên: {{$user->name}}</p>
                <p class="order_info--user--email">Email: {{$user->email}}</p>
            </div>
            <div class="order_info--order">
                <p>Tên đặt hàng: {{$order->fullname}}</p>
                <p>Số điện thoại đặt hàng: {{$order->phone}}</p>
                <p>Địa chỉ đặt hàng: {{$order->address}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{ $dataTable->table()}}
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
    {{ $dataTable->scripts() }}
@endpush
