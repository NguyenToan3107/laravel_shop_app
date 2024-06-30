<?php

namespace App\DataTables;

use App\Models\Product_Sku;
use App\Models\ProductSku;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductSkusDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */

    protected $product;
    public function with(array|string $key, mixed $value = null): static
    {
        if (isset($key['product'])) {
            $this->product = $key['product'];
        }
        return $this;
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($product_sku) {
                return view('admin.products.product_skus.action', [
                    'product_sku' => $product_sku,
                ]);
            })
            ->editColumn('price', function ($product_sku) {
                return number_format($product_sku->price * 1000, 0);
            })
            ->editColumn('percent_sale', function ($product_sku) {
                return $product_sku->percent_sale . '%';
            })
            ->editColumn('price_old', function ($product_sku) {
                return number_format($product_sku->price_old * 1000, 0);
            })
            ->addColumn('value', function ($product_sku) {
                $attribute = $product_sku->attributeValues->map(function ($attributeName) {
                    return '<label class="badge bg-primary mx-1">' . $attributeName->value . '</label>';
                })->implode(' ');
                return '<td>' . $attribute . '</td>';
            })
            ->rawColumns(['action', 'percent_sale', 'price', 'value'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product_Sku $model): QueryBuilder
    {
//        return $model->newQuery()
//            ->select(['product_skus.id', 'product_skus.product_id', 'product_skus.price',
//                'product_skus.price_old', 'product_skus.percent_sale', 'product_skus.quantity', 'product_attribute_value.value as value'])
//            ->join('product_skus_attribute_value', 'product_skus.id', '=', 'product_skus_attribute_value.sku_id')
//            ->join('product_attribute_value', 'product_attribute_value.id', '=', 'product_skus_attribute_value.attribute_value_id')
//            ->where('product_skus.product_id', $this->product->id);

        return $model->newQuery()->where('product_id', $this->product->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('product_skus-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->autoWidth(false)
                    ->scrollX(true)
                    ->searching(false)
                    ->orderBy(0, 'asc')
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
            Column::make('value')->title('Thuộc tính'),
            Column::make('price')->title('Giá mới'),
            Column::make('percent_sale')->title('Khuyến mãi'),
            Column::make('price_old')->title('Giá cũ'),
            Column::make('quantity')->title('Số lượng'),
            Column::computed('action')
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
        return 'ProductSkus_' . date('YmdHis');
    }
}
