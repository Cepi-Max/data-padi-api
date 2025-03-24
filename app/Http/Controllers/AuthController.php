<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //
    function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        // Cek pakai Auth::attempt
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            /** @var \App\Models\User $user */
            if ($request->expectsJson()) {
                $token = $user->createToken('mobile_token')->plainTextToken;
                return response()->json([
                    'message' => 'Login berhasil',
                    'role' => $user->role,
                    'token' => $token,
                    'user' => $user
                ]);
            }

            // Kalau dari WEB (redirect by role)
            switch ($user->role) {
                case 'superadmin':
                    return redirect('admin/superadmin');
                case 'admin':
                    return redirect('admin/admin');
                case 'petani':
                    return redirect('admin/petani');
                case 'pembeli':
                    return redirect('admin/pembeli');
                default:
                    Auth::logout(); // Role nggak dikenal, logout
                    return redirect('/login')->withErrors('Role tidak dikenali');
            }
        } else {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Email atau password salah'], 401);
            }

            return redirect('/login')
                ->withErrors('Email atau password salah')
                ->withInput();
        }
    }


    function logout()
    {
        Auth::logout();
        return redirect()->route('login.show');
    }
}
