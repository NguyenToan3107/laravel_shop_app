<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use App\Services\CategoryService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SearchController extends Controller
{
    const DEFAULT_DATE = 'NaN-NaN-NaN NaN:NaN:NaN';

    public function __construct(protected UserService $userService, protected CategoryService $categoryService)
    {
        $this->middleware('can:view-user')->only('searchUser');
        $this->middleware('can:view-product')->only('searchProduct');
        $this->middleware('can:view-post')->only('searchPost');
        $this->middleware('can:view-order')->only('searchOrder');
    }

    public function searchProduct(Request $request)
    {
        $model = Product::query()
            ->select(['id', 'image', 'title', 'price_old', 'percent_sale', 'price', 'status', 'created_at', 'updated_at', 'slug']);
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
                        return view('admin.products.action_delete', ['product' => $product]);
                    }
                    return view('admin.products.action', ['product' => $product]);
                }else {
                    return view('admin.products.action', ['product' => $product]);
                }
            })
            ->editColumn('price', function ($product) {
                return number_format($product->price * 1000, 0, ',', ',');
            })
            ->editColumn('price_old', function ($product) {
                return number_format($product->price_old * 1000, 0, ',', ',');
            })
            ->editColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="' . $row->image . '" alt="' . $row->title . '">';
            })
            ->rawColumns(['image'])
            ->make();
    }

    public function searchPost(Request $request)
    {
        $model = Post::query()
            ->select(['id', 'image', 'title', 'description', 'author_id', 'status', 'created_at', 'updated_at', 'slug']);

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
                        return view('admin.posts.action_delete', ['post' => $post]);
                    }
                    return view('admin.posts.action', ['post' => $post]);
                }else {
                    return view('admin.posts.action', ['post' => $post]);
                }
            })
            ->editColumn('author_id',function ($post) {
                return $post->users->name;
            })
            ->addColumn('checkbox', function($row) {
                return '<input type="checkbox" name="ids_post" class="checkbox_ids" value="'.$row->id.'"/>';
            })
            ->editColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="' . $row->image . '" alt="' . $row->title . '">';
            })
            ->rawColumns(['image', 'checkbox'])
            ->make();
    }


    public function searchUser(Request $request)
    {
        $model = User::query()
            ->select(['id', 'image_path', 'name', 'email', 'phoneNumber', 'status', 'address', 'age', 'created_at', 'updated_at']);

        if ($request->filled('name')) {
            $model = $model->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $model = $model->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('phone')) {
            $model = $model->where('phoneNumber', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('address')) {
            $model = $model->where('address', 'like', '%' . $request->address . '%');
        }

        if ($request->filled('age')) {
            $model = $model->where('age', 'like', '%' . $request->age . '%');
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
            ->editColumn('status', function ($post) {
                $statusMessages = [
                    1 => 'Hoạt động',
                    2 => 'Không hoạt động',
                    3 => 'Đợi',
                    4 => 'Xóa mềm'
                ];
                return $statusMessages[$post->status];
            })
            ->addColumn('action', function ($user) use ($request) {
                if ($request->filled('status')) {
                    if ($user->status == 4) {
                        return view('admin.users.action_delete', ['user' => $user]);
                    }
                    return view('admin.users.action', ['user' => $user]);
                }else {
                    return view('admin.users.action', ['user' => $user]);
                }
            })
            ->addColumn('image_path', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="'.$row->image_path.'" alt="' . $row->name . '">';
            })
            ->addColumn('roles', function ($user) {
                $roles = $user->getRoleNames()->map(function($roleName) {
                    return '<label class="badge bg-primary mx-1">' . $roleName . '</label>';
                })->implode(' ');

                return '<td>' . $roles . '</td>';
            })
            ->rawColumns(['image_path', 'roles', 'action'])
            ->make();
    }

    public function searchOrder(Request $request)
    {
        $model = Order::query()
            ->select(['id', 'price', 'status', 'updated_at', 'fullname', 'phone', 'address', 'author_id', 'percent_sale']);

//            ->whereNull('deleted_at');

        if ($request->filled('fullname')) {
            $model = $model->where('fullname', 'like', '%' . $request->fullname . '%');
        }

        if ($request->filled('email')) {
            $model = $model->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('phone')) {
            $model = $model->where('phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('status')) {
            $model = $model->where('status', $request->status);
        } else {
            $model = $model->where('status', '<>', 6);
        }

        if ($request->filled('started_at') && ($request->started_at != SearchController::DEFAULT_DATE)) {
            $model = $model->whereDate('created_at', '>=', $request->started_at);
        }

        if ($request->filled('ended_at') && ($request->ended_at != SearchController::DEFAULT_DATE)) {
            $model = $model->whereDate('created_at', '<=', $request->ended_at);
        }

        return DataTables::of($model)
            ->order(function ($query) {
                $query->orderBy('status', 'asc');
            })
            ->editColumn('status', function (Order $order) {
                return view('admin.orders.status', ['order' => $order]);
            })
            ->editColumn('fullname', function (Order $order) {
                return $order->fullname;
            })
//            ->editColumn('author_id', function (Order $order) {
//                return $order->user->email;
//            })
            ->editColumn('phone', function (Order $order) {
                return $order->phone;
            })
            ->editColumn('price', function (Order $order) {
                return number_format($order->price * (1 - ($order->percent_sale / 100)) * 1000 - 30000, 0);
            })
            ->editColumn('percent_sale', function (Order $order) {
                return $order->percent_sale ? $order->percent_sale : '0';
            })
            ->editColumn('address', function (Order $order) {
                return $order->address;
            })
            ->addColumn('updated_at', function (Order $order) {
                return $order->updated_at->format('d/m/Y');
            })
            ->addColumn('action', function ($order) {
                if($order->status != 6) {
                    return view('admin.orders.action', ['order' => $order]);
                }else {
                    return view('admin.orders.action_delete', ['order' => $order]);
                }
            })
            ->rawColumns(['updated_at', 'status'])
            ->setRowId('id')
            ->make();
    }
}
