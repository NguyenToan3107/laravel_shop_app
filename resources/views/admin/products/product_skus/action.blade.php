<div class="d-flex align-items-center">
    @can('edit-product')
        <a href="/admin/products/{{$product->id}}/product_skus/{{$product_sku->id}}/edit"
           class="btn btn-primary btn-sm mr-2" style="margin-left: 6px"><i class="fa-solid fa-wrench"></i></a>
    @endcan
    @can('delete-product')
        <button style="margin-left: 6px" value="{{$product_sku->id}}" data-id="{{$product_sku->id}}"
                class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
    @endcan
</div>
