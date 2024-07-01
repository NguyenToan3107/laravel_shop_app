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

    @elseif(session('error'))
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
    @endif
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card d-flex flex-column h-100">
                    <div class="card-header">
                        <h4>
                            Thông tin thuộc tính: {{ucwords($product_attribute->name)}}
                            <a href="{{url('admin/product_attributes')}}" class="btn btn-danger float-end">Quay lại</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <br>
                        <div class="d-flex" id="product_attribute_value_list">
                            @foreach($product_attribute_values as $product_attribute_value)
                                <h3 style="margin-right: 10px;">
                                    <span class="badge text-bg-secondary">
                                        {{$product_attribute_value->value}}
                                        <span class="delete_product_attribute_value" data-attr="{{$product_attribute->id}}" data-id="{{$product_attribute_value->id}}" style="margin-left: 5px;">
                                            <i class="fa-solid fa-xmark"></i>
                                        </span>
                                    </span>
                                </h3>
                            @endforeach
                        </div>
                        <br>
                        <form action="/admin/product_attributes/{{$product_attribute->id}}/product_attribute_value" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="">Tên thuộc tính: {{ucwords($product_attribute->name)}}</label>
                                <input type="text" name="value" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Tạo thêm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

