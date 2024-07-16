<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\DataTables;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $model = Setting::query()->select('id', 'key', 'value', 'description', 'status');

            if ($request->filled('key')) {
                $model = $model->where('key', 'like', '%' . $request->key . '%');
            }
            if ($request->filled('value')) {
                $model = $model->where('value', 'like', '%' . $request->value . '%');
            }
            if ($request->filled('status')) {
                $model = $model->withTrashed()->where('status', $request->status);
            } else {
                $model = $model->where('status', '<>', 2);
            }


            return DataTables::of($model)
                ->addColumn('action', function ($setting) {
                    return view('admin.settings.action', [
                        'setting' => $setting,
                    ]);
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" name="ids_setting" class="checkbox_ids_setting" value="' . $row->id . '"/>';
                })
                ->editColumn('status', function ($setting) {
                    $message = [
                        1 => 'Active',
                        2 => 'Inactive'
                    ];
                    return $message[$setting->status];
                })
                ->rawColumns(['action', 'checkbox'])
                ->setRowId('id')
                ->make(true);
        }

        $adminLogo = config('app.admin_logo');
        $frontendLogo = config('app.frontend_logo');
        return view('admin.settings.index', [
            'adminLogo' => $adminLogo,
            'frontendLogo' => $frontendLogo,
        ]);
    }

    public function store()
    {
        request()->validate([
            'key' => 'required|unique:settings,key',
            'value' => 'required',
        ]);
        try {
            Setting::create([
                'key' => request()->get('key'),
                'value' => request()->get('value'),
                'status' => 1

            ]);
        } catch (\Exception $e) {

            return redirect()->back()->with('delete', 'Tạo mới thất bại.');
        }

        return redirect()->back()->with('success', 'Tạo mới thành công.');

    }

    public function updateLogo(Request $request)
    {
        if ($request->filled('filepath_admin')) {
            $image_path_admin = $request->input('filepath_admin');
            $image_path_admin = explode('http://localhost:8000', $image_path_admin)[1];
        } else {
            $image_path_admin = '/storage/photos/2/logo/logo-vizion.jpg';
        }
        if ($request->filled('filepath_frontend')) {
            $image_path_front = $request->input('filepath_frontend');
            $image_path_front = explode('http://localhost:8000', $image_path_front)[1];
        } else {
            $image_path_front = '/storage/photos/2/logo/logo-vizion.jpg';
        }

        Setting::updateOrCreate(['key' => 'admin_logo'], ['value' => $image_path_admin]);
        Setting::updateOrCreate(['key' => 'frontend_logo'], ['value' => $image_path_front]);

        // Update the config
        Config::set('app.admin_logo', $image_path_admin);
        Config::set('app.frontend_logo', $image_path_front);

        return redirect('/admin/settings')->with('success', 'Cập nhật thành công.');
    }

    public function edit($id)
    {
        $setting = Setting::withTrashed()->where('id', $id)
            ->select('id', 'key', 'value', 'status', 'description')
            ->first();

        return view('admin.settings.edit', [
            'setting' => $setting,
        ]);
    }

    public function update($id, Request $request) {
        $setting = Setting::where('id', $id)->withTrashed()->select('id', 'key', 'value', 'status', 'description', 'deleted_at')->first();
        $setting->update([
            'key' => $request->get('key'),
            'value' => $request->get('value'),
            'deleted_at' => null,
            'description' => $request->get('description'),
            'status' => $request->input('status')
        ]);

        return redirect('/admin/settings')->with('success', 'Cập nhật thành công.');
    }

    public function destroy($id)
    {
        $array_id = explode(',', $id);
        $settings = Setting::withTrashed()->whereIn('id', $array_id)->get();
        foreach ($settings as $setting) {
            if (is_null($setting->deleted_at)) {
                $setting->update([
                    'status' => 2
                ]);
                $setting->delete();
            } else {
                $setting->forceDelete();
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Thành công'
        ]);
    }
}
