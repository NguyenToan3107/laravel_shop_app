{{--<div class="d-flex align-items-center">--}}
{{--    <a href="/users/{{$user->id}}/edit"--}}
{{--       class="btn btn-primary btn-sm mr-2">Sửa</a>--}}
{{--    <button style="margin-left: 6px" value="{{$user->id}}" data-id="{{$user->id}}" class="btn btn-danger btn-sm delete_button_user">Xóa</button>--}}
{{--</div>--}}

<div class="d-flex align-items-center">
    <a href="/users/{{$user->id}}/edit" class="btn btn-primary btn-sm mr-2">Sửa</a>
    <form action="/users/{{ $user->id }}" method="post" class="mb-0">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
    </form>
</div>
