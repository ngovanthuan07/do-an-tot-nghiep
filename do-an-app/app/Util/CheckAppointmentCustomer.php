<?php

namespace App\Util;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckAppointmentCustomer
{
    public static function isCheck($data) {
        try {
            $dateWorking = $data['date'];
            $timeSlot = $data['time_slot'];
            $salonId = $data['salon_id'];
            $employeeId = $data['employee']->employee_id;
            $result = DB::select('CALL CustomerCheckAppointment(?, ?, ?, ?, ?, @is_check)', [$dateWorking, $timeSlot, $salonId, $employeeId]);
            $is_booking = DB::select('SELECT @is_check as is_check')[0]->is_check;
            return boolval($is_booking);
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function isCheckAppointment() {
        try {
            $customerId = Auth::guard('customer')->user()->customer_id;
            $result = DB::select('CALL CheckCustomerAppointmentTooMuch(?)', [$customerId]);
            return $result[0]->myCount ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }
}
