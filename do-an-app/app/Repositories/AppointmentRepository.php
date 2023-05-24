<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\PaymentService;
use App\Models\Salon;
use App\Models\Service;
use App\Models\ServiceDetail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AppointmentRepository
{
    public function save($data)
    {
        $appointment                    = new Appointment();
        $appointment->appointment_date  = $data['appointment_date'];
        $appointment->appointment_hour  = $data['appointment_hour'];
        $appointment->phone             = $data['phone'];
        $appointment->status            = $data['status'];
        $appointment->employee_id       = $data['employee_id'];
        $appointment->salon_id          = $data['salon_id'];
        $appointment->customer_id       = $data['customer_id'];
        $appointment->save();

        $newAppointment = Appointment::orderBy('appointment_id', 'desc')->first();
        return $newAppointment;
    }

    public function updateStatus($appointment_id, $status)
    {
        $appointment = Appointment::where('appointment_id', $appointment_id)->first();
        $appointment->status = $status;
        return $appointment->update();
    }

    public function checkSalonAppointmentStatus($salonId, $customerId, $status) {
        $result = DB::select('CALL CheckSalonAppointmentStatus(?, ?, @is_booking)', [$salonId, $customerId]);
        $is_booking = DB::select('SELECT @is_booking as is_booking')[0]->is_booking;
        return boolval($is_booking);
    }

    public function getAppointmentByStatus($request)
    {
        $appointments = DB::select('CALL GetSalonAppointmentStatus(?, ?)', [$request['salon_id'], $request['status']]);

        if(count($appointments) > 0) {
            foreach ($appointments as $appointment) {
                $appointment->service_detail = ServiceDetail::where('appointment_id', $appointment->appointment_id)->get();
                $appointment->payment = PaymentService::where('appointment_id', $appointment->appointment_id)->first();
                $appointment->customer = Customer::where('customer_id', $appointment->customer_id)->first();
                $appointment->employee = Employee::where('employee_id', $appointment->employee_id)->first();
            }
            return $appointments;
        }
        return [];

    }

    public function getAppointmentById($request)
    {
        $appointment = Appointment::where('appointment_id', $request['appointment_id'])->first();
        $service_details = ServiceDetail::where('appointment_id', $appointment->appointment_id)->get();
        $customer = Customer::where('customer_id', $appointment->customer_id)->first();
        $employee = Employee::where('employee_id', $appointment->employee_id)->first();
        $payment = PaymentService::where('appointment_id', $appointment->appointment_id)->first();
        $services = [];
        foreach ($service_details as $serviceDetail) {
            $services[] = Service::where('service_id', $serviceDetail->service_id)->first();
        }
        return compact('appointment', 'services', 'payment', 'customer', 'employee');
    }

    public function getAppointmentByCustomerIDAndStatus($customerID, $status)
    {
        $location = new LocationRepository();
        $appointments = Appointment::query()
            ->where('customer_id', $customerID)
            ->where('status', $status)
            ->get();

        if($appointments) {
            foreach ($appointments as $appointment) {
                $appointment->salon = Salon::query()
                    ->where('salon_id', $appointment->salon_id)->first();
                $appointment->payment = PaymentService::query()
                    ->where('appointment_id', $appointment->appointment_id)->first();
                $appointment->location = $location
                    ->getAddress($appointment->salon->ward_code);
                $appointment->employee = Employee::query()
                    ->where('employee_id', $appointment->employee_id)->first();
                $appointment->services = DB::table('servicedetail as sd')
                    ->select('s.*')
                    ->join('appointment as a', 'sd.appointment_id', '=', 'a.appointment_id')
                    ->join('service as s', 'sd.service_id', '=', 's.service_id')
                    ->where('a.appointment_id', '=', $appointment->appointment_id)
                    ->get()
                ;
            }
        }
        return $appointments;

    }
}
