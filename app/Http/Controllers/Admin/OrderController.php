<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\orders\OrderDetailsDataTable;
use App\DataTables\OrdersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-order')->only('store', 'create');
        $this->middleware('permission:edit-order')->only('update', 'edit');
        $this->middleware('permission:delete-order')->only('destroy', 'softDelete');
        $this->middleware('permission:view-order')->only('index');
    }

    public function index(OrdersDataTable $dataTable) {
        return $dataTable->render('admin.orders.index');
    }

    public function show($id, OrderDetailsDataTable $dataTable) {
        $order = Order::with(['orderDetails.products', 'orderDetails.user'])->findOrFail($id);
        $user = User::find($order->author_id);
        return $dataTable->with(['order' => $order, 'user' => $user])->render('admin.orders.show', ['order' => $order, 'user' => $user]);
    }

    public function create(OrderDetailsDataTable $dataTable)
    {
        $users = User::all();
//        return $dataTable
////            ->with(['order' => $order, 'user' => $user])
//            ->render('admin.orders.create_edit', [
//                'users' => $users,
//            ]);

        return view('admin.orders.create_edit', [
            'users' => $users,
        ]);
    }

    public function store(Request $request) {
        return redirect('/admin/orders')->with('success', 'Tạo mới đơn hàng thành công!');
    }

    public function edit($id, OrderDetailsDataTable $dataTable) {
        $order = Order::with(['orderDetails.products', 'orderDetails.user'])->findOrFail($id);
        $user = User::find($order->author_id);
        $users = User::all();

        return $dataTable
                ->with(['order' => $order, 'user' => $user])
                ->render('admin.orders.edit', ['order' => $order, 'user' => $user, 'users' => $users]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::with(['orderDetails.products', 'orderDetails.user'])->findOrFail($id);
        $user = User::find($order->author_id);
//        $products = $order->orderDetails->filter(function ($orderDetail) use ($user) {
//            return $orderDetail->user->id === $user->id;
//        })->pluck('products')->flatten();

        $total_price = 0;
        $order->orderDetails->each(function ($orderDetail) use (&$total_price, $user) {
            if($orderDetail->products->count() > 0){
//                if($orderDetail->user->id === $user->id){
//                    $total_price += $orderDetail->products->price * $orderDetail->quantity;
//                }
                $total_price += $orderDetail->products->price * $orderDetail->quantity;
            }
        });

        $order->update([
            'fullname' => $request->input('fullname'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'author_id' => $request->input('author_id'),
            'status' => $request->input('status'),
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'percent_sale' => $request->input('percent_sale'),
            'price' => $total_price
        ]);

        return redirect('/admin/orders')->with('success', 'Cập nhật đơn hàng thành công!');
    }


    public function destroy($id, Request $request)
    {
        if($request->filled('id')) {
            DB::table('order')->where('id', $id)->delete();
        }
        $model = Order::query()
            ->select(['id', 'price', 'status', 'updated_at', 'fullname', 'phone', 'address', 'author_id', 'percent_sale'])
            ->where('deleted_at','<>', 'null')
            ->where('status', 6);

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
            ->editColumn('phone', function (Order $order) {
                return $order->phone;
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
                return view('admin.orders.action_delete', ['order' => $order]);
            })
            ->rawColumns(['updated_at', 'status'])
            ->setRowId('id')
            ->make();
    }

    // soft post
    public function softDelete(Request $request)
    {
        $model = Order::query()
            ->select(['id', 'price', 'status', 'updated_at', 'fullname', 'phone', 'address', 'author_id', 'percent_sale'])
            ->whereNull('deleted_at')
            ->where('status', '<>', 6);
        if ($request->filled('order_id')) {
            Order::find($request->order_id)->update([
                'deleted_at' => now(),
                'status' => 6
            ]);
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
                return view('admin.orders.action', ['order' => $order]);
            })
            ->rawColumns(['updated_at', 'status'])
            ->setRowId('id')
            ->make();

    }
}
