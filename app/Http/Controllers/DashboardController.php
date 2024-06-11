<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $count_users = User::count();
        $count_posts = Post::count();
        $count_products = Product::count();
        $count_categories = Category::count();
        return view('layouts.dashboard',[
            'count_users' => $count_users,
            'count_posts' => $count_posts,
            'count_products' => $count_products,
            'count_categories' => $count_categories
        ]);
    }
}
