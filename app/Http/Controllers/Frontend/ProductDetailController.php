<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Attribute;
use App\Models\Product_Attribute_Value;
use App\Models\Product_Image;
use App\Models\Product_Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductDetailController extends Controller
{
    public function index($id, Request $request)
    {
        $product = Product::where('id', $id)
            ->select('id', 'image', 'title', 'price', 'percent_sale', 'category_id')->first();

        $product_images = $product->product_images;
        // involve product
        $involve_products = Product::where('category_id', $product->category_id)
            ->limit(10)
            ->where('id', '!=', $product->id)
            ->select('id', 'image', 'title', 'price', 'percent_sale')
            ->get();

        $product_sku_first_price = $product->skus->first();
        $product_skus = $product->skus;

//        foreach ($product_skus as $product_sku) {
//            $product_attributes = $product_sku->attributeValues;
//            $attribute = $product_attributes->map(function ($attributeName) {
//                return '<label class="badge bg-primary mx-1">' . $attributeName->value . '</label>';
//            })->implode(' ');
////            dd($attribute);
//        }

        return view('frontend.product_detail.index',
            [
                'product' => $product,
                'product_images' => $product_images,
                'involve_products' => $involve_products,
                'product_skus' => $product_skus,
                'product_sku_first_price' => $product_sku_first_price
            ]);
    }
}
