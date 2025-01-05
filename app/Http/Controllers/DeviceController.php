<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    public function store(Request $request)
    {
        $app = auth()->userOrfail();

        $validated = $request->validate([
            'description' => 'string|max:255',
        ]);

        $device = Device::create([
            'description' => $validated['description']??'No Description',
            'mother_app' => $app->app_id,
        ]);

        return response()->json($device);
    }

    public function update(Request $request, $deviceID)
    {
        $app = auth()->userOrfail();

        $device = Device::find($deviceID);

        if ($device->mother->app_id != $app->app_id) {
            throw new Exception('Unauthorized');
        }

        $validated = $request->validate([
            'description' => 'string|max:255',
        ]);

        $device->description = $validated['description']??'No Description';
        $device->save();

        return response()->json($device);
    }
}
