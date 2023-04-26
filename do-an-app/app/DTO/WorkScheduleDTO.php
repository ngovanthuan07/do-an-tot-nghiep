<?php

namespace App\DTO;

class WorkScheduleDTO
{
    public static function convertArrayToHours($timeSlots,$isSelects) {
        $hours = [];
        for($i = 0; $i < count($timeSlots); $i++) {
            $hours[] = [
              'time_slot' => $timeSlots[$i],
              'is_selected' => $isSelects[$i],
            ];
        }

        return $hours;
    }
}
