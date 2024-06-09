@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="text-center">Category List</h2>
            </div>
        </div>
        <a href="categories/create"
           class="btn btn-primary margin_bottom_detail"
           role="button">
            Create a new Category
        </a>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
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

