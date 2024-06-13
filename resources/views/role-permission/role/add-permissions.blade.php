@extends('layouts.app')

@section('content')

    @if(session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Toastify({
                    text: "{{ session('status') }}",
                    duration: 2000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "toastify-custom toastify-success"
                }).showToast();
            });
        </script>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card d-flex flex-column h-100">
                    <div class="card-header">
                        <h4>
                            Vai trò: {{$role->name}}
                            <a href="{{url('roles')}}" class="btn btn-danger float-end">Quay lại</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{url('roles/'. $role->id . '/give-permissions')}}" method="POST">
                            @csrf
                            @method('put')
                            <div class="mb-3">

                                @error('permission')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror

                                <label for="">Quyền:</label>
                                <div class="row">
                                    @foreach($permissions as $permission)
                                        <div class="col-md-2">
                                            <label>
                                                <input type="checkbox"
                                                       name="permission[]"
                                                       value="{{$permission->name}}"
                                                       {{in_array($permission->id, $rolePermissions) ? 'checked' : ''}}
                                                />
                                                {{$permission->name}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

