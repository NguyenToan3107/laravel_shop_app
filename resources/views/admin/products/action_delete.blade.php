<div class="d-flex align-items-center">
    @can('edit-product')
        <a href="/admin/products/{{$product->id}}/edit"
           class="btn btn-primary btn-sm mr-2">Sửa</a>
    @endcan

    @can('delete-product')
        <button value="{{$product->id}}" data-id="{{$product->id}}" class="btn btn-danger btn-sm trash_button_product">
            Xóa
        </button>
    @endcan
</div>

