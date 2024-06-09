@extends('layouts.app')

@section('content')
    <div class="container mt-5 d-flex justify-content-center margin_bottom_detail border_detail">
        <div class="border_create w-100">
            <h2 class="text-center mb-4">Update User</h2>
            <form action="/users/{{$user->id}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" value="{{$user->email}}" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phoneNumber">Phone Number</label>
                    <input type="text" class="form-control" id="phoneNumber" value="{{$user->phoneNumber}}" name="phoneNumber" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" value="{{$user->address}}" name="address" required>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" class="form-control" id="age" value="{{$user->age}}" name="age" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" value="{{$user->password}}" name="password" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-select" name="role">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <br>
                <div class="form-group" style="display: flex; flex-direction: row; gap: 150px; align-items: center">
                    <div>
                        <label for="name">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <img src="{{asset('images/users/' . $user->image_path)}}" id="imageDisplay" class="img-thumbnail user-image-detail-80" alt="Avatar">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
@endsection
