<div class="d-flex align-items-center">
    @can('edit-attribute')
        <a href="/admin/product_attributes/{{$product_attribute->id}}/edit"
           class="btn btn-primary btn-sm mr-2" style="margin-left: 6px"><i class="fa-solid fa-wrench"></i></a>
    @endcan
    @can('delete-attribute')
        <button style="margin-left: 6px" value="{{$product_attribute->id}}" data-id="{{$product_attribute->id}}"
                class="btn btn-danger btn-sm delete_button_product_attribute"><i class="fa-solid fa-trash"></i></button>
    @endcan
</div>
