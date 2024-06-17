@extends('admin.layouts.app')

@section('content')

    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="text-center">Category List</h2>
                <input class="form-control" id="searchInput" type="text" placeholder="Search users...">
            </div>
        </div>
        <a href="categories/create"
           class="btn btn-primary margin_bottom_detail"
           role="button">
            Create a new Category
        </a>

        <a href="/sortByProduct">Sort By Product</a>
        <a href="/sortByCategory">Sort By Category</a>

        <select class="row" name="category_id" id="category_select">
            @foreach ($categories as $category)
                <x-category-item :category="$category" :level="0" />
            @endforeach
        </select>

    </div>

    <!-- Modal -->
{{--    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--        <div class="modal-dialog">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>--}}
{{--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    Are you sure you want to delete this product?--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>--}}
{{--                        <button type="submit" id="confirmDeleteButton" class="btn btn-danger btn-sm">Delete</button>--}}
{{--                    <form action="/products/{{ $product->id }}" method="post" class="mb-0">--}}
{{--                        @csrf--}}
{{--                        @method('delete')--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

@endsection

