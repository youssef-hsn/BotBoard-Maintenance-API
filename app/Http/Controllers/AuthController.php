<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Application;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'app_id' => 'required|exists:application,app_id',
            'app_secret' => 'required',
        ]);

        $application = Application::where('app_id', $validated['app_id'])
                                  ->where('app_secret', $validated['app_secret'])
                                  ->first();

        if (!$application) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        try {
            $token = JWTAuth::fromUser($application);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        return response()->json([
            'token' => $token
        ]);
    }

    public function me()
    {
        return response()->json(JWTAuth::user());
    }
    
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Successfully logged out']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout'], 500);
        }
    }
}

