<div class="d-flex align-items-center">
    @can('edit-category')
        <a href="/admin/posts/{{$category->id}}/edit"
           class="btn btn-primary btn-sm mr-2">Sửa</a>
    @endcan
    @can('delete-category')
        <button style="margin-left: 6px" value="{{$category->id}}" data-id="{{$category->id}}"
                class="btn btn-danger btn-sm delete_button_category">Xóa
        </button>
    @endcan
</div>
