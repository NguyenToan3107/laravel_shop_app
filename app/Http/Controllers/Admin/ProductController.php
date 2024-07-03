<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductsDataTable;
use App\DataTables\ProductSkusDataTable;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Attribute_Set;
use App\Models\Product_Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    const PRODUCTS_PATH = '/admin/products';

    public function __construct()
    {
        $this->middleware('permission:create-product')->only('store', 'create');
        $this->middleware('permission:edit-product')->only('update', 'edit');
        $this->middleware('permission:delete-product')->only('destroy', 'softDelete', 'trashProduct');
        $this->middleware('permission:view-product')->only('index');
    }

    public function index(ProductsDataTable $dataTable) {

        $categories = Category::with('children')->whereNull('parent_id')->get();
        return $dataTable->render('admin.products.index', [
            'categories' => $categories
        ]);
    }

    public function show($id, ProductSkusDataTable $dataTable)
    {
        $product = Product::find($id);
        $product_attributes = $product->product_attribute_set->attributes;
        $category = $product->categories()->where('id', $product->category_id)->first();
        return $dataTable->with(['product' => $product])->render('admin.products.show', [
            'product' => $product,
            'category' => $category,
            'product_attributes' => $product_attributes
        ]);
    }

    public function create()
    {
        $product_attribute_sets = Product_Attribute_Set::select('id', 'name')->get();
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $products = Product::all();
        return view('admin.products.create_edit_product',
            ['categories' => $categories, 'products' => $products, 'product_attribute_sets' => $product_attribute_sets]);
    }

    public function store(Request $request)
    {
        $description = $request->input('description');
        $description = substr($description, 3, strlen($description) - 7);
        $request->validate([
//            'product_image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
            'title' => 'required|unique:products',
        ]);
        if($request->filled('filepath')) {
            $image_path = $request->input('filepath');
            $image_path = explode('http://localhost:8000', $image_path)[1];
        }else {
            $image_path = '/storage/photos/products/empty-photo.jpg';
        }


        if($request->filled('filepath_1')) {
            $image_path_1 = $request->input('filepath_1');
            $image_path_1 = explode('http://localhost:8000', $image_path_1)[1];
        }else {
            $image_path_1 = '/storage/photos/products/empty-photo.jpg';
        }
        if($request->filled('filepath_2')) {
            $image_path_2 = $request->input('filepath_2');
            $image_path_2 = explode('http://localhost:8000', $image_path_2)[1];
        }else {
            $image_path_2 = '/storage/photos/products/empty-photo.jpg';
        }
        if($request->filled('filepath_3')) {
            $image_path_3 = $request->input('filepath_3');
            $image_path_3 = explode('http://localhost:8000', $image_path_3)[1];
        }else {
            $image_path_3 = '/storage/photos/products/empty-photo.jpg';
        }

        $product = Product::create([
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'percent_sale' => $request->percent_sale,
            'description' => $description,
            'image' => $image_path,
            'category_id' => $request->category_id,
            'status' => 1,
            'product_attribute_set_id' => $request->input('product_attribute_set_id'),
        ]);

        $image_paths = [$image_path_1, $image_path_2, $image_path_3];

        foreach ($image_paths as $image_path) {
            Product_Image::create([
                'product_id' => $product->id,
                'image_url' => $image_path,
            ]);
        }


        return redirect(ProductController::PRODUCTS_PATH);
    }

    public function edit($id)
    {
        $product_attribute_sets = Product_Attribute_Set::select('id', 'name')->get();
        $product = Product::find($id);

        $product_attribute_set = $product->product_attribute_set;

        $category = Category::find($product->category_id);
        $categories = Category::with('children')->whereNull('parent_id')->get();

        $product_image = Product_Image::where('product_id', $product->id)->get();

        $product_image_1 = $product_image[0];
        $product_image_2 = $product_image[1];
        $product_image_3 = $product_image[2];


        return view('admin.products.create_edit_product',
            ['product' => $product,
                'categories' => $categories,
                'c' => $category,
//                'product_image' => $product_image,
                'product_image_1' => $product_image_1,
                'product_image_2' => $product_image_2,
                'product_image_3' => $product_image_3,
                'product_attribute_sets' => $product_attribute_sets,
                'product_attribute_set' => $product_attribute_set,
            ]);
    }

    public function update(Request $request, $id)
    {
        $description = $request->input('description');
        $description = substr($description, 3, strlen($description) - 7);

        $product = Product::find($id);

        if($request->filled('filepath')) {
            $image_path = $request->input('filepath');
            $image_path = explode('http://localhost:8000', $image_path)[1];
        }else {
            $image_path = $product->image;
        }

        // sub image
        if($request->filled('filepath_1')) {
            $image_path_1 = $request->input('filepath_1');
            $image_path_1 = explode('http://localhost:8000', $image_path_1)[1];
        }else {
            $image_path_1 = $product->image;
        }
        if($request->filled('filepath_2')) {
            $image_path_2 = $request->input('filepath_2');
            $image_path_2 = explode('http://localhost:8000', $image_path_2)[1];
        }else {
            $image_path_2 = $product->image;
        }
        if($request->filled('filepath_3')) {
            $image_path_3 = $request->input('filepath_3');
            $image_path_3 = explode('http://localhost:8000', $image_path_3)[1];
        }else {
            $image_path_3 = $product->image;
        }

        $product->update([
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'percent_sale' => $request->percent_sale,
            'description' => $description,
            'image' => $image_path,
            'category_id' => $request->category_id,
            'status' => $request->input('status'),
            'deleted_at' => null,
            'product_attribute_set_id' => $request->input('product_attribute_set_id'),
        ]);

        $image_paths = [$image_path_1, $image_path_2, $image_path_3];


        $product_images = Product_Image::where('product_id', $product->id)->get();

        if (isset($product_images)) {
            foreach ($product_images as $product_image) {
                $product_image->update([
                    'image_url' => $image_paths[0],
                ]);
                array_shift($image_paths);
            }
        } else {
            foreach ($product_images as $product_image) {
                $product_image->update([
                    'image_url' => '/storage/photos/products/empty-photo.jpg',
                ]);
                array_shift($image_paths);
            }
        }


        return redirect('/admin/products');
    }

    public function destroy($id, Request $request)
    {
        if($request->filled('id')) {
            Product::find($id)->delete();
        }

        $product_images = Product_Image::where('product_id', $id)->get();

        foreach ($product_images as $product_image) {
            $product_image->delete();
        }

        $model = Product::query()
            ->select(['id', 'image', 'title', 'description', 'price', 'status', 'created_at', 'updated_at'])
            ->where('deleted_at','<>', 'null')
            ->where('status', 4);

        return DataTables::of($model)
            ->editColumn('status', function ($product) {
                if ($product->status == 1) {
                    return 'Hoạt động';
                } elseif ($product->status == 2) {
                    return 'Không hoạt động';
                } elseif ($product->status == 3) {
                    return 'Đợi';
                } else {
                    return 'Xóa mềm';
                }
            })
            ->editColumn('price', function ($product) {
                return number_format($product->price * 1000, 0, ',', ',');
            })
            ->addColumn('action', function ($product) {
                return view('admin.products.action_delete', ['product' => $product]);
            })
            ->editColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="' . $row->image . '" alt="' . $row->title . '">';
            })
            ->rawColumns(['image'])
            ->make();
    }

    // soft product
    public function softDelete(Request $request)
    {
        $model = Product::query()
            ->select(['id', 'image', 'title', 'description', 'price', 'status', 'created_at', 'updated_at'])
            ->whereNull('deleted_at')
            ->where('status', '<>', 4);
        if ($request->filled('product_id')) {
            Product::find($request->product_id)->update([
                'deleted_at' => now(),
                'status' => 4
            ]);
        }
        return DataTables::of($model)
            ->editColumn('status', function ($product) {
                if ($product->status == 1) {
                    return 'Hoạt động';
                } elseif ($product->status == 2) {
                    return 'Không hoạt động';
                } elseif ($product->status == 3) {
                    return 'Đợi';
                } else {
                    return 'Xóa mềm';
                }
            })
            ->editColumn('price', function ($product) {
                return number_format($product->price * 1000, 0, ',', ',');
            })
            ->addColumn('action', function ($product) {
                return view('admin.products.action', ['product' => $product]);
            })
            ->editColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="' . $row->image . '" alt="' . $row->title . '">';
            })
            ->rawColumns(['image'])
            ->make();
    }

    public function trashProduct()
    {
        $model = Product::query()
            ->select(['id', 'image', 'title', 'description', 'price', 'status', 'created_at', 'updated_at'])
            ->where('deleted_at','<>', 'null')
            ->where('status', 4);

        return DataTables::of($model)
            ->editColumn('status', function ($product) {
                if ($product->status == 1) {
                    return 'Hoạt động';
                } elseif ($product->status == 2) {
                    return 'Không hoạt động';
                } elseif ($product->status == 3) {
                    return 'Đợi';
                } else {
                    return 'Xóa mềm';
                }
            })
            ->editColumn('price', function ($product) {
                return number_format($product->price * 1000, 0, ',', ',');
            })
            ->addColumn('action', function ($product) {
                return view('admin.products.action_delete', ['product' => $product]);
            })
            ->editColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="' . $row->image . '" alt="' . $row->title . '">';
            })
            ->rawColumns(['image'])
            ->make();
    }


    public function import()
    {
        return view('admin.imports.products.import_product');
    }

    public function importExcelData(Request $request)
    {
        $request->validate([
            'import_file' => ['required', 'file'],
        ]);

        $file = $request->file('import_file');
        Excel::import(new ProductsImport, $file);

        return redirect()->back()->with('status', 'Nhập file thành công');
    }
}

