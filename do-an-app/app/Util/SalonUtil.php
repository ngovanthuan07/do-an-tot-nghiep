<?php

namespace App\Util;

use App\Repositories\LocationRepository;
use App\Repositories\SalonRepository;

class SalonUtil
{
    public static function getById($salon_id) {
        $salon = new SalonRepository();
        $location = new LocationRepository();
        $newSalon = $salon->getSalonById($salon_id);
        $newSalon['location'] = $location->getAddress($newSalon->ward_code);
        return $newSalon;
    }
}
