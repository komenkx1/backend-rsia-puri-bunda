<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }
        Log::create([
            'action' => 'LOGIN',
            'user_id' => Auth::user()->id,
            'description' => 'Login To System',
        ]);
        $request->session()->regenerate();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Log::create([
            'action' => 'LOG OUT',
            'user_id' => Auth::user()->id,
            'description' => 'Log Out From System',
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'data' => $request->user(),
        ]);
    }
}
