@extends('frontend.layouts.app')

@section('content')
    <div class="container my-5">
        <h2 class="mb-4">Đơn hàng của bạn</h2>

        @if($orders->isEmpty())
            <div class="alert alert-warning">Bạn chưa có đơn hàng nào.</div>
        @else
            <div class="order-list">
                @foreach($orders as $order)
                    <div class="card mb-4 shadow-lg border-0">
                        <div class="card-body">
                            <h5 class="card-title">Mã đơn hàng: <strong>#{{ $order->id }}</strong></h5>
                            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                            <p><strong>Trạng thái:</strong> <span class="badge bg-info text-dark">{{ $order->status }}</span></p>
                            <p><strong>Tổng giá:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VND</p>

                            <div class="product-list mt-3">
                                <h6>Sản phẩm đã mua:</h6>
                                <ul class="list-group">
                                    @foreach($order->orderDetails as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center gap-4">
                                            <div class="d-flex justify-start align-items-center gap-4">
                                                <img src="{{$item->products->image}}" alt="{{$item->products->title}}" width="50" height="50">
                                                <div>
                                                    <strong>{{ $item->products->title }}</strong> <br>
                                                    <span>Số lượng: {{ $item->quantity }}</span> <br>
                                                    <span>Giá: {{ number_format($item->products->price * 1000) }} VND</span>
                                                </div>
                                            </div>
                                            <span class="text-danger">Giá: {{ number_format($item->products->price * $item->quantity * 1000) }} VND</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Nút hành động -->
                            <div class="order-actions mt-3">
                                <a href="" class="btn btn-outline-success me-2">Mua lại</a>
                                <a href="" class="btn btn-outline-secondary">Liên hệ người bán</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

