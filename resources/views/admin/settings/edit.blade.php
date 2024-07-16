@extends('admin.layouts.app')

@section('title', ucwords($setting->key))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card d-flex flex-column h-100">
                    <div class="card-header">
                        <h4>
                            Cập nhật
                            <a href="/admin/settings" class="btn btn-danger float-end">Quay lại</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="/admin/settings/{{$setting->id}}" method="POST">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="">Key:</label>
                                <input type="text" name="key" class="form-control" value="{{$setting->key}}">
                                <br>
                                <label for="">Value:</label>
                                <input type="text" name="value" class="form-control" value="{{$setting->value}}">
                                <br>
                                <label for="description">Trạng thái:</label>
                                <select name="status" class="form-select">
                                    @if(isset($setting))
                                        <option class="selected" value="{{$setting->status}}">Hiện tại: {{$setting->status == 1 ? 'Active' : 'Inactive'}}</option>
                                    @endif
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                                <br>
                                <label for="description">Mô tả:</label>
                                <textarea name="description" id="description" class="textarea" cols="30" rows="10">
                                    {{$setting->description}}
                                </textarea>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
