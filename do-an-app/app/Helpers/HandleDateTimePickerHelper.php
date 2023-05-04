<?php

namespace App\Helpers;


use Carbon\Carbon;

class HandleDateTimePickerHelper
{
    public static function isDateBeforeToday($dateString)
    {
//        $date = Carbon::createFromFormat('Y-m-d', $dateString);
//        $today = Carbon::today();
//
//        return $date->greaterThan($today);
    }

    public static function formatDate($dateString)
    {
        $date = Carbon::parse($dateString);
        return $date->format('Y-m-d');
    }

    public static function checkToday($dateString)
    {
        $currentDate = \Carbon\Carbon::now();
        $date = Carbon::parse($dateString);
        return $date->isSameDay($currentDate);
    }
}
