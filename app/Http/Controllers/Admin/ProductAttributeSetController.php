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
use App\Models\Product_Skus_Attribute_Value;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductAttributeSetController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $model =  Product_Attribute_Set::select('id', 'name');

            return DataTables::of($model)
                ->addColumn('action', function ($product_attribute_set) {
                    return view('admin.products.product_attribute_sets.action',
                        ['product_attribute_set' => $product_attribute_set]);
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" name="ids_product_attribute_set" class="checkbox_ids_product_attribute_set" value="' . $row->id . '"/>';
                })
                ->rawColumns(['action', 'checkbox'])
                ->setRowId('id')
                ->make(true);
        }

        return view('admin.products.product_attribute_sets.index');
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

    public function edit($id, Request $request) {
        $product_attribute_set = Product_Attribute_Set::with('attributes')
            ->where('id', $id)
            ->select('name', 'id')->first();

        $product_attributes = Product_Attribute::select('name', 'id')->get();

        $product_attribute_by_sets = $product_attribute_set->attributes->pluck('id')->toArray();

        if($request->ajax()) {
            $model = Product_Attribute::select(['product_attribute.id', 'product_attribute.name'])
                ->join('product_attribute_set_attribute', 'product_attribute.id', '=', 'product_attribute_set_attribute.attribute_id')
                ->where('product_attribute_set_attribute.attribute_set_id', $product_attribute_set->id);

            return DataTables::of($model)
                ->addColumn('action', function ($product_attribute) use ($id) {
                    $product_attribute_set = Product_Attribute_Set::where('id', $id)
                        ->select('id', 'name')->first();

                    return view('admin.products.product_attribute_sets.action_attribute', [
                        'product_attribute' => $product_attribute,
                        'product_attribute_set' => $product_attribute_set,
                    ]);
                })
                ->addColumn('value', function ($product_attribute) {
                    $attributes = $product_attribute->attributeValues->map(function ($attribute_value) {
                        return '<lable class="badge text-bg-primary mx-1">' . $attribute_value->value . '</lable>';
                    })->implode(' ');

                    return '<td>' . $attributes . '</td>';
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" name="ids_product_attribute_set" class="checkbox_ids_product_attribute_set" value="' . $row->id . '"/>';
                })
                ->rawColumns(['action', 'value', 'checkbox'])
                ->setRowId('id')
                ->make(true);
        }

        return view('admin.products.product_attribute_sets.edit', [
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
        $product_set_attribute = Product_Attribute_Set_Attribute::where('attribute_set_id', $id_attribute_set)
            ->where('attribute_id', $id_attribute)->first();

        $products = Product::where('product_attribute_set_id', $id_attribute_set)->get();

        foreach ($products as $product) {
            $product_skus = $product->skus;
            foreach ($product_skus as $product_sku) {
                $product_skus_attributes = $product_sku->attributeValues->where('attribute_id', $id_attribute);
                foreach ($product_skus_attributes as $product_sku_attribute) {
                    $product_sku_attribute_value = Product_Skus_Attribute_Value::where('attribute_value_id', $product_sku_attribute->id)->first();
                    $product_sku_attribute_value->delete();
                }
            }
        }

        if(isset($product_set_attribute)) {
            $product_set_attribute->delete();
        }else {
            return redirect()->back()->with('error', 'Xóa thuộc tính thất bại');
        }
        return redirect()->back()->with('success', 'Xóa thuộc tính thành công');
    }
}
