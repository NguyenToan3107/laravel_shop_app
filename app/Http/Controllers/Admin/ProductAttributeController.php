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
        return redirect()->back()->with('success', 'Product Attribute Set created!');
    }

    public function edit($id) {
        return view('admin.products.product_attributes.edit');
    }

    public function update($id) {}
    public function destroy($id) {}

}
