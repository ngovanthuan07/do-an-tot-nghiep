<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.customer.login');
    }

    public function me()
    {
        if(Auth::guard('customer')->check()) {
            return Auth::guard('customer')->user();
        } else {
            return null;
        }

    }

    public function logout() {
        Auth::guard('customer')->logout();

        return redirect('/');
    }
}
