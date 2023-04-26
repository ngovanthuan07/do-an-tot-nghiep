<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;


class MyIDHelper
{
    public static function hasDuplicate($ids) {
        return count($ids) > count(array_unique($ids));
    }
}
