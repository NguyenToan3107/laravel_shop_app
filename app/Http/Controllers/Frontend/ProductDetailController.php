<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Attribute;
use App\Models\Product_Image;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function index($id, Request $request)
    {
        $product = Product::where('id', $id)->select('id', 'image', 'title', 'price', 'percent_sale', 'category_id')->first();
        $product_images = $product->product_images;

        $product_attributes = $product->product_attributes;
        if($request->has(['capacity', 'color'])) {
            $product_attribute_first = Product_Attribute::where('capacity', $request->query('capacity'))
                ->where('color', $request->query('color'))
                ->first();

            $capacities = Product_Attribute::where('product_id', $product->id)->distinct('capacity')->pluck('capacity');
            $colors = Product_Attribute::where('product_id', $product->id)
                ->where('capacity', $request->query('capacity'))
                ->distinct('color')->pluck('color');
        }else {
            // load first
            $product_attribute_first = $product_attributes[0];
            $capacities = Product_Attribute::where('product_id', $product->id)->distinct('capacity')->pluck('capacity');
            $colors = Product_Attribute::where('product_id', $product->id)
                ->where('capacity', 256)
                ->distinct('color')->pluck('color');
        }



        // involve product
        $involve_products = Product::where('category_id', $product->category_id)
            ->limit(10)
            ->where('id', '!=', $product->id)
            ->select('id', 'image', 'title', 'price', 'percent_sale')
            ->get();

        return view('frontend.product_detail.index',
            [
                'product' => $product,
                'product_images' => $product_images,
                'involve_products' => $involve_products,
                'product_attributes' => $product_attributes,
                'capacities' => $capacities,
                'colors' => $colors,
                'product_attribute_first' => $product_attribute_first
            ]);
    }

    public function chooseCapacity(Request $request) {
        echo $request->query('capacity');
    }
}
