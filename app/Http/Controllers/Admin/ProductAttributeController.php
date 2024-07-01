<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductAttributeDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product_Attribute;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    public function index(ProductAttributeDataTable $dataTable) {
        return $dataTable->render('admin.products.product_attributes.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:product_attribute,name'
        ]);
        Product_Attribute::create([
            'name' => $request->get('name')
        ]);
        return redirect()->back()->with('success', 'Tạo thuộc tính thành công');
    }

    public function edit($id) {
        $product_attribute = Product_Attribute::where('id', $id)->select('id', 'name')->first();

        $product_attribute_values = $product_attribute->attributeValues;

        return view('admin.products.product_attributes.edit',
            compact('product_attribute', 'product_attribute_values'));
    }

    public function update($id, Request $request) {
        $request->validate([
            'value' => 'required|unique:product_attribute_value,value'
        ]);
    }
    public function destroy($id) {}

}
