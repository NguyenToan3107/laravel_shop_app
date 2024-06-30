@extends('admin.layouts.app')

@section('content')
    <form>
        <div class="form-group">
            <label for=""></label>
            <select class="row form-control" name="author_id" id="author_id" style="margin-left: 0">
{{--                @foreach ($users as $user)--}}
{{--                    @can('create-post')--}}
{{--                        <option value="{{$user->id}}">Tên: {{$user->name}}</option>--}}
{{--                    @endcan--}}
{{--                @endforeach--}}
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Tạo mới</button>
    </form>
@endsection


