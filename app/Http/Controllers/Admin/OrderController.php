<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\orders\OrderDetailsDataTable;
use App\DataTables\OrdersDataTable;
use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;


class OrderController extends Controller
{
    const DEFAULT_DATE = 'NaN-NaN-NaN NaN:NaN:NaN';

    public function __construct()
    {
        $this->middleware('permission:create-order')->only('store', 'create');
        $this->middleware('permission:edit-order')->only('update', 'edit');
        $this->middleware('permission:delete-order')->only('destroy', 'softDelete');
        $this->middleware('permission:view-order')->only('index', 'export', 'export_order_detail');
    }

    public function index(Request $request)
    {
        $count_order = Order::count();
        $total_order = Order::sum('price');

        if ($request->ajax()) {
            $model = Order::query()
                ->select(['id', 'price', 'status', 'updated_at', 'fullname', 'phone', 'address', 'author_id', 'percent_sale']);
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
                $model = $model->withTrashed()->where('status', $request->status);
            } else {
                $model = $model->where('status', '<>', 6);
            }

            if ($request->filled('started_at') && ($request->started_at != OrderController::DEFAULT_DATE)) {
                $model = $model->whereDate('updated_at', '>=', $request->started_at);
            }

            if ($request->filled('ended_at') && ($request->ended_at != OrderController::DEFAULT_DATE)) {
                $model = $model->whereDate('updated_at', '<=', $request->ended_at);
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
                    return view('admin.orders.action', ['order' => $order]);

                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" name="ids_order" class="checkbox_ids_orders" value="' . $row->id . '"/>';
                })
                ->rawColumns(['updated_at', 'status', 'checkbox'])
                ->setRowId('id')
                ->make();
        }

        return view('admin.orders.index', [
            'count_order' => $count_order,
            'total_order' => $total_order,
        ]);
    }
    public function show($id, Request $request)
    {
        $order = Order::with(['orderDetails.products', 'orderDetails.user'])
            ->withTrashed()
            ->select('id', 'fullname', 'phone', 'address', 'price', 'percent_sale', 'author_id')
            ->findOrFail($id);

        $user = User::where('id', $order->author_id)->select('id', 'image_path', 'name', 'address', 'email')->first();

        if ($request->ajax()) {
            $model = OrderDetail::where('order_id', $id)
                ->select('id', 'quantity', 'created_at', 'updated_at', 'item_id', 'unit_price', 'order_id')
                ->with(['products', 'user']);

            return DataTables::of($model)
                ->addColumn('product_title', function (OrderDetail $orderDetail) {
                    return $orderDetail->products->title;
                })
                ->addColumn('product_price', function (OrderDetail $orderDetail) {
                    return number_format($orderDetail->products->price * 1000, 0);
                })
                ->addColumn('product_percent_sale', function (OrderDetail $orderDetail) {
                    return $orderDetail->products->percent_sale . '%';
                })
                ->editColumn('quantity', function (OrderDetail $orderDetail) {
                    return $orderDetail->quantity;
                })
                ->editColumn('total', function (OrderDetail $orderDetail) {
                    return number_format((1 - ($orderDetail->products->percent_sale / 100)) * $orderDetail->quantity * $orderDetail->products->price * 1000, 0);
                })
                ->addColumn('image', function ($orderDetail) {
                    return '<img class="img-thumbnail user-image-45" src="' . $orderDetail->products->image . '" alt="' . $orderDetail->products->title . '">';
                })
                ->rawColumns(['image'])
                ->setRowId('id')
                ->make();
        }
        return view('admin.orders.show', [
            'order' => $order,
            'user' => $user,
        ]);
    }
    public function create(){
        $users = User::all();
        return view('admin.orders.create_edit', [
            'users' => $users,
        ]);
    }
    public function store(){
        return redirect('/admin/orders')->with('success', 'Tạo mới đơn hàng thành công!');
    }
    public function edit($id, Request $request)
    {
        $order = Order::withTrashed()->with(['orderDetails.products', 'orderDetails.user'])
            ->select(['id', 'price', 'status', 'updated_at', 'fullname', 'phone', 'address', 'author_id', 'percent_sale', 'deleted_at'])
            ->findOrFail($id);
        $users = User::select('id', 'name')->get();
        if ($request->ajax()) {
            $model = OrderDetail::where('order_id', $id)
                ->select('id', 'quantity', 'created_at', 'updated_at', 'item_id', 'unit_price', 'order_id', 'deleted_at')
                ->with(['products', 'user']);

            return DataTables::of($model)
                ->addColumn('product_title', function (OrderDetail $orderDetail) {
                    return $orderDetail->products->title;
                })
                ->addColumn('product_price', function (OrderDetail $orderDetail) {
                    return number_format($orderDetail->products->price * 1000, 0);
                })
                ->addColumn('product_percent_sale', function (OrderDetail $orderDetail) {
                    return $orderDetail->products->percent_sale . '%';
                })
                ->editColumn('quantity', function (OrderDetail $orderDetail) {
                    return $orderDetail->quantity;
                })
                ->editColumn('total', function (OrderDetail $orderDetail) {
                    return number_format((1 - ($orderDetail->products->percent_sale / 100)) * $orderDetail->quantity * $orderDetail->products->price * 1000, 0);
                })
                ->addColumn('image', function ($orderDetail) {
                    return '<img class="img-thumbnail user-image-45" src="' . $orderDetail->products->image . '" alt="' . $orderDetail->products->title . '">';
                })
                ->rawColumns(['image'])
                ->setRowId('id')
                ->make();
        }

        return view('admin.orders.create_edit', [
            'order' => $order,
            'users' => $users,
        ]);
    }
    public function update(Request $request, $id)
    {
        $order = Order::withTrashed()->with(['orderDetails.products', 'orderDetails.user'])
            ->select(['id', 'price', 'status', 'updated_at', 'fullname', 'phone', 'address', 'author_id', 'percent_sale', 'deleted_at'])
            ->findOrFail($id);
//        $products = $order->orderDetails->filter(function ($orderDetail) use ($user) {
//            return $orderDetail->user->id === $user->id;
//        })->pluck('products')->flatten();

        $total_price = 0;
        $order->orderDetails->each(function ($orderDetail) use (&$total_price) {
            if ($orderDetail->products->count() > 0) {
                $total_price += $orderDetail->products->price * (1 - ($orderDetail->products->percent_sale / 100)) * $orderDetail->quantity;
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
            'price' => $total_price,
            'deleted_at' => null
        ]);

        if($order->status >= 4) {
           foreach ($order->orderDetails as $orderDetail) {
               $product = Product::with('categories')->where('id', $orderDetail->item_id)->first();
               $product->update([
                   'total_order' => (is_null($product->total_order) ? 0 : $product->total_order) + $orderDetail->quantity
               ]);
               $product?->categories->update([
                   'total_order' => (is_null($product->categories->total_order) ? 0 : $product->categories->total_order) + $orderDetail->quantity
               ]);
           }
        }

        return redirect('/admin/orders')->with('success', 'Cập nhật đơn hàng thành công!');
    }
    public function destroy($id)
    {
        $array_id = explode(',', $id);
        $orders = Order::withTrashed()->whereIn('id', $array_id)->get();
        foreach ($orders as $order) {
            if(is_null($order->deleted_at)){
                $order->update([
                    'status' => 6
                ]);
                $order->delete();
            }else {
                $order->forceDelete();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Thành công'
        ]);
    }
    // export order
    public function export()
    {
        $filename = 'orders.xlsx';
        return Excel::download(new OrdersExport, $filename);
    }
    public function export_order_detail($id)
    {
        $order = Order::findOrFail($id);
        $user = User::find($order->author_id);
        $pdf = PDF::loadView('admin.exports.pdf.order_detail', [
            'order' => $order,
            'user' => $user
        ]);
        return $pdf->download('invoice.pdf');
    }

}
