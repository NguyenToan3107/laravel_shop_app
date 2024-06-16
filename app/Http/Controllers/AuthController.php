<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\text;

class AuthController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth:api', ['except' => ['login']]);
//    }
//    /**
//     * Get a JWT via given credentials.
//     *
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function login(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'email' => 'required|email',
//            'password' => 'required|string|min:5',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json($validator->errors(), 422);
//        }
//
////        if (! $token = auth('api')->attempt($credentials)) {
////            return response()->json(['error' => 'Unauthorized'], 401);
////        }
//        $user = User::where('email', request('email'))->first();
//        if(!$user) {
//            return response()->json(['error' => 'Unauthorized'], 401);
//        }
//
//        $token = auth()->login($user);
//
//        return $this->respondWithToken($token);
//    }
//
//    public function profile()
//    {
//        return response()->json(auth()->user());
//    }
//
//    public function logout()
//    {
//        auth()->logout();
//        return response()->json(['message' => 'Successfully logged out']);
//    }
//
//    public function register(Request $request)
//    {
//        $validatedData = $request->validate([
//            'name' => 'required|string|max:255',
//            'email' => 'required|string|email|max:255|unique:users',
//            'password' => 'required|string|min:8|confirmed',
//        ]);
//
//        $user = User::create([
//            'name' => $validatedData['name'],
//            'email' => $validatedData['email'],
//            'password' => Hash::make($request->password), // Mã hóa mật khẩu
//        ]);
//
//        $token = auth()->login($user);
//
//        return response()->json(['token' => $token], 201);
//    }
//    /**
//     * Get the token array structure.
//     *
//     * @param  string $token
//     *
//     * @return \Illuminate\Http\JsonResponse
//     */
//    protected function respondWithToken($token)
//    {
//        return response()->json([
//            'access_token' => $token,
//            'token_type' => 'bearer',
//            'expires_in' => auth('api')->factory()->getTTL() * 60,
////            'user' => auth()->user()
//        ]);
//    }
//    public function loginInterface() {
//        return view('auth.login');
//    }
//
//    public function access(Request $request) {
//        $request->validate([
//            'name' => 'required',
//            'password' => 'required|string',
//        ]);
//
//        $user = $this->userService->getByUsername($request->get('name'));
//
//        $password = $request->get('password');
//
//        if (Hash::check($password, $user->password)) {
//            return redirect('/users');
//        }
//        return back()->withErrors([]);
//    }
//
//    public function register(Request $request) {
//        return view('auth.register');
//    }
//
//    public function store(Request $request) {
//        $request->validate([
//            'name' => 'required|unique:users|max:255',
//            'email' => 'required|email',
//            'password' => 'required',
//            'age' => 'required|integer|min:0|max:100',
//            'address' => 'required',
//            'phoneNumber' => 'required',
////            'image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
//        ]);
//
//        if(isset(request()->image)) {
//            $generatedImageName = 'image'.time().'.'.request()->image->getClientOriginalExtension();
//            request()->image->move(public_path('images/users'), $generatedImageName);
//        }else {
//            $generatedImageName = 'default_user.jpg';
//        }
//
//        $this->userService->createUser([
//            'name' => $request->input('name'),
//            'email' => $request->input('email'),
//            'password' => bcrypt($request->input('password')),
//            'age' => $request->input('age'),
//            'address' => $request->input('address'),
//            'phoneNumber' => $request->input('phoneNumber'),
//            'image_path' => $generatedImageName,
//            'role' => strtolower($request->input('role')),
//        ]);
//        return redirect('/users');
//    }
}
