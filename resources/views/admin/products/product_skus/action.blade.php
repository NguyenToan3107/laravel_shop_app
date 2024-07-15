<div class="d-flex align-items-center">
    @can('edit-product')
        <a href="/admin/products/{{$product->id}}/product_skus/{{$product_sku->id}}/edit"
           class="btn btn-primary btn-sm mr-2" style="margin-left: 6px"><i class="fa-solid fa-wrench"></i></a>
    @endcan
    @can('delete-product')
        <form action="/admin/products/{{$product->id}}/product_skus/{{$product_sku->id}}" method="post">
            @method('delete')
            @csrf
            <button type="submit" style="margin-left: 6px" class="btn btn-danger btn-sm">
                <i class="fa-solid fa-trash"></i>
            </button>
        </form>
    @endcan
</div>
