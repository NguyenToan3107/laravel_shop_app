@extends('layouts.app')

@section('content')
    <div class="container mt-5 d-flex justify-content-center margin_bottom_detail border_detail">
        <div class="border_create w-100">
            <h2 class="text-center mb-4">{{ isset($c) ? 'Update Category' : 'Create Category' }}</h2>

            @if(isset($c))
                {{ Form::open(['route' => ['categories.update', $c->id], 'method' => 'PUT', 'id' => 'formMain']) }}
            @else
                {{ Form::open(['route' => 'categories.store', 'method' => 'POST', 'id' => 'formMain']) }}
            @endif

            <div class="form-group">
                {{ Form::label('parent_id', 'Choose Category Parent') }}
                <select class="form-control row" name="parent_id" id="parent_id">
                    @foreach ($categories as $category)
                        <x-category-item :category="$category" :level="0" />
                    @endforeach
                </select>
            </div>
            <br>
            <div class="form-group">
                {{ Form::label('title', 'Title') }}
                {{ Form::text('title', $c->title ?? '', ['class' => 'form-control', 'id' => 'title', 'required']) }}
            </div>
            <br>

            <div class="form-group">
                {{ Form::textarea('description', isset($c) ? $c->description : '', ['class' => 'form-control textarea', 'cols' => 30, 'rows' => 10]) }}
            </div>

            <div class="text-center">
                {{ Form::button(isset($c) ? 'Update Category' : 'Create Category', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>

            {{ Form::close() }}
        </div>
    </div>
@endsection
