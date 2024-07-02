<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('status', function ($user) {
                if ($user->status == 1) {
                    return 'Hoạt động';
                } elseif ($user->status == 2) {
                    return 'Không hoạt động';
                } elseif ($user->status == 3) {
                    return 'Đợi';
                } else {
                    return 'Xóa mềm';
                }
            })
            ->addColumn('action', function ($user) {
                return view('admin.users.action', ['user' => $user]);
            })
            ->addColumn('image_path', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="'.$row->image_path.'" alt="' . $row->name . '">';
            })
            ->addColumn('roles', function ($user) {
                $roles = $user->getRoleNames()->map(function($roleName) {
                    return '<label class="badge bg-primary mx-1">' . $roleName . '</label>';
                })->implode(' ');

                return '<td>' . $roles . '</td>';
            })
            ->rawColumns(['image_path', 'roles', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->select(['id', 'image_path', 'name', 'email', 'phoneNumber', 'status', 'address', 'age', 'created_at', 'updated_at'])
            ->whereNull('deleted_at')->where('status', '<>', 4);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->autoWidth(false)
                    ->scrollX(true)
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
            Column::make('image_path')->title('Ảnh'),
            Column::make('name')->title('Tên'),
            Column::make('email')->title('Email'),
            Column::make('phoneNumber')->title('Số điện thoại'),
            Column::make('address')->title('Địa chỉ'),
            Column::make('roles')->title('Quyền'),
            Column::make('age')->title('Tuổi'),
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
        return 'Users_' . date('YmdHis');
    }
}
