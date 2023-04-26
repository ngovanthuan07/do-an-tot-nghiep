<?php

namespace App\Repositories;

use App\Models\Salon;
use App\Models\WorkSchedule;
use http\Env\Request;
use Illuminate\Support\Facades\Hash;

class WorkScheduleRepository
{
    public function save($workDate, $hours, $salonId) {
        $workSchedule = new  WorkSchedule();
        $workSchedule->work_date = $workDate;
        $workSchedule->hours = $hours;
        $workSchedule->salon_id = $salonId;
        $workSchedule->save();

        return WorkSchedule::query()
            ->where('work_date', $workDate)
            ->where('salon_id', $salonId)
            ->first();
    }

    public function update($workDate, $hours, $workingScheduleID) {
        $workSchedule = WorkSchedule::query()
            ->where('ws_id', $workingScheduleID)
            ->first();
        $workSchedule->work_date = $workDate;
        $workSchedule->hours = $hours;

        $workSchedule->update();

        return $workSchedule;
    }

    public function getWorkScheduleByDateAndSalonID($workDate, $salonId) {
        return WorkSchedule::query()
            ->where('work_date', $workDate)
            ->where('salon_id', $salonId)
            ->first();
    }
}
