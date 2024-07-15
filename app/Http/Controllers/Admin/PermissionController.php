<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PermissionsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    public function __construct() {
        $this->middleware('permission:create-permission')->only('store', 'create');
        $this->middleware('permission:edit-permission')->only('update', 'edit');
        $this->middleware('permission:delete-permission')->only('destroy');
        $this->middleware('permission:view-permission')->only('index');
    }

    public function index() {
        if(request()->ajax()) {
            $model = Permission::query()->select(['id', 'name', 'created_at', 'updated_at']);
            return DataTables::of($model)
                ->addColumn('action', function ($permission) {
                    return view('admin.role-permission.permission.action', ['permission' => $permission])->render();
                })
                ->rawColumns(['action'])
                ->setRowId('id')
                ->make(true);
        }
        return view('admin.role-permission.permission.index');
    }
    public function create() {
        return view('admin.role-permission.permission.create');
    }
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:permissions,name|string',
        ]);
        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return redirect('admin/permissions')->with('status', 'Tạo mới thành công');
    }
    public function edit($id) {
        $permission = Permission::find($id);

        return view('admin.role-permission.permission.edit', [
            'permission' => $permission
        ]);
    }
    public function update(Request $request, $id) {
        $permission = Permission::findById($id);
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name,'.$permission->id
            ],
        ]);
        Permission::where('id', $id)->update([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);
        return redirect('admin/permissions')->with('status', 'Cập nhật thành công');
    }
    public function destroy($id) {
        $permission = Permission::findById($id);
        $permission->delete();
        return redirect('admin/permissions')->with('status_delete', 'Xóa thành công');
    }
}
