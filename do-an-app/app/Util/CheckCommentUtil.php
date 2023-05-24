<?php

namespace App\Util;

use App\Models\Appointment;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CheckCommentUtil
{
    public static function checkCommentUtil($salonID) {
        try {
            $customerID = Auth::guard('customer')->user()->customer_id;
            $appointment = Appointment::query()
                ->where('salon_id', $salonID)
                ->where('customer_id', $customerID)
                ->where('status', Appointment::$COMPLETED)
                ->first();
            if($appointment) {
                return true;
            }
            return false;

        } catch (\Exception $e) {
            return false;
        }
    }
}
