@extends('admin.layouts.app')

@section('content')

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 2000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "toastify-custom toastify-success"
                }).showToast();
            });
        </script>

    @elseif(session('delete'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Toastify({
                    text: "{{ session('delete') }}",
                    duration: 2000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "toastify-custom toastify-error"
                }).showToast();
            });
        </script>

    @elseif(session('info'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Toastify({
                    text: "{{ session('info') }}",
                    duration: 2000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "toastify-custom toastify-info"
                }).showToast();
            });
        </script>
    @endif

    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="text-center">{{$product_attribute_set->name}}</h2>
                <input type="hidden" name="" class="product_set_id" data-id="{{$product_attribute_set->id}}">
            </div>
        </div>
        @can('create-attribute')
            <div class="product_attribute_set_create">
                <form action="/admin/product_attribute_sets/{{$product_attribute_set->id}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="product_attribute">Chọn thuộc tính</label>
                        <select id="product_attribute" class="product_attribute form-control" name="name[]" multiple>
                            @foreach($product_attributes as $product_attribute)
                                <option value="{{$product_attribute->id}}"
                                    {{in_array($product_attribute->id, $product_attribute_by_sets) ? 'selected' : ''}}>
                                    {{$product_attribute->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="product_attribute_set_create--lable btn btn-secondary">Thêm thuộc tính</button>
                </form>
            </div>
        @endcan
        <br>
        <br>
        <div class="row">
            <div class="col-md-12">
                <table id="product_attribute__by_set" class="table">
                    <thead>
                    <tr>
                        <th><input type="checkbox" name="" id="select_all_ids_product_attribute_by_set"/></th>
                        <th>Id</th>
                        <th>Tên thuộc tính</th>
                        <th>Giá trị</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <br>
    <br>
    <button class="btn btn-secondary"><a style="color: white" href="/admin/product_attribute_sets">Quay lại</a></button>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.product_attribute').select2({
                placeholder: "Chọn thuộc tính",
                tags: "true",
            });

            let product_set_id = $('.product_set_id').data('id');
            console.log(product_set_id);

            let datatable = $('#product_attribute__by_set').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/admin/product_attribute_sets/' + product_set_id + '/edit',
                    type: 'GET',
                },
                scrollX: true,
                order: [[1, 'asc']],
                autoWidth: false,
                columns: [
                    {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'value', name: 'value'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            })
        });
    </script>
@endpush


