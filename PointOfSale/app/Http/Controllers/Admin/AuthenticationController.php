<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function loginpost(Request $request)
    {
        $adminLoginModel = resolve('App\ViewModels\AdminLoginModel');

        if ($adminLoginModel->isAuthenticated($request)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return redirect()->back()
            ->withErrors(['invalid' => 'This email or password is wrong.'])
            ->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
