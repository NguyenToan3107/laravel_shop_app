@extends('layouts.app')

@section('content')
    <div class="container mt-5 d-flex justify-content-center margin_bottom_detail border_detail">
        <div class="border_create w-100">
            <h2 class="text-center mb-4">Create Category</h2>
            <form action="/categories" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    {{ Form::label('parent_id', 'Choose Category Parent') }}
                    <select class="row" name="parent_id" id="parent_id">
                        @foreach ($categories as $category)
                            <x-category-item :category="$category" :level="0" />
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div>
                    <br>
                    <textarea name="description" class="form-control textarea" id="" cols="30" rows="10"></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
            </form>
        </div>
    </div>
@endsection

