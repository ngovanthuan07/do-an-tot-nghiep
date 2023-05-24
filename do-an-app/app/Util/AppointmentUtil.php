<?php

namespace App\Util;

use App\Models\Appointment;

class AppointmentUtil
{
    public static function convertStatusToNotification($status)
    {
        if($status == Appointment::$SCHEDULED) {
            return 'Chờ xử lý';
        } else {
            if($status == Appointment::$CONFIRMED) {
                return 'Đã xác nhận';
            } else {
                if($status == Appointment::$CANCEL) {
                    return 'Đã hủy';
                } else {
                    if($status == Appointment::$COMPLETED) {
                        return 'Đã hoàn thành';
                    }
                }
            }
        }
        return 'Lỗi';
    }
}
