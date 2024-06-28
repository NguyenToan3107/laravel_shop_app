<div class="d-flex align-items-center">
    @can('edit-attribute')
        <a href="/admin/product_attributes/{{$product_attribute->id}}/edit"
           class="btn btn-primary btn-sm mr-2" style="margin-left: 6px"><i class="fa-solid fa-wrench"></i></a>
    @endcan
    @can('delete-attribute')
        <form action="/admin/product_attribute_sets/{{$product_attribute_set->id}}/product_attribute/{{$product_attribute->id}}" method="post"
              class="mb-0" style="margin-left: 6px">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
        </form>
    @endcan
</div>

