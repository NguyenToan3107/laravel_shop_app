<div class="d-flex align-items-center">
    @can('edit-attribute-set')
        <a href="/admin/product_attribute_sets/{{$product_attribute_set->id}}/edit"
           class="btn btn-primary btn-sm mr-2 product_set_id" style="margin-left: 6px"><i class="fa-solid fa-wrench"></i></a>
    @endcan
    @can('delete-attribute-set')
        <button style="margin-left: 6px" value="{{$product_attribute_set->id}}" data-id="{{$product_attribute_set->id}}"
                class="btn btn-danger btn-sm delete_button_product_attribute_set"><i class="fa-solid fa-trash"></i></button>
    @endcan
</div>
