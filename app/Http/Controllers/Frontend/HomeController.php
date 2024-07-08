<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request) {

        $products_new_arivals = Product::take(5)->orderBy('created_at', 'desc')
            ->select('id', 'image', 'title', 'price', 'percent_sale', 'category_id', 'price_old', 'slug')
            ->get();

        $products_top_rated = Product::take(5)->orderBy('total_order', 'desc')->get();

        $product_trending = Product::take(5)->inRandomOrder()->get();

        if ($request->has('titlesearch')) {
            $items = Product::search($request->titlesearch)
                ->paginate(6)->items();
        } else {
            $items = Product::take(6)->get();
        }

        if ($request->has('load_more')) {
            $items = Product::take(12)->get();
        }

        $categories = Category::whereNull('parent_id')->get();
        return view('frontend.welcome', [
            'categories' => $categories,
            'items' => $items,
            'products_new_arivals' => $products_new_arivals,
            'products_top_rated' => $products_top_rated,
            'product_trending' => $product_trending
        ]);
    }
}
