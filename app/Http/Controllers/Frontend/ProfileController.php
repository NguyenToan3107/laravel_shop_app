<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        if(Auth::check()) {
            $user = Auth::user();
        }
        return view('frontend.profiles.index',[
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $messages = [
            'required' => 'Yêu cầu :attribute là bắt buộc',
            'min' => 'Trường :attribute tối thiểu 8 ký tự',
            'confirmed' => 'Yêu cầu xác nhận mật khẩu giống mật khẩu mới'
        ];

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ], $messages);

        if ($validator->fails()) {
//            $errors = $validator->errors()->all();
//            $errorMessage = implode(' ', $errors); // Ghép các lỗi thành chuỗi
//            return redirect()->back()->with('error', $errorMessage)->withInput();
            return redirect()->back()->with('error', 'Dữ liệu không chính xác hoặc bị thiếu');
        }

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return redirect()->back()->with('error', 'Mật khẩu hiện tại nhập không chính xác');
        }

        if ($request->input('current_password') != $request->input('new_password')) {
            Auth::user()->update([
                'password' => Hash::make($request->new_password)
            ]);
        } else {
            return redirect()->back()->with('error', 'Mật khẩu mới không được giống mật khẩu cũ');
        }
        return redirect()->back()->with('success', 'Đổi mật khẩu thành công');
    }
}
