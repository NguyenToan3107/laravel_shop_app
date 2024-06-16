<?php

namespace App\Http\Controllers;

use App\DataTables\ProductsDataTable;
use App\Models\Category;
use App\Models\Product;
use App\SearchBuilder;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;

class ProductController extends Controller
{
    const PRODUCTS_PATH = '/products';

    public function __construct(protected ProductService $productService, protected CategoryService $categoryService)
    {
//        $this->middleware(['permission:view product', 'role:admin', ['only' => 'index']]);
//        $this->middleware(['permission:edit product', ['only' => 'edit', 'update']]);
//        $this->middleware(['permission:delete product', ['only' => 'destroy']]);
//        $this->middleware(['permission:create product', ['only' => 'create', 'store']]);
    }

    public function index(ProductsDataTable $dataTable) {

        $categories = Category::with('children')->whereNull('parent_id')->get();
        return $dataTable->render('products.index', [
            'categories' => $categories
        ]);
    }

    public function show($id)
    {
        $product = $this->productService->getProductById($id);
        return view('products.show', ['product' => $product]);
    }

    public function create()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $products = $this->productService->getProducts();
        return view('products.create_edit_product', ['categories' => $categories, 'products' => $products]);
    }

    public function store(Request $request)
    {
        $description = $request->input('description');
        $description = substr($description, 3, strlen($description) - 7);
        $request->validate([
//            'product_image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
            'title' => 'required|unique:products',
        ]);

        if(isset(request()->image)) {
            $generatedImageName = str_replace(' ', '',
                ('image' . time() . '-'.request()->title. '.' .request()->image->getClientOriginalExtension()));
            request()->image->move(public_path('images/products'), $generatedImageName);
        } else {
            $generatedImageName = 'empty-photo.jpg';
        }


        $this->productService->createProduct([
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'percent_sale' => $request->input('percent_sale'),
            'description' => $description,
            'image' => $generatedImageName,
            'category_id' => $request->input('category_id'),
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect(ProductController::PRODUCTS_PATH);
    }

    public function edit($id)
    {
        $product = $this->productService->getProductById($id);
        $category = Category::find($product->category_id);
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return view('products.create_edit_product',
            ['product' => $product,
                'categories' => $categories,
                'c' => $category
            ]);
    }

    public function update(Request $request, $id)
    {
        $description = $request->input('description');
        $description = substr($description, 3, strlen($description) - 7);

        $product = $this->productService->getProductById($id);

        if(isset(request()->image)) {
            $generatedImageName = str_replace(' ', '',
                ('image' . time() . '-'.request()->title. '.' .request()->image->getClientOriginalExtension()));
            request()->image->move(public_path('images/products'), $generatedImageName);
        } else {
            $generatedImageName = $product->image;
        }

        // update
        $this->productService->updateProduct($id, [
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'description' => $description,
            'image' => $generatedImageName,
            'status' => $request->input('status'),
            'category_id' => $request->input('category_id'),
            'updated_at' => now(),
            'deleted_at' => null
        ]);
        return redirect('/products');
    }

    public function destroy($id, Request $request)
    {
        if($request->filled('id')) {
            $this->productService->deleteProduct($id);
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
                return view('products.action_delete', ['product' => $product]);
            })
            ->editColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="/images/products/' . $row->image . '" alt="' . $row->title . '">';
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
                return view('products.action', ['product' => $product]);
            })
            ->editColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="/images/products/' . $row->image . '" alt="' . $row->title . '">';
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
                return view('products.action_delete', ['product' => $product]);
            })
            ->editColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="/images/products/' . $row->image . '" alt="' . $row->title . '">';
            })
            ->rawColumns(['image'])
            ->make();
    }
}

