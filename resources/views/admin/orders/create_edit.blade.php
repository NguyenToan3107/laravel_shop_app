@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5 d-flex justify-content-center margin_bottom_detail">
        <div class="border_create w-100">
            <h2 class="text-center mb-4">{{ isset($order) ? 'Cập nhật đơn hàng' : 'Tạo mới đơn hàng' }}</h2>

            @if(isset($order))
                {{ Form::open(['route' => ['orders.update', $order->id], 'method' => 'POST', 'id' => 'formMain_update']) }}
                @method('PUT')
            @else
                {{ Form::open(['route' => 'orders.store', 'method' => 'POST', 'id' => 'formMain_create']) }}
            @endif

            @if(isset($order))
                <input type="hidden" name="{{$order->id}}" value="{{$order->id}}" id="order_update_id">
            @endif

            @if(isset($user))
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
            @else
                <div class="form-group">
                    {{ Form::label('author_id', 'Người đặt') }}
                    <select class="row form-control" name="author_id" id="author_id">
                        @foreach ($users as $user)
                            @can('create-order')
                                <option value="{{$user->id}}">Tên: {{$user->name}}</option>
                            @endcan
                        @endforeach
                    </select>
                </div>
            @endif

            <br>
            <div class="form-group">
                {{ Form::label('id', 'Mã đơn') }}
                {{ Form::text('id', $order->id ?? '', ['class' => 'form-control', 'id' => 'id', 'required']) }}
            </div>
            <br>
            <div class="form-group">
                {{ Form::label('fullname', 'Tên dùng để đặt hàng') }}
                {{ Form::text('fullname', $order->fullname ?? '', ['class' => 'form-control', 'id' => 'fullname', 'required']) }}
            </div>
            <br>
            <div class="form-group">
                {{ Form::label('phone', 'Số điện thoại') }}
                {{ Form::text('phone', $order->phone ?? '', ['class' => 'form-control', 'id' => 'phone', 'required']) }}
            </div>
            <br>
            <div class="form-group">
                {{ Form::label('address', 'Địa chỉ') }}
                {{ Form::text('address', $order->address ?? '', ['class' => 'form-control', 'id' => 'address', 'required']) }}
            </div>
            <br>
            <div class="form-group">
                {{ Form::label('description', 'Mô tả') }}
                {{ Form::textarea('description', isset($order) ? $order->description : '', ['class' => 'form-control textarea', 'id' => 'description', 'cols' => 30, 'rows' => 10]) }}
            </div>
            <br>
            <div class="form-group">
                {{ Form::label('content', 'Nội dung') }}
                {{ Form::textarea('content', isset($order) ? $order->content : '', ['class' => 'form-control textarea', 'id' => 'content', 'cols' => 30, 'rows' => 10]) }}
            </div>
            <br>

            @if(isset($order))
                <div class="form-group">
                    {{ Form::label('status', 'Chọn trạng thái') }}
                    {{ Form::select('status', [
                        '1' => 'Chờ xác nhận',
                        '2' => 'Đã xác nhận',
                        '3' => 'Đang xử lý',
                        '4' => 'Đã giao hàng',
                        '5' => 'Hoàn thành',
                        '6' => 'Đã hủy',
                    ], isset($order) ? $order->status : 1, ['class' => 'form-control', 'id' => 'status']) }}
                </div>
            @endif

            <br>
            @if(isset($order))
                <div class="row">
                    <div class="col-md-12">
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
            @endif
            <div class="form-group">
                {{ Form::label('percent_sale', 'Khuyến mãi') }}
                {{ Form::text('percent_sale', $order->percent_sale ?? '', ['class' => 'form-control', 'id' => 'percent_sale', 'required']) }}
            </div>
            <br>
            <div class="form-group">
                {{ Form::label('price', 'Tổng tiền') }}
                {{ Form::text('price', $order->price ?? '', ['class' => 'form-control', 'id' => 'price', 'required']) }}
            </div>
            <br>
            <div class="text-center">
                {{ Form::button(isset($order) ? 'Cập nhật đơn hàng' : 'Tạo mới đơn hàng', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>

            {{ Form::close() }}
            <button class="btn btn-secondary" style="margin-left: 10px"><a style="color: white" href="/admin/orders">Quay
                    lại</a></button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let order_update_id = $('#order_update_id').val()

            console.log(order_update_id)

            $('#orderdetails-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/admin/orders/' + order_update_id + '/edit',
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

