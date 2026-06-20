<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterEmployeeRequest; 
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    // LOGIN
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            return match ($user->role) {
                'supplier' => redirect()->route('supplier.dashboard'),
                'procurement' => redirect()->route('procurement.dashboard'),
                'finance' => redirect()->route('finance.dashboard'),
                'operations' => redirect()->route('operations.dashboard'),
                default => redirect('/login'),
            };
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // REGISTER
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'supplier',
        ]);

        return redirect()->route('login')
            ->with('success', 'Account created successfully. Please login.');
    }
    public function showEmployeeRegister()
    {
        return view('auth.employee-register');
    }

    public function registerEmployee(RegisterEmployeeRequest $request)
    {
        $data = $request->validated();

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        return redirect()->route('login')
            ->with('success', 'Employee account created successfully.');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
