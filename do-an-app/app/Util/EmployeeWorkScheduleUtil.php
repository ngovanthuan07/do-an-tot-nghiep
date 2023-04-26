<?php

namespace App\Util;

use App\Models\EmployeeWorkSchedule;

class EmployeeWorkScheduleUtil
{
    public static function EmployeeWorkScheduleUtilValidation($employeeWorkingSchedule) {
        try {
//            $filterEWS_ID = [];
            foreach ($employeeWorkingSchedule as $index => $ews) {
                $row = $index + 1;
                $start_time = strtotime($ews['start_time']);
                $end_time = strtotime($ews['end_time']);
                $diff_hours = round(abs($end_time - $start_time) / 3600, 2);
                if($start_time >= $end_time) {
                    return [
                        'check' => false,
                        'message' => "Cột số $row thời gian thời gian kết thúc > thới gian bắt đầu",
                    ];
                }
                if($start_time < strtotime("06:59")) {
                    return [
                        'check' => false,
                        'message' => "Cột số $row thời gian bắt đầu phải > 7:00",
                    ];
                }
                if($end_time > strtotime("22:00")) {
                    return [
                        'check' => false,
                        'message' => "Cột số $row thời gian kêt thúc phải < 22:00",
                    ];
                }

                if($diff_hours > 8) {
                    return [
                        'check' => false,
                        'message' => "Thời gian làm việc $row tối đa 8 tiếng",
                    ];
                }


//                if($ews['ews_id'] == null) {
//                    $filterEWS_ID[] = $ews;
//                }
            }
//            if(count($filterEWS_ID) > 0) {
//                foreach ($filterEWS_ID as $filter) {
//                    $check = EmployeeWorkSchedule::query()
//                        ->where('work_date', $filter['work_date'])
//                        ->where('employee_id', $filter['employee_id'])->first();
//                    if($check !== null) {
//                        return [
//                            'check' => false,
//                            'message' => 'Nhân viên đã được thêm lịch làm việc. Xin vui lòng kiểm tra lại',
//                        ];
//                    }
//                }
//            }
            return [
                'check' => true,
            ];
        } catch (\Exception $exception) {
            return [
                'check' => false,
                'message' => 'Lỗi hệ thống',
            ];
        }
    }

}
