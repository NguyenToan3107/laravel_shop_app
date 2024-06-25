<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Product_Image;

class ProductDetailController extends Controller
{
    public function index($id) {
        $product = Product::find($id)->select('id', 'image', 'title', 'price', 'percent_sale', 'category_id')->first();
        $product_images = Product_Image::where('product_id', $product->id)->select('id', 'product_id', 'image_url')->get();

        $involve_products = Product::where('category_id', $product->category_id)
            ->limit(10)
            ->select('id', 'image', 'title', 'price', 'percent_sale')
            ->get();

        return view('frontend.product_detail.index',
            ['product' => $product, 'product_images' => $product_images, 'involve_products' => $involve_products]);
    }
}
