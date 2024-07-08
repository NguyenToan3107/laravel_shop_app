@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="text-center">Danh mục sản phẩm</h2>
            </div>
        </div>
        <br>
        @can('create-category')
            <a href="categories/create"
               class="btn btn-primary margin_bottom_detail">
                Tạo mới một danh mục sản phẩm
            </a>
        @endcan
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Mô tả</th>
                    </tr>
                    </thead>
                    <tbody id="userTable">
                    @foreach($categories as $category)
                        <x-list-category :category="$category" :level="0" />
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

{{--@push('scripts')--}}
{{--    {{ $dataTable->scripts() }}--}}
{{--@endpush--}}
