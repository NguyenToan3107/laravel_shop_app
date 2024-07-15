<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product_Attribute_Value;
use Illuminate\Http\Request;

class ProductAttributeValueController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-attribute')->only('store');
        $this->middleware('permission:delete-attribute')->only('destroy');
    }

    public function store($id_attribute, Request $request) {
        $request->validate([
            'value' => 'required'
        ]);
        try {
            Product_Attribute_Value::create([
                'attribute_id' => $id_attribute,
                'value' => $request->get('value')
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Thêm giá trị thất bại');
        }

        return redirect()->back()->with('success', 'Thêm giá trị thành công');
    }

    public function destroy($id_attribute, $id) {
        $product_attribute_value = Product_Attribute_Value::where('id', $id)
            ->where('attribute_id', $id_attribute)
            ->firstOrFail();
        if($product_attribute_value) {
            $product_attribute_value->delete();
        }
    }
}

