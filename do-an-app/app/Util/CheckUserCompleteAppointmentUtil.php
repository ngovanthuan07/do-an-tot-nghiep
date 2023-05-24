<?php

namespace App\Util;

use App\Repositories\AppointmentRepository;
use Illuminate\Support\Facades\Auth;

class CheckUserCompleteAppointmentUtil
{
    public static function isCheck($salonId, $status) {
        $repository  = new AppointmentRepository();
        $customerId = Auth::guard('customer')->user()->customer_id;
        return $repository
            ->checkSalonAppointmentStatus($salonId, $customerId, $status);
    }
}
