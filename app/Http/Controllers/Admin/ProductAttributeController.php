<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product_Attribute;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductAttributeController extends Controller
{
    public function __construct() {
        $this->middleware('permission:create-attribute')->only('store', 'create');
        $this->middleware('permission:edit-attribute')->only('update', 'edit');
        $this->middleware('permission:delete-attribute')->only('destroy');
        $this->middleware('permission:view-attribute')->only('index');
    }
    public function index(Request $request) {
        if($request->ajax()) {
            $model = Product_Attribute::query()
                ->select('id', 'name');

            return DataTables::of($model)
                ->addColumn('action', function ($product_attribute) {
                    return view('admin.products.product_attributes.action', [
                        'product_attribute' => $product_attribute,
                    ]);
                })
                ->addColumn('value', function ($product_attribute) {
                    $attributes = $product_attribute->attributeValues->map(function ($attribute_value) {
                        return '<lable class="badge text-bg-primary mx-1">' . $attribute_value->value . '</lable>';
                    })->implode('');
                    return '<td>' . $attributes . '</td>';
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" name="ids_product_attribute" class="checkbox_ids_product_attributes" value="' . $row->id . '"/>';
                })
                ->rawColumns(['action', 'value', 'checkbox'])
                ->setRowId('id')
                ->make(true);
        }
        return view('admin.products.product_attributes.index');
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
}
