<?php

namespace App\DataTables;

use App\Models\Product_Attribute;
use App\Models\Product_Attribute_Set;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class Product_Attribute_By_SetDataTable extends DataTable
{

    protected $product_attribute_set;

    public function with(array|string $key, mixed $value = null): static
    {
        if (isset($key['product_attribute_set'])) {
            $this->product_attribute_set = $key['product_attribute_set'];
        }
        return $this;
    }

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($product_attribute) {

                $product_attribute_set = Product_Attribute_Set::where('id', $this->product_attribute_set->id)
                    ->select('id', 'name')->first();

                return view('admin.products.product_attribute_sets.action_attribute', [
                    'product_attribute' => $product_attribute,
                    'product_attribute_set' => $product_attribute_set,
                ]);
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product_Attribute $model): QueryBuilder
    {
        return $model->newQuery()->select(['product_attribute.id', 'product_attribute.name'])
            ->join('product_attribute_set_attribute', 'product_attribute.id', '=', 'product_attribute_set_attribute.attribute_id')
            ->where('product_attribute_set_attribute.attribute_set_id', $this->product_attribute_set->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('product_attribute_by_set-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->autoWidth(false)
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
            Column::make('name'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(110)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Product_Attribute_By_Set_' . date('YmdHis');
    }
}
