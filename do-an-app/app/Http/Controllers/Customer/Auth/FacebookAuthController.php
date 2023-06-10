<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookAuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->stateless()->redirect()->getTargetUrl();
    }

    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('facebook')->stateless()->user();
        } catch (\Exception $e) {
            return view('auth.alert.error');
        }
        // check if they're an existing user
        $existingUser = Customer::query()
            ->where('email', $user->email)
            ->where('type_login', Customer::$FACEBOOK)
            ->first();
        if($existingUser){
            Auth::guard('customer')->login($existingUser);
            $existingUser->token = $user->token;
            $existingUser->image = $user->avatar;
            $existingUser->update();
            Auth::guard('customer')->login($existingUser);
        } else {
            // create a new user
            $newCustomer                  = new Customer();
            $newCustomer->fullname        = $user->name;
            $newCustomer->email           = $user->email;
            $newCustomer->token           = $user->token;
            $newCustomer->image           = $user->avatar;
            $newCustomer->type_login      = Customer::$FACEBOOK;
            $newCustomer->save();
            Auth::guard('customer')
                ->login(Customer::query()
                    ->where('email', $user->email)
                    ->where('type_login', Customer::$FACEBOOK)
                    ->first());
        }
        return view('auth.alert.success');
    }
}
