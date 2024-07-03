<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\SearchPane;
use Yajra\DataTables\Services\DataTable;

class ProductsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
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
            ->editColumn('price', function ($product) {
                    return number_format($product->price * 1000, 0, ',', ',');
//                if(Auth::user()->hasPermissionTo('view-price')) {
//                } else {
//                    return '';
//                }
            })
            ->editColumn('price_old', function ($product) {
                return number_format($product->price_old * 1000, 0, ',', ',');
            })
            ->editColumn('percent_sale', function ($product) {
                return $product->percent_sale . '%';
            })
            ->addColumn('action', function ($product) {
                return view('admin.products.action', ['product' => $product]);
            })
            ->addColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="'.$row->image.'" alt="' . $row->title . '">';
            })
            ->rawColumns(['image'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery()->select(['id', 'image', 'title', 'description', 'price', 'status', 'created_at', 'updated_at', 'price_old', 'percent_sale'])
                                ->whereNull('deleted_at')->where('status', '<>', 4);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('products-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
//                    ->dom('Pfrtip')
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
            Column::make('image')->title('Ảnh'),
            Column::make('title')->title('Tên sản phẩm'),
            Column::make('price_old')->title('Giá gốc'),
            Column::make('percent_sale')->title('Khuyến mãi'),
            Column::make('price')->title('Giá bán'),
            Column::make('status')->title('Trạng thái'),
            Column::computed('action')
                ->title('Hành động')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Products_' . date('YmdHis');
    }
}
