@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card d-flex flex-column h-100">
                    <div class="card-header">
                        <h4>
                            Cập nhật
                            <a href="{{url('permissions')}}" class="btn btn-danger float-end">Quay lại</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{url('permissions/'. $permission->id)}}" method="POST">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="">Tên quyền</label>
                                <input type="text" name="name" class="form-control" value="{{$permission->name}}">
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
