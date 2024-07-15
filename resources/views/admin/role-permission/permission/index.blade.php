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
                            Quyền
                            <a href="{{url('admin/permissions/create')}}" class="btn btn-primary float-end">Tạo mới</a>
                        </h4>
                    </div>
                    <div class="card-body">
{{--                        {{ $dataTable->table()}}--}}
                        <table id="permissions-table" class="table">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tên</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{--    {{ $dataTable->scripts() }}--}}
    <script>
        $('#permissions-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/admin/permissions',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token vào header
                },
            },
            scrollX: true,
            order: [[0, 'asc']],
            autoWidth: false,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action'}
            ]
        });
    </script>
@endpush
