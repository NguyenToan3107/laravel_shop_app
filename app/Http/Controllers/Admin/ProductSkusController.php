<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Product_Sku;
use App\Models\Product_Skus_Attribute_Value;
use Illuminate\Http\Request;
use function Sodium\add;

class ProductSkusController extends Controller
{
    public function create($product_id)
    {
        $product = Product::find($product_id);

        $product_attributes = $product->product_attribute_set->attributes;
        return view('admin.products.product_skus.create', [
            'product' => $product,
            'product_attributes' => $product_attributes
        ]);
    }

    public function store(Request $request, $product_id)
    {
        $product = Product::find($product_id);
        $product_attribute = $product->product_attribute_set->attributes;

        $attribute_value = collect();
        foreach ($product_attribute as $attribute) {
            $temp_value = str_replace(' ', '_', $attribute->name);

            $attribute_value->push($request->get($temp_value));
        }

        $request->validate([
            'price' => 'required',
            'price_old' => 'required',
            'percent_sale' => 'required',
            'quantity' => 'required',
        ]);

        $product_sku = Product_Sku::create([
            'product_id' => $product_id,
            'price' => $request->get('price'),
            'price_old' => $request->get('price_old'),
            'percent_sale' => $request->get('percent_sale'),
            'quantity' => $request->get('quantity'),
        ]);

        foreach ($attribute_value as $value) {
            Product_Skus_Attribute_Value::create([
                'sku_id' => $product_sku->id,
                'attribute_value_id' => $value,
            ]);
        }

        return redirect('/admin/products/' . $product_id)->with('success', 'Tạo biến thể sản phẩm thành công');
    }

    public function edit($product_id, $product_sku_id)
    {
        $product = Product::find($product_id);

        $product_sku = Product_Sku::find($product_sku_id);

        $product_attributes = $product->product_attribute_set->attributes;

        return view('admin.products.product_skus.edit', [
            'product' => $product,
            'product_sku' => $product_sku,
            'product_attributes' => $product_attributes
        ]);
    }

    public function update(Request $request, $product_id, $product_sku_id)
    {
        $product = Product::find($product_id);
        $product_attribute = $product->product_attribute_set->attributes;

        $attribute_value = collect();
        foreach ($product_attribute as $attribute) {
            $temp_value = str_replace(' ', '_', $attribute->name);

            $attribute_value->push($request->get($temp_value));
        }

        $request->validate([
            'price' => 'required',
            'price_old' => 'required',
            'percent_sale' => 'required',
            'quantity' => 'required',
        ]);

        $product_sku = Product_Sku::find($product_sku_id);

        $product_sku->update([
            'product_id' => $product_id,
            'price' => $request->get('price'),
            'price_old' => $request->get('price_old'),
            'percent_sale' => $request->get('percent_sale'),
            'quantity' => $request->get('quantity'),
        ]);

        if ($product_sku) {
            foreach ($product_attribute as $attribute) {
                foreach ($product_sku->attributeValues as $attributeValue) {
                    if ($attributeValue->attribute_id == $attribute->id) {
                        $product_skus_attribute = Product_Skus_Attribute_Value::where('sku_id', $product_sku->id)
                            ->where('attribute_value_id', $attributeValue->id)->first();
                        $product_skus_attribute->delete();
                    }
                }
            }

            foreach ($attribute_value as $value) {
                Product_Skus_Attribute_Value::create([
                    'sku_id' => $product_sku->id,
                    'attribute_value_id' => $value,
                ]);
            }
        }

        return redirect('/admin/products/' . $product_id)->with('success', 'Cập nhật thành công');
    }
}
