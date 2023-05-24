<?php

namespace App\Http\Controllers\salon;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\PaymentService;
use App\Models\ServiceDetail;
use App\Repositories\AppointmentRepository;
use App\Repositories\PaymentServiceRepository;
use App\Util\AppointmentUtil;
use App\Util\SendMailUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function __construct(
        AppointmentRepository $appointmentRepository,
        PaymentServiceRepository $paymentServiceRepository
    )
    {
        $this->appointmentRepository = $appointmentRepository;
        $this->paymentServiceRepository = $paymentServiceRepository;
    }

    public function scheduled()
    {
        $salon = Auth::guard('salon')->user();
        $status = Appointment::$SCHEDULED;
        return view('components.salon.appointment.appointments', compact('salon', 'status'));
    }

    public function confirmed()
    {
        $salon = Auth::guard('salon')->user();
        $status = Appointment::$CONFIRMED;
        return view('components.salon.appointment.appointments', compact('salon', 'status'));
    }

    public function completed()
    {
        $salon = Auth::guard('salon')->user();
        $status = Appointment::$COMPLETED;
        return view('components.salon.appointment.appointments', compact('salon', 'status'));
    }

    public function cancel()
    {
        $salon = Auth::guard('salon')->user();
        $status = Appointment::$CANCEL;
        return view('components.salon.appointment.appointments', compact('salon', 'status'));
    }

    public function loadAppointmentByStatus(Request $request)
    {
        return $this->appointmentRepository->getAppointmentByStatus($request);
    }

    public function loadAppointmentById(Request $request)
    {
        return $this->appointmentRepository->getAppointmentById($request);
    }

    public function updateStatus(Request $request)
    {
        try {
            $this->appointmentRepository->updateStatus($request['appointment_id'],$request['status']);
            if($request['status'] == Appointment::$COMPLETED) {
                $this->paymentServiceRepository->updatePaymentComplete($request['appointment_id']);
            }


            $results = $this->appointmentRepository->getAppointmentById($request);
            SendMailUtil::sendMailServiceSalon(AppointmentUtil::convertStatusToNotification($request['status']), Auth::guard('salon')->user()->salon_id, $results);


            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e
            ], 401);
        }
    }

    public function detailAppointment(Request $request) {
        $results = $this->appointmentRepository->getAppointmentById($request);
        return view('components.salon.appointment.detail', $results);
    }
}
