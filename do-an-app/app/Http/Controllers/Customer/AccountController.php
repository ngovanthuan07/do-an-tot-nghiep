<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\UpdateProfileRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function profile() {
        $customer = Auth::guard('customer')->user();
        return view('components.customer.account.profile', compact('customer'));
    }

    public function updateProfile(UpdateProfileRequest $request) {
        $customer_id = Auth::guard('customer')->user()->customer_id;
        $customer = Customer::where('customer_id', $customer_id)->first();
        $customer->fullname = $request->input('fullname');
        $customer->phone = $request->input('phone');
        $customer->gender = $request->input('gender');
        $customer->dob = $request->input('dob');
        $customer->update();
        return response()->json([
            'success' => true
        ]);
    }
}
