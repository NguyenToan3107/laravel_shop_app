<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:create-role')->only('store', 'create');
        $this->middleware('permission:edit-role')->only('update', 'edit', 'addPermissionToRole', 'givePermissionToRole');
        $this->middleware('permission:delete-role')->only('destroy');
        $this->middleware('permission:view-role')->only('index');
    }

    public function index() {
        $roles = Role::all();
        return view('admin.role-permission.role.index', [
            'roles' => $roles
        ]);
    }
    public function create() {
        return view('admin.role-permission.role.create');
    }
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:roles,name|string',
        ]);
        role::create([
            'name' => $request->name,
        ]);

        return redirect('admin/roles')->with('status', 'Tạo mới thành công');
    }
    public function edit($id) {
        $role = role::find($id);

        return view('admin.role-permission.role.edit', [
            'role' => $role
        ]);
    }
    public function update(Request $request, $id) {
        $role = role::find($id);
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name,'.$role->id
            ],
        ]);
        role::where('id', $id)->update([
            'name' => $request->name,
        ]);
        return redirect('admin/roles')->with('status', 'Cập nhật thành công');
    }
    public function destroy($id) {
        $role = role::findById($id);
        $role->delete();
        return redirect('admin/roles')->with('status_delete', 'Xóa thành công');
    }

    public function addPermissionToRole($roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissions = Permission::all();
        $rolePermissions = DB::table("role_has_permissions")->where('role_id', $roleId)
                                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                                ->all();

        return view('admin.role-permission.role.add-permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function givePermissionToRole(Request $request ,$roleId)
    {
       $request->validate([
           'permission' => 'required'
       ]);
       $role = Role::findOrFail($roleId);
       $role->syncPermissions($request->input('permission'));

       return redirect()->back()->with('status', 'Thêm quyền vào vai trò thành công');
    }
}
