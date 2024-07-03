<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromView
{
    public function view(): \Illuminate\Contracts\View\View
    {

        $total_price = Order::sum('price');

        return view('admin.exports.excel.orders', [
            'orders' => Order::select(['id', 'fullname', 'phone', 'address', 'percent_sale', 'price', 'updated_at', 'status'])->get(),
            'total_price' => $total_price
        ]);
    }
}
