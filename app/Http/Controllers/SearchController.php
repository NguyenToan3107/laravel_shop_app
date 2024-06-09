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
    public function __construct(protected UserService  $userService, protected CategoryService $categoryService)
    {
    }
    public function searchProduct(Request $request)
    {
//        $categories = Category::with('children')->whereNull('parent_id')->get();
        $model = Product::query()->select(['id', 'image', 'title', 'description', 'price', 'status', 'created_at', 'updated_at']);
        try {
            if($request->has('title') && !empty($request->title)) {
                $model = $model->where('title', 'like', '%'.$request->title.'%');
            }
            if($request->has('price') && !empty($request->price)) {
                $model = $model->whereBetween('price', [$request->price - 100, $request->price + 100]);
            }
            if($request->has('status') && !empty($request->status)) {
                $model = $model->where('status', $request->status);
            }

            if ($request->has('started_at') && !empty($request->started_at)) {
                $model = $model->whereDate('created_at', '>=', $request->started_at);
            }

            if ($request->has('ended_date') && !empty($request->ended_date)) {
                $model = $model->whereDate('created_at', '<=', $request->ended_date);
            }

        }catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while processing your request: ' . $e->getMessage()
            ], 500);
        }
        return DataTables::of($model)
            ->editColumn( 'status',function ($product) {
                if($product->status == 1) {
                    return 'Active';
                }elseif($product->status == 2) {
                    return 'Inactive';
                } else {
                    return 'Pending';
                }
            })
            ->addColumn('action', function ($product) {
                return view('products.action', ['product' => $product]);
            })
            ->editColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="/images/products/'.$row->image.'" alt="' . $row->title . '">';
            })
            ->rawColumns(['image'])
            ->make();
    }
}
