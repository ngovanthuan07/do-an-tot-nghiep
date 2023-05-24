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

    public static function formatDD_MM_YY_Display($dateString)
    {
        $date = Carbon::parse($dateString);
        return $date->format('d-m-Y ⏰H:i:s');
    }

    public static function formatDD_MM_YY_Default($dateString)
    {
        $date = Carbon::parse($dateString);
        return $date->format('d-m-Y');
    }

    public static function getToday()
    {
        return \Carbon\Carbon::now();
    }

    public static function checkToday($dateString)
    {
        $currentDate = \Carbon\Carbon::now();
        $date = Carbon::parse($dateString);
        return $date->isSameDay($currentDate);
    }
}
