<?php

namespace App\Http\Controllers;

use App\DataTables\PermissionsDataTable;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
//    public function index() {
//        $permissions = Permission::all();
//        return view('role-permission.permission.index', [
//            'permissions' => $permissions
//        ]);
//    }
    public function index(PermissionsDataTable $dataTable) {
        return $dataTable->render('role-permission.permission.index');
    }
    public function create() {
        return view('role-permission.permission.create');
    }
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:permissions,name|string',
        ]);
        Permission::create([
            'name' => $request->name,
        ]);

        return redirect('permissions')->with('status', 'Tạo mới thành công');
    }
    public function show($id) {

    }
    public function edit($id) {
        $permission = Permission::find($id);

        return view('role-permission.permission.edit', [
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
        ]);
        return redirect('permissions')->with('status', 'Cập nhật thành công');
    }
    public function destroy($id) {
        $permission = Permission::findById($id);
        $permission->delete();
        return redirect('permissions')->with('status_delete', 'Xóa thành công');
    }
}
