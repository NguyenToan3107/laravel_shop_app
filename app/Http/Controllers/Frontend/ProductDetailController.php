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
        $product = Product::with('skus.attributeValues.attribute')->where('id', $id)
            ->select('id', 'image', 'title', 'price', 'percent_sale', 'category_id')->first();

        if ($product) {
            $capacities = collect();
            $colors = collect();

            foreach ($product->skus as $sku) {
                foreach ($sku->attributeValues as $attributeValue) {
                    if ($attributeValue->attribute->name === 'capacity') {
                        $capacities->push($attributeValue);
                    }

                    if ($attributeValue->attribute->name === 'color') {
                        $colors->push($attributeValue);
                    }
                }
            }
        }

        if ($request->filled(['color', 'capacity'])) {
            DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

            $color_value = $request->query('color');
            $capacity_value = $request->query('capacity');

            // Lấy id của thuộc tính Capacity và Color từ bảng ProductAttribute
            $capacity = Product_Attribute::where('name', 'capacity')->first()->id;
            $color = Product_Attribute::where('name', 'color')->first()->id;

            // Lấy id của giá trị Attribute Value cho Capacity và Color
            $valueCapacity = Product_Attribute_Value::where('attribute_id', $capacity)
                ->where('value', $capacity_value)->first()->value;

            $valueColor = Product_Attribute_Value::where('attribute_id', $color)
                ->where('value', $color_value)->first()->value;

            $sku_first = Product_Sku::select('product_skus.*')
                ->join('product_skus_attribute_value as psav', 'psav.sku_id', '=', 'product_skus.id')
                ->join('product_attribute_value as pav', 'pav.id', '=', 'psav.attribute_value_id')
                ->where('product_skus.product_id', $id)
                ->where(function ($query) use ($capacity, $color, $valueCapacity, $valueColor) {
                    $query->where(function ($query) use ($color, $valueColor) {
                        $query->where('pav.attribute_id', $color)
                            ->where('pav.value', $valueColor);
                    })->orWhere(function ($query) use ($capacity, $valueCapacity) {
                        $query->where('pav.attribute_id', $capacity)
                            ->where('pav.value', $valueCapacity);
                    });
                })
                ->groupBy('product_skus.id')
                ->havingRaw('COUNT(DISTINCT pav.attribute_id) = 2')
                ->first();

        } else {
            $sku_first = $product->skus->first();
        }

        $capacities = $capacities->unique('value');
        $colors = $colors->unique('value');

        $product_images = $product->product_images;
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
                'capacities' => $capacities,
                'colors' => $colors,
                'sku_first' => $sku_first
            ]);
    }
}
