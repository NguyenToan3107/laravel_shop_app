<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SettingController extends Controller
{
    public function index()
    {
        $sys_logo = config('app.sys_logo');
        $sys_logo_mobile = config('app.sys_logo_mobile');
        $sys_favicon = config('app.sys_favicon');
        return view('admin.settings.index', [
            'sys_logo' => $sys_logo,
            'sys_logo_mobile' => $sys_logo_mobile,
            'sys_favicon' => $sys_favicon,
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
        if ($request->filled('filepath_logo')) {
            $image_logo = $request->input('filepath_logo');
            $image_logo = explode('http://localhost:8000', $image_logo)[1];
        } else {
            $image_logo = \config('app.sys_logo');
        }
        if ($request->filled('filepath_logo_mobile')) {
            $image_logo_mobile = $request->input('filepath_logo_mobile');
            $image_logo_mobile = explode('http://localhost:8000', $image_logo_mobile)[1];
        } else {
            $image_logo_mobile = \config('app.sys_logo_mobile');
        }

        Setting::updateOrCreate(['name' => 'sys_logo'], ['val' => $image_logo]);
        Setting::updateOrCreate(['name' => 'sys_logo_mobile'], ['val' => $image_logo_mobile]);

        // Update the config
        Config::set('app.sys_logo', $image_logo);
        Config::set('app.sys_logo_mobile', $image_logo_mobile);

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
