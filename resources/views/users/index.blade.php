@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="text-center">User List</h2>
            </div>
        </div>
        <a href="users/create"
           class="btn btn-primary margin_bottom_detail"
           role="button">
            Create a new User
        </a>
        <div class="row">
            <div class="col-md-12">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Role</th>
                        <th>Age</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody id="userTable">
                    @foreach($users as $user)
                        <tr>
                            <td><a href="/users/{{$user->id}}">{{$user->id}}</a></td>
                            <td><img  src="{{asset('images/users/' . $user->image_path)}}" class="img-thumbnail rounded-circle user-image" alt=""></td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phoneNumber}}</td>
                            <td>{{$user->address}}</td>
                            <td>{{ucfirst($user->role)}}</td>
                            <td>{{$user->age}}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="/users/{{$user->id}}/edit" class="btn btn-primary btn-sm mr-2">Edit</a>
                                    <form action="/users/{{ $user->id }}" method="post" class="mb-0">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
