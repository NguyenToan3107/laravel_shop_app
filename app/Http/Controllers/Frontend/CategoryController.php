<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($slug = null) {
        $category_parents = Category::whereNull('parent_id')->select('id', 'title', 'image', 'slug')->get();


        if (!is_null($slug)) {
            $category_parent = Category::where('slug', $slug)->select('id', 'title', 'image', 'slug')->first();
            $category_children = $category_parent->children;
        }else {
            $category_parent = Category::where('slug', 'dien-thoai')->select('id', 'title', 'image', 'slug')->first();
            $category_children = $category_parent->children;
        }

        $category_pluck_id = $category_children->pluck('id');
        $products_hots = Product::whereIn('category_id', $category_pluck_id)->take(5)->inRandomOrder()->get();


        return view('frontend.categories.index', [
            'category_parents' => $category_parents,
            'category_children' => $category_children,
            'products_hots' => $products_hots,
        ]);
    }
}
