<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    const USERS_PATH = '/admin/users';

    public function __construct()
    {
        $this->middleware('permission:create-user')->only('store', 'create');
        $this->middleware('permission:edit-user')->only('update', 'edit');
        $this->middleware('permission:delete-user')->only('destroy', 'softDelete');
        $this->middleware('permission:view-user')->only('index');
    }
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('admin.users.index');
    }

    public function create() {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.users.create', [
            'roles' => $roles
        ]);
    }
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:users|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'age' => 'required|integer|min:0|max:100',
            'address' => 'required',
            'phoneNumber' => 'required',
            'roles' => 'required'
//            'image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ]);

        if($request->filled('filepath')) {
            $image_path = $request->input('filepath');
            $image_path = explode('http://localhost:8000', $image_path)[1];
        }else {
            $image_path = '/storage/photos/users/default_user.jpg';
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'age' => $request->input('age'),
            'address' => $request->input('address'),
            'phoneNumber' => $request->input('phoneNumber'),
            'image_path' => $image_path,
            'status' => 1,
//            'role' => strtolower($request->input('role')),
        ]);

        $user->syncRoles($request->roles);
        return redirect(UserController::USERS_PATH)->with('success', 'Tạo người dùng thành công');
    }
    public function show($id) {
        $user = $this->userService->getById($id);
        return view('admin.users.show', [
            'user' => $user
        ]);
    }
    public function edit($id) {

        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();


        $userRoles = $user->roles->pluck('name', 'name')->all();
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'email' => 'email',
        ]);

        $user = User::find($id);

        if($request->filled('filepath')) {
            $image_path = $request->input('filepath');
            $image_path = explode('http://localhost:8000', $image_path)[1];
        }else {
            $image_path = $user->image_path;
        }

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
//            'password' => bcrypt($request->input('password')),
            'age' => $request->input('age'),
            'address' => $request->input('address'),
            'phoneNumber' => $request->input('phoneNumber'),
            'image_path' => $image_path,
            'status' => $request->input('status'),
            'updated_at' => now(),
            'deleted_at' => null,
        ]);

        $user->syncRoles($request->roles);

        return redirect(UserController::USERS_PATH)->with('success', 'Cập nhật thành công');
    }
    public function destroy($id, Request $request) {

        if($request->filled('id')) {
            DB::table('users')->where('id', $id)->delete();
        }
        $model = User::query()
            ->select(['id', 'image_path', 'name', 'email', 'phoneNumber', 'status', 'address', 'age', 'created_at', 'updated_at'])
            ->where('deleted_at','<>', 'null')
            ->where('status', 4);

        return DataTables::of($model)
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
            ->addColumn('action', function ($user) use ($request) {
                if ($request->filled('status')) {
                    if ($user->status == 4) {
                        return view('admin.users.action_delete', ['user' => $user]);
                    }
                    return view('admin.users.action', ['user' => $user]);
                }else {
                    return view('admin.users.action', ['user' => $user]);
                }
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
            ->make();
    }

    // soft user
    public function softDelete(Request $request)
    {
        $model = User::query()
            ->select(['id', 'image_path', 'name', 'email', 'phoneNumber', 'status', 'address', 'age', 'created_at', 'updated_at'])
            ->whereNull('deleted_at')
            ->where('status', '<>', 4);
        if ($request->filled('user_id')) {
            User::find($request->user_id)->update([
                'deleted_at' => now(),
                'status' => 4
            ]);
        }

        return DataTables::of($model)
            ->editColumn('status', function ($user) {
                $statusMessages = [
                    1 => 'Hoạt động',
                    2 => 'Không hoạt động',
                    3 => 'Đợi',
                    4 => 'Xóa mềm'
                ];
                return $statusMessages[$user->status];
            })
            ->addColumn('action', function ($user) use ($request) {
                if ($request->filled('status')) {
                    if ($user->status == 4) {
                        return view('admin.users.action_delete', ['user' => $user]);
                    }
                    return view('admin.users.action', ['user' => $user]);
                }else {
                    return view('admin.users.action', ['user' => $user]);
                }
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
            ->make();
    }
}
