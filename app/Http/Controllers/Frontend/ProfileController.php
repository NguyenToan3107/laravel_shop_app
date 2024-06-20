<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
}
