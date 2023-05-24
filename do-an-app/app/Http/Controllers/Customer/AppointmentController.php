<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Repositories\AppointmentRepository;
use App\Util\AppointmentUtil;
use App\Util\SendMailUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function __construct(AppointmentRepository $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function appointment() {
        $customerID = Auth::guard('customer')->user()->customer_id;
        $scheduled = $this->appointmentRepository->getAppointmentByCustomerIDAndStatus($customerID, Appointment::$SCHEDULED);
        $confirmed = $this->appointmentRepository->getAppointmentByCustomerIDAndStatus($customerID, Appointment::$CONFIRMED);
        $cancel = $this->appointmentRepository->getAppointmentByCustomerIDAndStatus($customerID, Appointment::$CANCEL);
        $completed = $this->appointmentRepository->getAppointmentByCustomerIDAndStatus($customerID, Appointment::$COMPLETED);

        return view('components.customer.account.appointment',
            compact('scheduled', 'confirmed', 'cancel', 'completed')
        );
    }

    public function cancel(Request $request) {
        $status = Appointment::$CANCEL;
        $this->appointmentRepository->updateStatus($request['appointment_id'],$status);
        if($request['status'] == Appointment::$COMPLETED) {
            $this->paymentServiceRepository->updatePaymentComplete($request['appointment_id']);
        }
        $results = $this->appointmentRepository->getAppointmentById($request);
        SendMailUtil::sendMailServiceSalon(AppointmentUtil::convertStatusToNotification($status), Auth::guard('salon')->user()->salon_id, $results);

        return redirect()->route('customer.appointment');
    }
}
