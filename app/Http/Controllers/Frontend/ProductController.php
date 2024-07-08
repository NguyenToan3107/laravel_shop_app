<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Utils\Util;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, $slug = null, $category = null)
    {
        $category_parent = null;
        $category_brand = null;
        if ($slug == null) {
            $productsAll = Product::query()
                ->where('status', '<>', 4)
                ->select('id', 'image', 'title', 'price', 'percent_sale', 'category_id', 'price_old', 'slug');
            $products = Product::query()
                ->select('id', 'image', 'title', 'price', 'percent_sale', 'category_id', 'price_old', 'slug')
                ->where('status', '<>', 4);

            ///////////////////////////////
            // sử lý xem them sản phẩm
            if ($request->has('num_product')) {
                $products = $products->take(Util::num_page + $request->query('num_product'));
            } else {
                $products = $products->take(Util::num_page);
            }
            //////////////////////////////
            $products = $products->get();
            $productsAll = $productsAll->get();
            $count_product = count($productsAll) - count($products);

        } else {
            $productsAll = Product::query()
                ->where('status', '<>', 4)
                ->select('id', 'image', 'title', 'price', 'percent_sale', 'category_id', 'price_old', 'slug');
            $products = Product::query()
                ->select('id', 'image', 'title', 'price', 'percent_sale', 'category_id', 'price_old', 'slug')
                ->where('status', '<>', 4);

            $category_parent = Category::where('slug', $slug)->first();
            if ($category_parent->parent_id == null) {
                $brand = Category::where('parent_id', $category_parent->id)
                    ->select('id', 'title', 'image', 'parent_id', 'slug')
                    ->get();
                $products = $products
                    ->take(Util::num_page)
                    ->whereIn('category_id', $brand->pluck('id'));
                $productsAll = $productsAll->whereIn('category_id', $brand->pluck('id'));
            } else {
                $products = $products
                    ->take(Util::num_page)
                    ->where('category_id', $category_parent->id);

                $productsAll = $productsAll->where('category_id', $category_parent->id);
            }
            ///////////////////////////////
            // sử lý xem them sản phẩm
            if ($request->has('num_product')) {
                $products = $products->take(Util::num_page + $request->query('num_product'));
            } else {
                $products = $products->take(Util::num_page);
            }
            //////////////////////////////

            $products = $products->get();
            $productsAll = $productsAll->get();
            $count_product = count($productsAll) - count($products);
        }

        if (count($products) == 0) $count_product = 0;

        $categories = Category::whereNull('parent_id')->select('id', 'title', 'image', 'parent_id', 'slug')->get();

        return view('frontend.products.index', [
            'products' => $products,
            'categories' => $categories,
            'count_product' => $count_product,
            'category_brand' => $category_brand,
            'category_parent' => $category_parent
        ]);
    }
}
