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
        $app = auth()->userOrfail();

        $validated = $request->validate([
            'username' => 'required|string',
        ]);

        $app->username = $validated['username'];
        $app->save();

        return response()->json(['message' => 'Application Username updated']);
    }

    public function regenerateSecret(Request $request)
    {
        $app = auth()->userOrfail();

        $app->app_secret = bin2hex(random_bytes(16));
        $app->save();

        return response()->json(['new_secret' => $application->app_secret]);
    }

    public function destroy(Request $request)
    {
        $app = auth()->userOrfail();

        $app->delete();

        return response()->json(['message' => 'Application deleted']);
    }
}
