<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\text;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService, protected UserService $userService)
    {
    }

    public function login() {
        return view('auth.login');
    }

    public function access(Request $request) {
        $request->validate([
            'name' => 'required',
            'password' => 'required|string',
        ]);

        $user = $this->userService->getByUsername($request->get('name'));

        $password = $request->get('password');

        if (Hash::check($password, $user->password)) {
            return redirect('/users');
        }
        return back()->withErrors([]);
    }

    public function register(Request $request) {
        return view('auth.register');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:users|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'age' => 'required|integer|min:0|max:100',
            'address' => 'required',
            'phoneNumber' => 'required',
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
        ]);
        return redirect('/users');
    }
}
