<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function logo(Request $request)
    {
        $setting = Setting::where('type', 'logo')->first();
        // dd(json_decode($setting->description, true)['logo']);
        if ($request->ajax()) {
            // save file
            $fileName = "";
            if ($request->hasFile('file')) {
                $fileName=uploadFile($request->file,'images/setting/logo');
                $data = [
                    'watermark_width' => $request->watermark_width,
                    'watermark_height' => $request->watermark_height,
                    'watermark_position' => $request->watermark_position,
                    'logo' => 'storage/'.$fileName
                ];
            } else {
                if ($setting) {
                    $old = $setting->description;
                    $data = [
                        'watermark_width' => $request->watermark_width,
                        'watermark_height' => $request->watermark_height,
                        'watermark_position' => $request->watermark_position,
                        'logo' => $old['logo']
                    ];
                } else {
                    $data = [
                        'watermark_width' => $request->watermark_width,
                        'watermark_height' => $request->watermark_height,
                        'watermark_position' => $request->watermark_position,
                        'logo' => 'storage/images/setting/logo/' . $fileName
                    ];
                }
            }

            $setting = Setting::updateOrCreate(['type' => 'logo'], [
                'type' => 'logo',
                'description' => $data
            ]);

            if ($setting->wasRecentlyCreated) {
                return response()->json(['success' => true, 'message' => 'Setting added successfully', 'data' => config('services.cms_link').'/'.$data['logo']]);
            } else {
                return response()->json(['success' => true, 'message' => 'Setting updated successfully', 'data' => config('services.cms_link').'/'.$data['logo']]);
            }
        }

        if ($setting) {
            $type = $setting->type;
            $data = $setting->description;
        } else {
            $data = [
                'watermark_width' => '',
                'watermark_height' => '',
                'watermark_position' => '',
                'logo' => ''
            ];
            $type = "";
        }
        return view('admin.setting', ['type' => $type, 'data' => $data]);
    }
}
