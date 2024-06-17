<div class="flex-form">
    @can('edit-permission')
        <a href="{{url('permissions/'.$permission->id.'/edit')}}"
           class="btn btn-success">Sửa</a>
    @endcan

    @can('delete-permission')
        <form action="/permissions/{{ $permission->id }}" method="post" class="mb-0">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger mx-2">Xóa</button>
        </form>
    @endcan
</div>
