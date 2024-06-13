<?php

namespace App\Http\Controllers;

use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\UserService;

class UserController extends Controller
{
    const USERS_PATH = '/users';

    public function __construct(protected UserService $userService)
    {
    }
    public function index() {
        $users = $this->userService->getAll();

//        $string = 'Lợi ích của việc học';
//        $string = str_replace(Util::VietnameseCharacters, Util::AsciiCharacters, $string);
//        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
//
        return view('users.index', [
            'users' => $users
        ]);
    }

    public function create() {
        return view('users.create');
    }
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:users|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'age' => 'required|integer|min:0|max:100',
            'address' => 'required',
            'phoneNumber' => 'required'
//            'image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ]);

        if(isset(request()->image)) {
            $generatedImageName = 'image'.time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images/users'), $generatedImageName);
        }else {
            $generatedImageName = 'default_user.jpg';
        }

        $this->userService->createUser([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'age' => $request->input('age'),
            'address' => $request->input('address'),
            'phoneNumber' => $request->input('phoneNumber'),
            'image_path' => $generatedImageName,
            'role' => strtolower($request->input('role')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect(UserController::USERS_PATH);
    }
    public function show($id) {
        $user = $this->userService->getById($id);
        return view('users.show', [
            'user' => $user
        ]);
    }
    public function edit($id) {
        $user = $this->userService->getById($id);
        return view('users.edit', [
            'user' => $user
        ]);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'email' => 'email',
//            'image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ]);

        if(isset(request()->image)) {
            $generatedImageName = 'image'.time().'-'.$request->name.'.'.$request->image->extension();
            request()->image->move(public_path('images/users'), $generatedImageName);
        }else {
            $generatedImageName = 'default_user.jpg';
        }

        $this->userService->updateUser($id, [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'age' => $request->input('age'),
            'address' => $request->input('address'),
            'phoneNumber' => $request->input('phoneNumber'),
            'image_path' => $generatedImageName,
            'role' => strtolower($request->input('role')),
            'updated_at' => now()
        ]);

        return redirect(UserController::USERS_PATH);
    }
    public function destroy($id) {
        $this->userService->delete($id);
        return redirect(UserController::USERS_PATH);
    }
}
