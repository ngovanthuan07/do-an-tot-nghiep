<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAdminController extends Controller
{
    public function displayAdminLogin(Request $request)
    {
        return view('auth.admin.login');
    }
    public function adminLogin(LoginRequest $login)
    {
        $credentials =  $login->validated();

        if (!Auth::guard('admin')->attempt($credentials)) {
            return redirect()
                ->route('admin.admin.displayAdminLogin')
                ->with('alertError', 'Thông tin đăng nhập không chính xác');
        }

        return redirect()
            ->route('admin.dashboard');
    }

    public function logout(Request $request) {

        Auth::guard('admin')->logout();

        return redirect()->route('admin.displayAdminLogin');
    }
}
