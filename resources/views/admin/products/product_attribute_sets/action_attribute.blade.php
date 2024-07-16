<div class="d-flex align-items-center">
    @can('edit-attribute')
        <a href="/admin/product_attributes/{{$product_attribute->id}}/edit"
           class="btn btn-primary btn-sm mr-2" style="margin-left: 6px"><i class="fa-solid fa-wrench"></i></a>
    @endcan
    @can('delete-attribute')
        <button type="submit" class="btn btn-danger btn-sm delete_product_attribute_set"
                data-set="{{$product_attribute_set->id}}" data-attr="{{$product_attribute->id}}"
                style="margin-left: 6px">
            <i class="fa-solid fa-trash"></i>
        </button>
    @endcan
</div>

