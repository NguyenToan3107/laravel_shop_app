<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;

class HomeController extends Controller
{
    public function index() {
//        $categories = Category::with('children')->where('parent_id', '<>', null)->get();
        $categories = Category::whereNull('parent_id')->get();
        return view('frontend.welcome', [
            'categories' => $categories
        ]);
    }
}
