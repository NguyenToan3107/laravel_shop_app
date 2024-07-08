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

    public function index(ProductsDataTable $dataTable)
    {

        $categories = Category::with('children')->whereNull('parent_id')->get();
        return $dataTable->render('admin.products.index', [
            'categories' => $categories
        ]);
    }

    public function show($slug, ProductSkusDataTable $dataTable)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
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
        $request->validate([
//            'product_image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
            'title' => 'required|unique:products',
        ]);
        if ($request->filled('filepath')) {
            $image_path = $request->input('filepath');
            $image_path = explode('http://localhost:8000', $image_path)[1];
        } else {
            $image_path = '/storage/photos/products/empty-photo.jpg';
        }


        if ($request->filled('filepath_1')) {
            $image_path_1 = $request->input('filepath_1');
            $image_path_1 = explode('http://localhost:8000', $image_path_1)[1];
        } else {
            $image_path_1 = '/storage/photos/products/empty-photo.jpg';
        }
        if ($request->filled('filepath_2')) {
            $image_path_2 = $request->input('filepath_2');
            $image_path_2 = explode('http://localhost:8000', $image_path_2)[1];
        } else {
            $image_path_2 = '/storage/photos/products/empty-photo.jpg';
        }
        if ($request->filled('filepath_3')) {
            $image_path_3 = $request->input('filepath_3');
            $image_path_3 = explode('http://localhost:8000', $image_path_3)[1];
        } else {
            $image_path_3 = '/storage/photos/products/empty-photo.jpg';
        }

        $product = Product::create([
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'price_old' => $request->input('price_old'),
            'total_item' => $request->input('total_item'),
            'percent_sale' => $request->percent_sale,
            'description' => $description,
            'content' => $request->input('content'),
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

    public function edit($slug)
    {
        $product_attribute_sets = Product_Attribute_Set::select('id', 'name')->get();
        $product = Product::where('slug', $slug)->first();
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

    public function update(Request $request, $slug)
    {
        $description = $request->input('description');

        $product = Product::where('slug', $slug)->first();
        $array_product_images = $product->product_images->pluck('image_url');

        if ($product) {
            if ($request->filled('filepath')) {
                $image_path = $request->input('filepath');
                $image_path = explode('http://localhost:8000', $image_path)[1];
            } else {
                $image_path = $product->image;
            }

            // sub image
            if ($request->filled('filepath_1')) {
                $image_path_1 = $request->input('filepath_1');
                $image_path_1 = explode('http://localhost:8000', $image_path_1)[1];
            } else {
                $image_path_1 = $array_product_images[0];
            }
            if ($request->filled('filepath_2')) {
                $image_path_2 = $request->input('filepath_2');
                $image_path_2 = explode('http://localhost:8000', $image_path_2)[1];
            } else {
                $image_path_2 = $array_product_images[1];
            }
            if ($request->filled('filepath_3')) {
                $image_path_3 = $request->input('filepath_3');
                $image_path_3 = explode('http://localhost:8000', $image_path_3)[1];
            } else {
                $image_path_3 = $array_product_images[2];
            }
        }

        $product->update([
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'price_old' => $request->input('price_old'),
            'percent_sale' => $request->percent_sale,
            'description' => $description,
            'content' => $request->input('content'),
            'image' => $image_path,
            'category_id' => $request->category_id,
            'status' => $request->input('status'),
            'total_item' => $request->input('total_item'),
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

    public function destroy($slug, Request $request)
    {
        if ($request->filled('slug')) {
            $product = Product::where('slug', $slug)->first();
            if ($product) {
                $product->delete();
                $product_images = Product_Image::where('product_id', $product->id)->get();

                foreach ($product_images as $product_image) {
                    $product_image->delete();
                }
            } else {
                echo "Product not found.";
            }
        }


        $model = Product::query()
            ->select(['id', 'image', 'title', 'description', 'price', 'status', 'created_at', 'updated_at', 'price_old', 'percent_sale'])
            ->where('deleted_at', '<>', 'null')
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
            ->select(['id', 'image', 'title', 'description', 'price', 'status', 'created_at', 'updated_at', 'slug', 'price_old', 'percent_sale'])
            ->whereNull('deleted_at')
            ->where('status', '<>', 4);
        if ($request->filled('slug')) {
            Product::where('slug', $request->slug)->first()->update([
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

