<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SearchController extends Controller
{
    const DEFAULT_DATE = 'NaN-NaN-NaN NaN:NaN:NaN';

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
        } else {
            $model = $model->where('status', '<>', 4);
        }

        if ($request->filled('started_at') && ($request->started_at != SearchController::DEFAULT_DATE)) {
            $model = $model->whereDate('created_at', '>=', $request->started_at);
        }

        if ($request->filled('ended_at') && ($request->ended_at != SearchController::DEFAULT_DATE)) {
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
                }else {
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

    public function searchPost(Request $request)
    {
        $model = Post::query()
            ->select(['id', 'image', 'title', 'description', 'author_id', 'status', 'created_at', 'updated_at']);

//            ->whereNull('deleted_at');

        if ($request->filled('title')) {
            $model = $model->where('title', 'like', '%' . $request->title . '%');
        }

        $model = $model->when($request->filled('author_name'), function ($query) use ($request) {
            $userIds = DB::table('users')
                ->where('name', 'like', '%' . $request->author_name . '%')
                ->pluck('id');
            return $query->whereIn('author_id', $userIds);
        });

        if ($request->filled('status')) {
            $model = $model->where('status', $request->status);
        } else {
            $model = $model->where('status', '<>', 4);
        }

        if ($request->filled('started_at') && ($request->started_at != SearchController::DEFAULT_DATE)) {
            $model = $model->whereDate('created_at', '>=', $request->started_at);
        }

        if ($request->filled('ended_at') && ($request->ended_at != SearchController::DEFAULT_DATE)) {
            $model = $model->whereDate('created_at', '<=', $request->ended_at);
        }

        return DataTables::of($model)
            ->editColumn('status', function ($post) {
                $statusMessages = [
                    1 => 'Hoạt động',
                    2 => 'Không hoạt động',
                    3 => 'Đợi',
                    4 => 'Xóa mềm'
                ];
                return $statusMessages[$post->status];
            })
            ->addColumn('action', function ($post) use ($request) {
                if ($request->filled('status')) {
                    if ($post->status == 4) {
                        return view('posts.action_delete', ['post' => $post]);
                    }
                    return view('posts.action', ['post' => $post]);
                }else {
                    return view('posts.action', ['post' => $post]);
                }
            })
            ->editColumn('author_id',function ($post) {
                return $post->users->name;
            })
            ->editColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="' . $row->image . '" alt="' . $row->title . '">';
            })
            ->rawColumns(['image'])
            ->make();
    }


    public function searchUser(Request $request)
    {
        $model = Post::query()
            ->select(['id', 'image_path', 'name', 'email', 'phoneNumber', 'status', 'address', 'age', 'created_at', 'updated_at']);

//            ->whereNull('deleted_at');

        if ($request->filled('name')) {
            $model = $model->where('name', 'like', '%' . $request->name . '%');
        }

        $model = $model->when($request->filled('author_name'), function ($query) use ($request) {
            $userIds = DB::table('users')
                ->where('name', 'like', '%' . $request->author_name . '%')
                ->pluck('id');
            return $query->whereIn('author_id', $userIds);
        });

        if ($request->filled('status')) {
            $model = $model->where('status', $request->status);
        } else {
            $model = $model->where('status', '<>', 4);
        }

        if ($request->filled('started_at') && ($request->started_at != SearchController::DEFAULT_DATE)) {
            $model = $model->whereDate('created_at', '>=', $request->started_at);
        }

        if ($request->filled('ended_at') && ($request->ended_at != SearchController::DEFAULT_DATE)) {
            $model = $model->whereDate('created_at', '<=', $request->ended_at);
        }

        return DataTables::of($model)
            ->editColumn('status', function ($post) {
                $statusMessages = [
                    1 => 'Hoạt động',
                    2 => 'Không hoạt động',
                    3 => 'Đợi',
                    4 => 'Xóa mềm'
                ];
                return $statusMessages[$post->status];
            })
            ->addColumn('action', function ($post) use ($request) {
                if ($request->filled('status')) {
                    if ($post->status == 4) {
                        return view('posts.action_delete', ['post' => $post]);
                    }
                    return view('posts.action', ['post' => $post]);
                }else {
                    return view('posts.action', ['post' => $post]);
                }
            })
            ->editColumn('author_id',function ($post) {
                return $post->users->name;
            })
            ->editColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="' . $row->image . '" alt="' . $row->title . '">';
            })
            ->rawColumns(['image'])
            ->make();
    }
}
