@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5 d-flex justify-content-center margin_bottom_detail border_detail">
        <div class="border_create w-100">
            <h2 class="text-center mb-4">Cập nhật đơn hàng</h2>
            <form action="/admin/orders/{{$order->id}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                    {{ Form::label('author_id', 'Người đặt') }}
                    <select class="row form-control" name="author_id" id="author_id">
                        <option value="{{$user->id}}">Hiện tại: {{$user->name}}</option>
                        @foreach ($users as $u)
                            @can('create-order')
                                <option value="{{$u->id}}">Tên: {{$u->name}}</option>
                            @endcan
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="form-group">
                    <label for="id">Mã đơn</label>
                    <input disabled type="text" class="form-control" id="id" name="id" value="{{$order->id}}" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="fullname">Tên dùng để đặt hàng</label>
                    <input type="text" class="form-control" id="fullname" value="{{$order->fullname}}" name="fullname" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" class="form-control" id="phoneNumber" value="{{$order->phone}}" name="phone" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <input type="text" class="form-control" id="address" value="{{$order->address}}" name="address" required>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        {{ $dataTable->table()}}
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <label for="status">Chọn trạng thái</label>
                    <select name="status" id="status" class="form-control" value="{{$order->status}}">
                        <option value="1">Chờ xác nhận</option>
                        <option value="2">Đã xác nhận</option>
                        <option value="3">Đang xử lý</option>
                        <option value="4">Đã giao hàng</option>
                        <option value="5">Hoàn thành</option>
                        <option value="6">Đã hủy</option>
                    </select>
                </div>
                <br>

                <div class="form-group">
                    <label for="percent_sale">Khuyến mãi</label>
                    <input type="text" class="form-control" id="percent_sale" value="{{$order->percent_sale}}" name="percent_sale" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="price">Giá tiền</label>
                    <input disabled type="text" class="form-control" id="price" value="{{number_format($order->price * 1000, 0)}}" name="price" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="description">Địa chỉ</label>
                    {{ Form::textarea('description', isset($order) ? $order->description : '', ['class' => 'form-control textarea', 'id' => 'description', 'cols' => 30, 'rows' => 10]) }}
                </div>
                <br>
                <div class="form-group">
                    {{ Form::label('content', 'Nội dung') }}
                    {{ Form::textarea('content', isset($order) ? $order->content : '', ['class' => 'form-control textarea', 'id' => 'content', 'cols' => 30, 'rows' => 10]) }}
                </div>
                <br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
            <button class="btn btn-secondary" style="margin-left: 10px"><a style="color: white" href="/admin/orders">Quay lại</a></button>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
