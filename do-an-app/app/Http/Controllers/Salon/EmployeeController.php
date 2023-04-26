<?php

namespace App\Http\Controllers\Salon;

use App\DTO\EmployeeWorkScheduleDTO;
use App\Helpers\MyIDHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Salon\AddEmployeeRequest;
use App\Http\Requests\Salon\EditEmployeeRequest;
use App\Models\EmployeeWorkSchedule;
use App\Repositories\EmployeeRepository;
use App\Repositories\EmployeeWorkScheduleRepository;
use App\Util\EmployeeWorkScheduleUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;
    /**
     * @var EmployeeWorkScheduleRepository
     */
    private $employeeWorkScheduleRepository;

    public function __construct(
        EmployeeRepository $employeeRepository,
        EmployeeWorkScheduleRepository $employeeWorkScheduleRepository
    )
    {
        $this->employeeRepository = $employeeRepository;
        $this->employeeWorkScheduleRepository = $employeeWorkScheduleRepository;
    }

    /** list **/
    public function apiEmployeeAll()
    {
        return $this->employeeRepository->getAllBySalonID(
            Auth::guard('salon')->user()->salon_id);
    }
    public function displayEmployees() {
        return view('components.salon.employee.list-employee');
    }
    /** end list **/

    /** store */
    public function displayAdd() {
        return view('components.salon.employee.add-employee');
    }

    public function validateStore(AddEmployeeRequest $request) {
        return response()->json([
            'success' => true
        ]);
    }
    public function store(Request $request) {
        $employee = $this->employeeRepository->create($request);
        return response()->json([
            'success' => true
        ]);
    }
    /** end add */

    /** update **/
    public function displayUpdate(Request $request) {
        $employee = $this->employeeRepository
            ->getEmployeeByEmployeeIDAndSalonID($request['id'], Auth::guard('salon')->user()->salon_id);
        return view('components.salon.employee.edit-employee',
            compact('employee')
        );
    }
    public function validateUpdate(EditEmployeeRequest $request) {
        return response()->json([
            'success' => true
        ]);
    }
    public function update(Request $request) {
        $employee = $this->employeeRepository->update($request, $request->input('employee_id'));
        return response()->json([
            'success' => true
        ]);
    }
    /** end update **/

    /** delete **/
    public function updateStatus(Request $request) {
        $employee = $this->employeeRepository->updateStatus($request, $request->input('employee_id'));
        return response()->json([
            'success' => true
        ]);
    }
    /** end delete **/
    public function workScheduleDisplay() {
        $employee = $this->employeeRepository->getAllBySalonID(
            Auth::guard('salon')->user()->salon_id);
        return view('components.salon.employee.list-work-schedule',
            compact('employee')
        );
    }

    public function workScheduleGetByDate(Request $request) {
        return $this->employeeWorkScheduleRepository
            ->getByWorkDateAndEmployID($request['date_word'], Auth::guard('salon')->user()->salon_id);
    }

    public function workScheduleSave(Request $request) {
        $ids = json_decode($request['delete_ids']);
        $workDate = $request['work_date'];
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
        if (!empty($ids) && is_array($ids) && count($ids) > 0) {
            $this->employeeWorkScheduleRepository->deleteByIds($ids);
        }
        if(MyIDHelper::hasDuplicate($request['employee_id'])) {
           return  response()->json([
                  'message' => 'Vui lòng chỉnh sửa lại để không bị trùng lịch',
           ], 500);
        }

        $employeeWorkingSchedule =
                EmployeeWorkScheduleDTO::convertArrayToEmployeeWorkSchedule($request['employee_id'], $request['start_time'], $request['end_time'], $request['ews_ids'],$workDate);


        $result = EmployeeWorkScheduleUtil::EmployeeWorkScheduleUtilValidation($employeeWorkingSchedule);

        if(!$result['check']) {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }


        $this->employeeWorkScheduleRepository->saveAll($employeeWorkingSchedule);


        return response()->json([
            'success' => true,
            'work_date' => $workDate
        ]);
    }
    /** workSchedule **/



}
