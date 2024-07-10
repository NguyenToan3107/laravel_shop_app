<?php

namespace App\DataTables;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PostsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('status', function ($post) {
                if ($post->status == 1) {
                    return 'Hoạt động';
                } elseif ($post->status == 2) {
                    return 'Không hoạt động';
                } elseif ($post->status == 3) {
                    return 'Đợi';
                } else {
                    return 'Xóa mềm';
                }
            })
            ->editColumn('author_id', function ($post) {
                return $post->users->name;
            })

            ->addColumn('action', function ($post) {
                return view('admin.posts.action', ['post' => $post]);
            })
            ->addColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="' . $row->image . '" alt="' . $row->title . '">';
            })
            ->addColumn('checkbox', function($row) {
                return '<input type="checkbox" name="ids_post" class="checkbox_ids" value="'.$row->id.'"/>';
            })
            ->rawColumns(['image', 'checkbox', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Post $model): QueryBuilder
    {
        return $model->newQuery()->select(['id', 'image', 'title', 'description', 'author_id', 'status', 'created_at', 'updated_at', 'slug'])
            ->where('status', '<>', 4)->whereNull('deleted_at');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('posts-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->autoWidth(false)
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
            Column::make('checkbox')
                ->title('<input type="checkbox" name="" id="select_all_ids"/>')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false),
            Column::make('id')->title('Id'),
            Column::make('image')->title('Ảnh'),
            Column::make('title')->title('Tiêu đề'),
            Column::make('author_id')->title('Tác giả'),
            Column::make('status')->title('Trạng thái'),
//            Column::make('created_at'),
//            Column::make('updated_at'),
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
        return 'Posts_' . date('YmdHis');
    }
}
