<div class="d-flex align-items-center">
    @can('edit-product')
        <a href="/admin/products/{{$product->id}}/edit"
           class="btn btn-primary btn-sm mr-2"><i class="fa-solid fa-wrench"></i></a>
    @endcan

    @can('delete-product')
        <button value="{{$product->id}}" data-id="{{$product->id}}" class="btn btn-danger btn-sm trash_button_product">
            <i class="fa-solid fa-trash"></i>
        </button>
    @endcan
</div>

