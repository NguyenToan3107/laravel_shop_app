<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('status', function (Order $order) {
                return view('admin.orders.status', ['order' => $order]);
            })
            ->editColumn('fullname', function (Order $order) {
                return $order->fullname;
            })
            ->editColumn('author_id', function (Order $order) {
                return $order->user ? $order->user->email : 'No No';
            })
            ->editColumn('phone', function (Order $order) {
                return $order->phone;
            })
            ->editColumn('address', function (Order $order) {
                return $order->address;
            })
            ->editColumn('percent_sale', function (Order $order) {
                return isset($order->percent_sale) ? $order->percent_sale : '0';
            })
            ->addColumn('updated_at', function (Order $order) {
                return $order->updated_at->format('d/m/Y');
            })
            ->editColumn('price', function (Order $order) {
                return number_format($order->price * (1 - ($order->percent_sale / 100)) * 1000 - 30000, 0);
            })
            ->addColumn('action', function ($order) {
                return view('admin.orders.action', ['order' => $order]);
            })
            ->rawColumns(['updated_at', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        return $model->newQuery()
            ->select(['id', 'price', 'status', 'updated_at', 'fullname', 'phone', 'address', 'author_id', 'percent_sale'])
            ->where('status', '<>', 6);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('orders-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->scrollX(true)
                    ->searching(false)
                    //->dom('Bfrtip')
                    ->autoWidth(false)
                    ->orderBy(6, 'asc')
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('fullname')->title('Người đặt'),
//            Column::make('author_id')->title('Email'),
            Column::make('phone')->title('SĐT'),
            Column::make('address')->title('Địa chỉ'),
            Column::make('percent_sale')->title('Khuyến mãi'),
            Column::make('price')->title('Giá'),
            Column::make('status')->title('Trạng thái'),
            Column::make('updated_at')->title('Ngày đặt'),
            Column::computed('action')
                ->title('Hành động')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Orders_' . date('YmdHis');
    }
}
