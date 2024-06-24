<div class="d-flex align-items-center">
    @can('view-order')
        <a href="/admin/orders/{{$order->id}}"
           class="btn btn-success btn-sm mr-2" style="margin-left: 6px">Xem</a>
    @endcan
    @can('edit-order')
        <a href="/admin/orders/{{$order->id}}/edit"
           class="btn btn-primary btn-sm mr-2" style="margin-left: 6px">Sửa</a>
    @endcan
    @can('delete-order')
        <button style="margin-left: 6px" value="{{$order->id}}" data-id="{{$order->id}}"
                class="btn btn-danger btn-sm delete_button_order">Xóa</button>
    @endcan
</div>
