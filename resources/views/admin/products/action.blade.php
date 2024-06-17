<div class="d-flex align-items-center">
    @can('buy-product')
        <a href="#" class="btn btn-success btn-sm mr-2">Mua</a>
    @endcan
    @can('edit-product')
        <a href="/admin/products/{{$product->id}}/edit"
           class="btn btn-primary btn-sm mr-2" style="margin-left: 6px">Sửa</a>
    @endcan
    @can('delete-product')
        <button style="margin-left: 6px" value="{{$product->id}}" data-id="{{$product->id}}"
            class="btn btn-danger btn-sm delete_button_product">Xóa</button>
    @endcan
</div>
