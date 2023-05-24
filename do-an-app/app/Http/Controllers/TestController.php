<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Exception;

class TestController extends Controller
{
    public function test() {
        try {
            $customerID = Auth::guard('customer')->user()->customer_id;
            $salonID = 'SL_0000000003';
            $appointment = Appointment::query()
                ->where('salon_id', $salonID)
                ->where('customer_id', $customerID)
                ->first();
            if($appointment) {
                return true;
            }
            return false;

        } catch (\Exception $e) {
            return false;
        }



    }
    public function testMail() {
        $name = 'test name for email';
        Mail::send('emails.test', compact('name'), function ($email) {
            $email->to('ngovanthuan07@gmail.com', 'Oke');
        });
    }
}
