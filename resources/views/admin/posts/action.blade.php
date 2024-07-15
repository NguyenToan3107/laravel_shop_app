<div class="d-flex align-items-center">
    @can('edit-post')
        <a href="/admin/posts/{{$post->id}}/edit"
           class="btn btn-primary btn-sm mr-2">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
    @endcan
    @can('delete-post')
        <button style="margin-left: 6px" value="{{$post->id}}" data-id="{{$post->id}}"
                class="btn btn-danger btn-sm delete_button_post">
            <i class="fa-solid fa-trash"></i>
        </button>
    @endcan
</div>

