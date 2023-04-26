<?php

namespace App\Repositories;

use App\Helpers\ImageHelper;
use App\Models\Employee;
use App\Models\EmployeeWorkSchedule;
use App\Models\Salon;
use App\Models\Service;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeWorkScheduleRepository
{
    public function getByWorkDateAndEmployID($wordDate, $salonID) {
        return DB::table('employeeworkingschedule as wls')
            ->select('wls.*')
            ->join('employees as e', 'wls.employee_id', '=', 'e.employee_id')
            ->where('wls.work_date', '=', $wordDate)
            ->where('e.salon_id', '=', $salonID)
            ->where('e.status', '=', 'ON')
            ->get();
    }

    public function deleteByIds($ids) {
        EmployeeWorkSchedule::whereIn('ews_id', $ids)->delete();
    }

    public function saveAll($data) {
        foreach ($data as $item) {
            if ($item['ews_id'] !== null) {
                $esw = EmployeeWorkSchedule::query()
                    ->where('ews_id', $item['ews_id'])
                    ->first();
                $esw->start_time = $item['start_time'];
                $esw->end_time = $item['end_time'];
                $esw->update();
            } else {
                EmployeeWorkSchedule::create($item);
            }
        }

    }
}
