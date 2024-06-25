<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        $categories = Category::whereNull('parent_id')->get();
        return view('frontend.products.index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
}
