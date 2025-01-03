<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
        ]);

        $credentials = Application::create($validated); // Returns app_id and app_secret

        return response()->json($credentials);
    }

    public function update(Request $request)
    {
        $application = auth()->user();

        $validated = $request->validate([
            'new_username' => 'required|string',
        ]);

        $application->update($validated);

        return response()->json(['message' => 'Application Username updated']);
    }

    public function destroy(Application $application)
    {
        $application->delete();

        return response()->json(['message' => 'Application deleted']);
    }
}
