<div class="d-flex align-items-center">
    @can('edit-user')
        <a href="/users/{{$user->id}}/edit" class="btn btn-primary btn-sm mr-2">Sửa</a>
    @endcan

    {{--  soft delete   --}}
    @can('delete-user')
        <button style="margin-left: 6px" value="{{$user->id}}" data-id="{{$user->id}}"
                class="btn btn-danger btn-sm delete_button_user">Xóa
        </button>
    @endcan
</div>
