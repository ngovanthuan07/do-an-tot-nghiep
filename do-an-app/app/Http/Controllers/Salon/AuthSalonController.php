<?php

namespace App\Http\Controllers\Salon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Salon\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthSalonController extends Controller
{
    public function displaySalonLogin(Request $request)
    {
        return view('auth.salon.login');
    }

    public function salonLogin(LoginRequest $login)
    {
        $credentials =  $login->validated();

        if (!Auth::guard('salon')->attempt($credentials)) {
            return redirect()
                ->route('salon.displaySalonLogin')
                ->with('alertError', 'Thông tin đăng nhập không chính xác');
        }

        return redirect()
            ->route('salon.dashboard');
    }

    public function logout(Request $request) {

        Auth::guard('salon')->logout();

        return redirect()->route('salon.displaySalonLogin');
    }
}
