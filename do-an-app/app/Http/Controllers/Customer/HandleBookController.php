<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\HandleDateTimePickerHelper;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\WorkSchedule;
use App\Repositories\AppointmentRepository;
use App\Repositories\CategoryServiceRepository;
use App\Repositories\LocationRepository;
use App\Repositories\SalonRepository;
use App\Repositories\ServiceRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HandleBookController extends Controller
{
    /**
     * @var SalonRepository
     */
    private $salonRepository;
    /**
     * @var CategoryServiceRepository
     */
    private $categoryServiceRepository;
    /**
     * @var ServiceRepository
     */
    private $serviceRepository;
    /**
     * @var LocationRepository
     */
    private $locationRepository;

    public function __construct(
        SalonRepository $salonRepository,
        CategoryServiceRepository $categoryServiceRepository,
        ServiceRepository $serviceRepository,
        LocationRepository $locationRepository,
        AppointmentRepository $appointmentRepository
    )
    {
        $this->salonRepository = $salonRepository;
        $this->categoryServiceRepository = $categoryServiceRepository;
        $this->serviceRepository = $serviceRepository;
        $this->locationRepository = $locationRepository;
        $this->appointmentRepository = $appointmentRepository;
    }

    public function index(Request $request) {
        $salon = $this->salonRepository->getSalonById($request['id']);

        return view('components.customer.salon-details.salon-detail-book', compact('salon'));
    }

    public function workDate(Request $request) {
        $salonId = $request['id'];
        $dateInput = HandleDateTimePickerHelper::formatDate($request->input('date'));
        $workSchedule = WorkSchedule::query()
            ->where('salon_id', $salonId)
            ->where('work_date', $dateInput)
            ->first();
        if($workSchedule) {
            $workSchedule->hours = json_decode($workSchedule->hours);
            if (HandleDateTimePickerHelper::checkToday($dateInput)) {
                $currentTime = date('H:i', strtotime('+20 minutes')); // Thêm 20 phút vào thời gian hiện tại
                $workSchedule->hours = collect($workSchedule->hours)
                    ->filter(function ($item) use ($currentTime) {
                        return $item->time_slot > $currentTime;
                    })
                    ->values();
            }
        }
        return response()->json([
            'success' => true,
            'data' => $workSchedule
        ]);
    }

    public function employeeWord(Request $request) {
        $dateWorking = $request['date_working'];
        $timeSlot = $request['time_slot'];
        $salonId = $request['salon_id'];
        $employees = DB::select('CALL GetAvailableEmployees(?, ?, ?)', [$dateWorking, $timeSlot, $salonId]);
        return response()->json([
            'success' => true,
            'data' => $employees ?? []
        ]);
    }

    public function checkSalonAppointmentStatus(Request $request) {
        $customerId = Auth::guard('customer')->user()->customer_id;
        return $this->appointmentRepository->checkSalonAppointmentStatus($request['salon_id'], $customerId, $request['status']);
    }
}
