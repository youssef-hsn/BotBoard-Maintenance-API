<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;
use App\Models\Device;

class RoutineController extends Controller
{
    public function all(Request $request)
    {
        $app = auth()->userOrfail();
        $devices = $app->devices;

        $routines = Routine::whereHas('device', function ($query) use ($app) {
            $query->where('mother_app', $app->app_id);
        })->get();
        
        return response()->json($routines);
    }

    public function store(Request $request, $deviceID)
    {
        $app = auth()->userOrfail();

        $device = Device::find($deviceID);

        if ($device->mother->app_id != $app->app_id) {
            throw new Exception('Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:32',
            'description' => 'required|string|max:255',
            'frequency' => 'required|int',
        ]);

        $routine = Routine::create([
            'device_id' => $deviceID,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'frequency' => $validated['frequency'],
        ]);

        return response()->json($routine);
    }

    public function show(Request $request, $id)
    {
        $routine = Routine::find($id);
        return response()->json($routine);
    }

    public function update(Request $request, $routineID)
    {
        $app = auth()->userOrfail();

        $routine = Routine::find($routineID);

        if ($routine->device->mother->app_id != $app->app_id) {
            throw new Exception('Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'string|max:32',
            'description' => 'string|max:255',
            'frequency' => 'int',
        ]);

        $routine->title = $validated['title']??$routine->title;
        $routine->description = $validated['description']??$routine->description;
        $routine->frequency = $validated['frequency']??$routine->frequency;
        

        $routine->save();
        return response()->json($routine);
    }
    public function complete(Request $request, $routineID)
    {
        $app = auth()->userOrfail();

        $routine = Routine::find($routineID);

        if ($routine->device->mother->app_id != $app->app_id) {
            throw new Exception('Unauthorized');
        }

        $routine->last_done = now();
        $routine->save();
        return response()->json($routine);
    }
}
