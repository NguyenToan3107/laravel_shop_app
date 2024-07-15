<div class="flex-form">
    @can('edit-permission')
        <a href="{{url('admin/permissions/'.$permission->id.'/edit')}}"
           class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i></a>
    @endcan
    @can('delete-permission')
        <form action="/admin/permissions/{{ $permission->id }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
        </form>
    @endcan
</div>
