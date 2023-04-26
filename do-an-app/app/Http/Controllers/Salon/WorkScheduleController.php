<?php

namespace App\Http\Controllers\Salon;

use App\DTO\WorkScheduleDTO;
use App\Http\Controllers\Controller;
use App\Repositories\WorkScheduleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkScheduleController extends Controller
{
    /**
     * @var WorkScheduleRepository
     */
    private $workScheduleRepository;

    public function __construct(WorkScheduleRepository $workScheduleRepository)
    {
        $this->workScheduleRepository = $workScheduleRepository;
    }

    public function workScheduleDisplaySalon() {

        return view('components.salon.work-schedule.list-work-schedule');
    }

    public function workScheduleGetByDate(Request $request) {
        $dateWork = $request['date_word'];
        $workSchedule = $this->workScheduleRepository->getWorkScheduleByDateAndSalonID($dateWork, Auth::guard('salon')->user()->salon_id);
        if($workSchedule) {
            return  response()->json([
                'ws_id' => $workSchedule->ws_id,
                'hours' => json_decode($workSchedule->hours),
                'success' => true
            ]);
        }
        return  response()->json([
            'ws_id' => '',
            'hours' => [],
            'success' => true
        ]);
    }

    public function workScheduleSalonSave(Request $request) {
        $workDate = $request['work_date'];
        $workScheduleID = $request['ws_id'];
        if(empty($workDate)) {
            return  response()->json([
                'message' => 'Vui lòng chọn khung giờ làm việc',
            ], 500);
        }
        if($workDate < date('Y-m-d')) {
            return  response()->json([
                'message' => 'Vui lòng cập nhật ngày hiện tại trở đi.',
            ], 500);
        }
        $hours = WorkScheduleDTO::convertArrayToHours($request['time_slot'], $request['is_selected']);
        if(!isset($workScheduleID)) {
            $workSchedule = $this->workScheduleRepository->save($workDate, json_encode($hours), Auth::guard('salon')->user()->salon_id);
        } else {
            $workSchedule = $this->workScheduleRepository->update($workDate, json_encode($hours), $workScheduleID);
        }
        if($workSchedule) {
            $workScheduleID = $workSchedule->ws_id;
        }

        return response()->json([
            'success' => true,
            'ws_id' => $workScheduleID
        ]);
    }
}
