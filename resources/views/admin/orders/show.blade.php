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
            <p>Tổng phụ: {{$order->price}} đ</p>
            <p>Khuyến mãi: {{$order->percent_sale * $order->price}} đ</p>
            <p>Phí vận chuyển: 30000 đ</p>
            <p style="font-weight: bold">Tổng tiền: {{$order->price - ($order->percent_sale * $order->price)}} đ</p>
        </div>

        @can('view-order')
        <button class="btn btn-secondary"><a style="text-decoration: none; color: black" href="/admin/orders">Quay lại</a></button>
        @endcan
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
