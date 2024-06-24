<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrderDetailsDataTable;
use App\DataTables\OrdersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    public function index(OrdersDataTable $dataTable) {
        return $dataTable->render('admin.orders.index');
    }

    public function show($id, OrderDetailsDataTable $dataTable) {
        $order = Order::with(['orderDetails.products', 'orderDetails.user'])->findOrFail($id);
        $user = User::find($order->author_id);
        return $dataTable->render('admin.orders.show', ['order' => $order, 'user' => $user]);
//        return view('admin.orders.show', ['order' => $order, 'user' => $user]);
    }
}
