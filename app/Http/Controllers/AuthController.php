<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return response()->json(['message' => 'Registo concluído', 'user' => $user]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($data, true)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        return response()->json(['message' => 'Login com sucesso', 'user' => Auth::user()]);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return response()->json(['message' => 'Sessão terminada']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
