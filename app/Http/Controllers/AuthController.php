<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('auth.admin_login');
    }

    // ฟังก์ชันจัดการการ Login
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('questionsIndex')->with('success', 'เข้าสู่ระบบสำเร็จ!');
        }

        return back()->withErrors([
            'name' => 'ข้อมูลการเข้าสู่ระบบไม่ถูกต้อง',
        ]);
    }

    // ฟังก์ชัน Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('usersIndex');
    }
}
