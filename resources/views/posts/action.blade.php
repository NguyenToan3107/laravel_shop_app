<div class="d-flex align-items-center">
    @can('edit-post')
        <a href="/posts/{{$post->id}}/edit"
           class="btn btn-primary btn-sm mr-2">Sửa</a>
    @endcan
    @can('delete-post')
        <button style="margin-left: 6px" value="{{$post->id}}" data-id="{{$post->id}}"
                class="btn btn-danger btn-sm delete_button_post">Xóa
        </button>
    @endcan
</div>

