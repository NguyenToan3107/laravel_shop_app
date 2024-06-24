<?php

namespace App\DataTables;

use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrderDetailsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query->with(['products', 'user'])))
            ->addColumn('product_title', function (OrderDetail $orderDetail) {
                return $orderDetail->products->title;
            })
            ->addColumn('product_price', function (OrderDetail $orderDetail) {
                return $orderDetail->products->price;
            })
            ->addColumn('product_percent_sale', function (OrderDetail $orderDetail) {
                return $orderDetail->products->percent_sale . '%';
            })
            ->editColumn('quantity', function (OrderDetail $orderDetail) {
                return $orderDetail->quantity;
            })
            ->editColumn('total', function (OrderDetail $orderDetail) {
                return number_format(($orderDetail->quantity  - ($orderDetail->products->percent_sale / 100)) * $orderDetail->products->price, 2) ;
            })
            ->addColumn('image', function ($orderDetail) {
                return '<img class="img-thumbnail user-image-45" src="'.$orderDetail->products->image.'" alt="' . $orderDetail->products->title . '">';
            })
            ->rawColumns(['image'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(OrderDetail $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('orderdetails-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->autoWidth(false)
//                    ->searching(false)
                    //->dom('Bfrtip')
                    ->orderBy(1)
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
            Column::make('image')->title('Ảnh sản phẩm'),
            Column::make('product_title')->title('Tên sản phẩm'),
            Column::make('product_price')->title('Giá tiền'),
            Column::make('quantity'),
            Column::make('product_percent_sale')->title('Khuyến mãi'),
            Column::make('total'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'OrderDetails_' . date('YmdHis');
    }
}
