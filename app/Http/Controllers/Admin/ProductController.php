<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function show($id)
    {
        $product = Product::find($id);
        return view('admin.products.show', ['product' => $product]);
    }

    public function create()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $products = Product::all();
        return view('admin.products.create_edit_product', ['categories' => $categories, 'products' => $products]);
    }

    public function store(Request $request)
    {
        $description = $request->input('description');
        $description = substr($description, 3, strlen($description) - 7);
        $request->validate([
//            'product_image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
            'title' => 'required|unique:products',
        ]);

//        if(isset(request()->image)) {
//            $generatedImageName = str_replace(' ', '',
//                ('image' . time() . '-'.request()->title. '.' .request()->image->getClientOriginalExtension()));
//            request()->image->move(public_path('images/products'), $generatedImageName);
//        } else {
//            $generatedImageName = 'empty-photo.jpg';
//        }

        if($request->filled('filepath')) {
            $image_path = $request->input('filepath');
            $image_path = explode('http://localhost:8000', $image_path)[1];
        }else {
            $image_path = '/storage/photos/products/empty-photo.jpg';
        }

        DB::table('products')->insert([
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'percent_sale' => $request->input('percent_sale'),
            'description' => $description,
            'image' => $image_path,
            'category_id' => $request->input('category_id'),
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect(ProductController::PRODUCTS_PATH);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $category = Category::find($product->category_id);
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return view('admin.products.create_edit_product',
            ['product' => $product,
                'categories' => $categories,
                'c' => $category
            ]);
    }

    public function update(Request $request, $id)
    {
        $description = $request->input('description');
        $description = substr($description, 3, strlen($description) - 7);

        $product = Product::find($id);

//        if(isset(request()->image)) {
//            $generatedImageName = str_replace(' ', '',
//                ('image' . time() . '-'.request()->title. '.' .request()->image->getClientOriginalExtension()));
//            request()->image->move(public_path('images/products'), $generatedImageName);
//        } else {
//            $generatedImageName = $product->image;
//        }

        if($request->filled('filepath')) {
            $image_path = $request->input('filepath');
            $image_path = explode('http://localhost:8000', $image_path)[1];
        }else {
            $image_path = $product->image;
        }

        $product->where('id', $id)->update([
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'description' => $description,
            'image' => $image_path,
            'status' => $request->input('status'),
            'category_id' => $request->input('category_id'),
            'updated_at' => now(),
            'deleted_at' => null
        ]);
        return redirect('/admin/products');
    }

    public function destroy($id, Request $request)
    {
        if($request->filled('id')) {
            Product::find($id)->delete();
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
}

