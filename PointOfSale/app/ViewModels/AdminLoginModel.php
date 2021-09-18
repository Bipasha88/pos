<?php
namespace App\ViewModels;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AdminService\IAdminService;

class AdminLoginModel
{

    public function isAuthenticated(Request $request)
    {
        $email = $request->email;
        $pass = $request->password;
        $remember = $request->input('remember');

        if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $pass], $remember))
        {
            return true;
        }

        return false;
    }
}