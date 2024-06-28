<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Product_Attribute_By_SetDataTable;
use App\DataTables\ProductAttributeDataTable;
use App\DataTables\ProductAttributeSetDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Product_Attribute;
use App\Models\Product_Attribute_Set;
use App\Models\Product_Attribute_Set_Attribute;
use App\Models\Product_Sku;
use Illuminate\Http\Request;

class ProductAttributeSetController extends Controller
{
    public function index(ProductAttributeSetDataTable $dataTable) {
        return $dataTable->render('admin.products.product_attribute_sets.index');
    }
    public function store(Request $request) {

        $request->validate([
            'name' => 'required|unique:product_attribute_set,name'
        ]);

        Product_Attribute_Set::create([
            'name' => $request->get('name')
        ]);

        return redirect()->back()->with('success', 'Tạo bộ thuộc tính thành công!');
    }
    public function edit($id, Product_Attribute_By_SetDataTable $dataTable) {
        $product_attribute_set = Product_Attribute_Set::with('attributes')->where('id', $id)->select('name', 'id')->first();

        $product_attributes = Product_Attribute::select('name', 'id')->get();

        $product_attribute_by_sets = $product_attribute_set->attributes->pluck('id')->toArray();


        return $dataTable->with(['product_attribute_set' => $product_attribute_set])
            ->render('admin.products.product_attribute_sets.edit', [
                'product_attribute_set' => $product_attribute_set,
                'product_attributes' => $product_attributes,
                'product_attribute_by_sets' => $product_attribute_by_sets,
        ]);
    }
    public function update($id, Request $request) {
        $product_attribute_set = Product_Attribute_Set::with('attributes')
            ->where('id', $id)->select('name', 'id')
            ->first()
            ->attributes
            ->pluck('id')
            ->toArray();
        $product_attributes = $request->input('name');

        $add_attributes = collect();

        foreach ($product_attributes as $product_attribute) {
            if(!in_array($product_attribute, $product_attribute_set)) {
                $add_attributes->push($product_attribute);
            }
        }

        if(!$add_attributes->isNotEmpty()) {
            return redirect()->back()->with('info', 'Bạn cần thêm thuộc tính!');
        }

        foreach ($add_attributes as $add_attribute) {
            Product_Attribute_Set_Attribute::create([
                'attribute_id' => $add_attribute,
                'attribute_set_id' => $id,
            ]);
        }

        return redirect()->back()->with('success', 'Thêm thuộc tính thành công!');
    }
    public function destroy($id) {

        return redirect()->back()->with('success', 'Thêm thuộc tính thành công!');
    }

    public function deleteAttribute($id_attribute_set, $id_attribute)
    {
        $product = Product_Attribute_Set_Attribute::where('attribute_set_id', $id_attribute_set)
            ->where('attribute_id', $id_attribute)->first();
        if(isset($product)) {
            $product->delete();
        }else {
            return redirect()->back()->with('error', 'Xóa thuộc tính thất bại');
        }
        return redirect()->back()->with('success', 'Xóa thuộc tính thành công');
    }
}
