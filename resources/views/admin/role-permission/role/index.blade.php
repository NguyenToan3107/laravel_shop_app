{{--<x-app-web-layout>--}}

@extends('admin.layouts.app')

@section('content')
    @include('admin.role-permission.nav-links')

    <div class="container">
        <div class="row" style="width: 821px; margin: 0 auto">
            <div class="col-md-12">
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
                @elseif(session('status_delete'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            Toastify({
                                text: "{{ session('status_delete') }}",
                                duration: 2000,
                                close: true,
                                gravity: "top", // `top` or `bottom`
                                position: "right", // `left`, `center` or `right`
                                stopOnFocus: true, // Prevents dismissing of toast on hover
                                className: "toastify-custom toastify-error"
                            }).showToast();
                        });
                    </script>
                @endif
                <div class="card d-flex flex-column h-100 mt-3">
                    <div class="card-header">
                        <h4>
                            Vai trò
                            <a href="{{url('admin/roles/create')}}" class="btn btn-primary float-end">Tạo mới</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tên</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{$role->id}}</td>
                                    <td>{{$role->name}}</td>
                                    <td>
                                        <div class="flex-form">
                                            @can('edit-role')
                                                <a href="{{url('admin/roles/'.$role->id.'/give-permissions')}}"
                                                   class="btn btn-warning">Thêm quyền vào vài trò</a>
                                                <a href="{{url('admin/roles/'.$role->id.'/edit')}}"
                                                   class="btn btn-success">Sửa</a>
                                            @endcan

                                            @can('delete-role')
                                                <form action="/admin/roles/{{ $role->id }}" method="post" class="mb-0">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger mx-2">Xóa</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{--</x-app-web-layout>--}}
