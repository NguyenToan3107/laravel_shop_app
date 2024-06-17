<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index() {
        $count_users = User::count();
        $count_posts = Post::count();
        $count_products = Product::count();
        $count_categories = Category::count();
        return view('admin.dashboard',[
            'count_users' => $count_users,
            'count_posts' => $count_posts,
            'count_products' => $count_products,
            'count_categories' => $count_categories
        ]);
    }
}
