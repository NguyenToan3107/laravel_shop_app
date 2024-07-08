<div class="d-flex align-items-center">
    @can('edit-product')
        <a href="/admin/products/{{$product->slug}}/edit"
           class="btn btn-primary btn-sm mr-2"><i class="fa-solid fa-wrench"></i></a>
    @endcan

    @can('delete-product')
        <button value="{{$product->slug}}" data-id="{{$product->slug}}" class="btn btn-danger btn-sm trash_button_product"
            style="margin-left: 6px;">
            <i class="fa-solid fa-trash"></i>
        </button>
    @endcan
</div>

