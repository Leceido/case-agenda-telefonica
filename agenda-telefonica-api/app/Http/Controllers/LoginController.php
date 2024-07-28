<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email' => 'Email invalido',
            'password' => 'Senha invalida'
        ]);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'data' => [
                'token' => $token,
                'token_type' => 'bearer'
            ],
            'user' => auth()->user()
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json([
           'message' => 'Logout realizado com sucesso!'
        ]);
    }

    public function register(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
                'name' => ['required'],
            ], [
                'email' => 'Email invalido',
                'password' => 'Senha invalida',
                'name' => 'Nome invalido'
            ]);

            User::create($credentials);

            return response()->json([
                'message' => 'Cadastro Realizado com sucesso!'
            ], 201);
        }catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 403);
        }



    }
}
