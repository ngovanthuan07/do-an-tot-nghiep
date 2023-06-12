<?php

namespace App\Util;

class cancelAppointment
{
    public static function check($timeSlot, $date) {
        $currentDate = new \DateTime();

        $oneHourBefore = $currentDate->modify('-1 hour');

        $selectedDate = \DateTime::createFromFormat('Y-m-d', $date);

        if ($selectedDate < $oneHourBefore && $timeSlot < $currentDate->format('H:i:s')) {
            return true;
        } else {
            return false;
        }
    }
}
