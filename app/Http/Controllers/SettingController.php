<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $response = (object)[];

        try {
            $settings = Setting::all();
            $grouped = $settings->groupBy('group')->map(function ($items) {
                return $items->map(function ($s) {
                    $item = [
                        'id'    => $s->id,
                        'key'   => $s->key,
                        'value' => $s->value,
                        'type'  => $s->type,
                    ];
                    if (in_array($s->key, ['logo', 'favicon']) && $s->value) {
                        $item['url'] = Storage::disk('public')->url($s->value);
                    }
                    return $item;
                })->values();
            });

            $response->success = true;
            $response->message = 'Settings fetched successfully';
            $response->data = $grouped;
            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 500;
        }

        return response()->json($response, $httpCode ?? 500);
    }

    public function update(Request $request)
    {
        $response = (object)[];

        try {
            $data = $request->validate([
                'settings' => 'required|array',
            ]);

            $imageKeys = ['logo', 'favicon'];

            foreach ($data['settings'] as $key => $value) {
                $setting = Setting::where('key', $key)->first();
                if (!$setting) continue;

                if (in_array($key, $imageKeys) && $request->hasFile("settings.$key")) {
                    $file = $request->file("settings.$key");
                    if ($setting->value) {
                        Storage::disk('public')->delete($setting->value);
                    }
                    $path = $file->store("settings/$key", 'public');
                    $setting->update(['value' => $path]);
                } elseif (!in_array($key, $imageKeys)) {
                    $setting->update(['value' => $value]);
                }
            }

            $response->success = true;
            $response->message = 'Settings updated successfully';
            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'Validation failed';
            $response->errors = $e->getMessage();
            $httpCode = 422;
        }

        return response()->json($response, $httpCode ?? 500);
    }
}
