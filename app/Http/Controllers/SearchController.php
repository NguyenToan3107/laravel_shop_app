<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SearchController extends Controller
{
    public function __construct(protected UserService $userService, protected CategoryService $categoryService)
    {
    }

    public function searchProduct(Request $request)
    {
        $model = Product::query()
            ->select(['id', 'image', 'title', 'description', 'price', 'status', 'created_at', 'updated_at']);
//            ->whereNull('deleted_at');

        if ($request->filled('title')) {
            $model = $model->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->filled('price')) {
            $model = $model->whereBetween('price', [$request->price - 1000, $request->price + 1000]);
        }
        if ($request->filled('status')) {
            $model = $model->where('status', $request->status);
        }

        if ($request->filled('started_at') && ($request->started_at != 'NaN-NaN-NaN NaN:NaN:NaN')) {
            $model = $model->whereDate('created_at', '>=', $request->started_at);
        }

        if ($request->filled('ended_at') && ($request->ended_at != 'NaN-NaN-NaN NaN:NaN:NaN')) {
            $model = $model->whereDate('created_at', '<=', $request->ended_at);
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
            ->addColumn('action', function ($product) use ($request) {
                if ($request->filled('status')) {
                    if ($product->status == 4) {
                        return view('products.action_delete', ['product' => $product]);
                    }
                    return view('products.action', ['product' => $product]);
                }
            })
            ->editColumn('price', function ($product) {
                return number_format($product->price * 1000, 0, ',', ',');
            })
            ->editColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="/images/products/' . $row->image . '" alt="' . $row->title . '">';
            })
            ->rawColumns(['image'])
            ->make();
    }
}
