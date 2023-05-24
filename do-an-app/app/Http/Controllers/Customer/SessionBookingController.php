<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Service;
use App\Util\CheckUserCompleteAppointmentUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionBookingController extends Controller
{
    public function dPayment()
    {
        $order = session('BOOK');
        $customer = Auth::guard('customer')->user();
        return view('components.customer.payment.payment', compact('order', 'customer'));
    }

    public function sessionPayment(Request $request) {
//        if(CheckUserCompleteAppointmentUtil::isCheck($request->input('salon_id'), Appointment::$SCHEDULED)) {
//            session(['BOOK' => null]);
//            return response()->json([
//                'message' => 'Bạn đã có cuộc hẹn với salon chúng tôi trước đó vui lòng hoàn tất cuộc hẹn trước khi thực hiện một cuộc hẹn mới',
//            ], 401);
//        }

        $employee  = Employee::where('employee_id', $request->input('employee_id'))->first();
        $services = Service::query()
            ->whereIn('service_id', $request->input('service_ids'))
            ->get();
        $totalPrice = $services->sum('price');
        $mCollect = [
            'employee' => $employee,
            'time_slot' => $request->input('time_slot'),
            'salon_id'=> $request->input('salon_id'),
            'date' => $request->input('date'),
            'services' => $services,
            'total_price' => $totalPrice
        ];
        session(['BOOK' => $mCollect]);
        return response()->json([
            'success' => true,
            'redirect' => route('customer.salon-page.book.dPayment', $request->input('salon_id'))
        ]);
    }
}
