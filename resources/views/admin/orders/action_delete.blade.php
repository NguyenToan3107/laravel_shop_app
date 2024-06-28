<div class="d-flex align-items-center">
    @can('view-order')
        <a href="/admin/orders/{{$order->id}}"
           class="btn btn-success btn-sm mr-2" style="margin-left: 3px"><i class="fa-solid fa-eye"></i></a>
    @endcan
    @can('edit-order')
        <a href="/admin/orders/{{$order->id}}/edit"
           class="btn btn-primary btn-sm mr-2" style="margin-left: 3px"><i class="fa-solid fa-wrench"></i></a>
    @endcan
    @can('delete-order')
        <button style="margin-left: 3px" value="{{$order->id}}" data-id="{{$order->id}}"
                class="btn btn-danger btn-sm delete_button_order"><i class="fa-solid fa-trash"></i></button>
    @endcan
</div>
