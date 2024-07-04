<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Utils\Util;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) {


        $productsAll = Product::where('status', '<>', 4)
            ->select('id', 'image', 'title', 'price', 'percent_sale', 'category_id')->get();

        if ($request->has('num_product')) {
            $products = Product::where('status', '<>', 4)
                ->select('id', 'image', 'title', 'price', 'percent_sale', 'category_id')
                ->take(Util::num_page + $request->query('num_product'))
                ->get();

            $count_product = count($productsAll) - count($products);
        } else {
            $products = Product::where('status', '<>', 4)
                ->select('id', 'image', 'title', 'price', 'percent_sale', 'category_id')
                ->take(Util::num_page)
                ->get();
            $count_product = count($productsAll) - count($products);
        }

        $category_parent = null;
        if($request->has('category_id')) {

            $category_parent = Category::where('id', $request->query('category_id'))->first();

            $category_brand = Category::where('parent_id', $request->query('category_id'))
                ->select('id', 'title', 'image', 'parent_id')
                ->get();
            $products = Product::where('status', '<>', 4)
                ->select('id', 'image', 'title', 'price', 'percent_sale', 'category_id')
                ->take(Util::num_page)
                ->whereIn('category_id', $category_brand->pluck('id'))
                ->get();


            $count_product = count($productsAll) - count($products);
            if(count($products) == 0) {
                $count_product = 0;
            }
        }
        $category_brand = null;
        if($request->has('category_brand_id')) {
            $category_brand = Category::where('id', $request->query('category_brand_id'))->first();
            $products = Product::where('status', '<>', 4)
                ->select('id', 'image', 'title', 'price', 'percent_sale', 'category_id')
                ->take(Util::num_page)
                ->where('category_id', $request->query('category_brand_id'))
                ->get();

            $count_product = count($productsAll) - count($products);
            if(count($products) == 0) {
                $count_product = 0;
            }
        }

        if($request->session()->get('category_id') !== null) {
            $category_id = $request->session()->get('category_id');
            $category_parent = Category::where('id', $category_id)->first();

            $category_brand = Category::where('parent_id', $category_id)
                ->select('id', 'title', 'image', 'parent_id')
                ->get();
            $products = Product::where('status', '<>', 4)
                ->select('id', 'image', 'title', 'price', 'percent_sale', 'category_id')
                ->take(Util::num_page)
                ->whereIn('category_id', $category_brand->pluck('id'))
                ->get();

            $count_product = count($productsAll) - count($products);
            if(count($products) == 0) {
                $count_product = 0;
            }
            $request->session()->forget('category_id');
        }

        $categories = Category::whereNull('parent_id')->select('id', 'title', 'image', 'parent_id')->get();

        return view('frontend.products.index', [
            'products' => $products,
            'categories' => $categories,
            'count_product' => $count_product,
            'category_parent' => $category_parent,
            'category_brand' => $category_brand
        ]);
    }
}
