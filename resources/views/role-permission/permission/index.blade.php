@extends('layouts.app')

@section('content')

    @include('role-permission.nav-links')

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
                            Quyền
                            <a href="{{url('permissions/create')}}" class="btn btn-primary float-end">Tạo mới</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        {{ $dataTable->table()}}
{{--                        <table class="table table-bordered table-striped">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>Id</th>--}}
{{--                                <th>Tên</th>--}}
{{--                                <th>Hành động</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($permissions as $permission)--}}
{{--                                <tr>--}}
{{--                                    <td>{{$permission->id}}</td>--}}
{{--                                    <td>{{$permission->name}}</td>--}}
{{--                                    <td>--}}
{{--                                        <div class="flex-form">--}}
{{--                                            <a href="{{url('permissions/'.$permission->id.'/edit')}}"--}}
{{--                                               class="btn btn-success">Sửa</a>--}}
{{--                                            <form action="/permissions/{{ $permission->id }}" method="post" class="mb-0">--}}
{{--                                                @csrf--}}
{{--                                                @method('delete')--}}
{{--                                                <button type="submit" class="btn btn-danger mx-2">Xóa</button>--}}
{{--                                            </form>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
