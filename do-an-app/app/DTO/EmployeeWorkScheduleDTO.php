<?php

namespace App\DTO;

class EmployeeWorkScheduleDTO
{
    public static function convertArrayToEmployeeWorkSchedule($employees, $startTimes, $endTimes, $ews_ids, $workDate) {
        $employeeWorkingSchedule = [];
        for($i = 0; $i < count($employees); $i++) {
            $employeeWorkingSchedule[] = [
              'ews_id' => $ews_ids[$i],
              'start_time' => $startTimes[$i],
              'end_time' => $endTimes[$i],
              'employee_id' => $employees[$i],
              'work_date' => $workDate
            ];
        }

        return $employeeWorkingSchedule;
    }
}
