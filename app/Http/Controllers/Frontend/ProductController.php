<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        $products = Product::where('status', '<>', 4)->select('id', 'image', 'title', 'price', 'percent_sale', 'category_id')->get();
        $categories = Category::whereNull('parent_id')->select('id', 'title', 'image', 'parent_id')->get();
        return view('frontend.products.index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
}
