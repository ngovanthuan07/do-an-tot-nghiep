<?php

namespace App\DTO;

use App\Repositories\CategoryServiceRepository;
use App\Repositories\LocationRepository;
use App\Repositories\SalonRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Support\Facades\DB;

class OutstandingDTO
{
    public static function convertHome($salons) {
        $locationRep = new LocationRepository();
        foreach ($salons as $salon) {
            if($salon->images != null && $salon->images != '') {
                $salon->images = [json_decode($salon->images)[0]->src];
            } else {
                $salon->images = ["empty.jpg"];
            }
            $resultStar = DB::select('CALL GetTotalStarBySalonID(?)', [$salon->salon_id]);
            $salon->stars = $resultStar[0]->average_stars ?? 0;
            $salon->location = $locationRep
                ->getAddress($salon->ward_code);
        }
        return $salons;
    }
}
