<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Attribute;
use App\Models\Product_Attribute_Value;
use App\Models\Product_Image;
use App\Models\Product_Sku;
use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductDetailController extends Controller
{
    public function index($slug, Request $request)
    {
        $product = Product::where('slug', $slug)
            ->select('id', 'image', 'title', 'price', 'percent_sale', 'category_id', 'slug', 'price_old', 'description', 'content', 'product_attribute_set_id')->first();

        $product_images = $product->product_images;

        $all_involve_products = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->select('id', 'image', 'title', 'price', 'percent_sale')
            ->get();

        if ($request->has('num_product')) {
            $involve_products = Product::where('category_id', $product->category_id)
                ->limit(Util::num_page_product_detail)
                ->where('id', '!=', $product->id)
                ->select('id', 'image', 'title', 'price', 'percent_sale', 'slug', 'price_old')
                ->take(Util::num_page_product_detail + $request->query('num_product'))
                ->get();

            $count_product = count($all_involve_products) - count($involve_products);
        }else {
            $involve_products = Product::where('category_id', $product->category_id)
                ->limit(Util::num_page_product_detail)
                ->where('id', '!=', $product->id)
                ->select('id', 'image', 'title', 'price', 'percent_sale', 'slug', 'price_old')
                ->take(Util::num_page_product_detail)
                ->get();

            $count_product = count($all_involve_products) - count($involve_products);
        }

        $product_sku_first_price = $product->skus->first();
        $product_skus = $product->skus;

        $product_attributes = $product->product_attribute_set->attributes;
        return view('frontend.product_detail.index',
            [
                'product' => $product,
                'product_images' => $product_images,
                'involve_products' => $involve_products,
                'product_skus' => $product_skus,
                'product_sku_first_price' => $product_sku_first_price,
                'count_product' => $count_product,
                'product_attributes' => $product_attributes
            ]);
    }
}
