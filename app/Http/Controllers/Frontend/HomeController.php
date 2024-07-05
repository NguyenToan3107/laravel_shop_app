<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
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
        ]);
    }
}
