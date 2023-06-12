<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\HandleDateTimePickerHelper;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\PaymentService;
use App\Repositories\AppointmentRepository;
use App\Repositories\PaymentServiceRepository;
use App\Repositories\ServiceDetailRepository;
use App\Util\CheckAppointmentCustomer;
use App\Util\CheckUserCompleteAppointmentUtil;
use App\Util\SendMailUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use function Symfony\Component\String\s;

class HandlePaymentControlller extends Controller
{
    public function __construct(
        AppointmentRepository $appointmentRepository,
        PaymentServiceRepository $paymentServiceRepository,
        ServiceDetailRepository $serviceDetailRepository
    )
    {
        $this->appointmentRepository = $appointmentRepository;
        $this->paymentServiceRepository = $paymentServiceRepository;
        $this->serviceDetailRepositor = $serviceDetailRepository;
    }

    public function link_redirect(Request $request) {
        $book = session('BOOK');

        if(CheckAppointmentCustomer::isCheck($book)) {
            return response()->json([
                'message' => 'Bạn đã trùng cuộc hẹn',
            ], 401);
        }

//        if(CheckAppointmentCustomer::isCheckAppointment() < 10) {
//            return response()->json([
//                'message' => 'Bạn đã đặt lịch quá giới hạn',
//            ], 401);
//        }

        return response()->json([
            'success' => true
        ]);
    }
    public function payment_pay_with_cash(Request $request) {
        $phone = $request->input('phone');
        $type = 'cash';
        $book = session('BOOK');
        $appointment = $this->appointmentRepository->save([
            'appointment_date' => $book['date'],
            'appointment_hour' => $book['time_slot'],
            'phone' => $phone,
            'status' => Appointment::$SCHEDULED,
            'customer_id' => Auth::guard('customer')->user()->customer_id,
            'employee_id' => $book['employee']->employee_id,
            'salon_id' => $book['salon_id'],
        ]);
        $this->serviceDetailRepositor
            ->saveListObjectServiceAndAppointment($book['services'], $appointment->appointment_id);
        $this->paymentServiceRepository
            ->save([
                'payment_date' => HandleDateTimePickerHelper::getToday(),
                'type' => PaymentService::$PAY_WITH_CASH,
                'total' => $book['total_price'],
                'appointment_id' => $appointment->appointment_id,
                'status' => 'waiting'
            ]);
        session(['BOOK' => null]);
        return view('components.customer.notif.book-success');
    }

    public function payment_pay_with_momo(Request $request) {
        $phone = $request->input('phone');
        session(['BOOK_PHONE' => $phone]);
        $book = session('BOOK');
        $price = strval($book['total_price'] ?? 0);
        $endpoint = "https://test-payment.momo.vn/gw_payment/transactionProcessor";
        $partnerCode = "MOMOBKUN20180529";
        $accessKey = "klm05TvNBzhg7h7j";
        $secretkey = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa";
        $orderId =  time() ."";
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $price;
        $notifyurl = "http://localhost:8000/paymomo/ipn_momo.php"; // thong bao
        $returnUrl = route('customer.payment.book.momo-return'); // tra ve
        $extraData = "merchantName=MoMo Partner";
        $requestId = time() . "";
        $requestType = "captureMoMoWallet";

        $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&returnUrl=" . $returnUrl . "&notifyUrl=" . $notifyurl . "&extraData=" . $extraData;
        $signature = hash_hmac("sha256", $rawHash, $secretkey);

        $data = [
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'returnUrl' => $returnUrl,
            'notifyUrl' => $notifyurl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        ];
        $response = Http::timeout(5)->withHeaders([
            'Content-Type' => 'application/json',
            'Content-Length' => strlen(json_encode($data)),
        ])->post($endpoint, $data);
        $result = json_decode($response, true);

        return Redirect::away($result['payUrl']);
    }

    public function payment_pay_with_return_momo(Request $request) {
        $phone = session('BOOK_PHONE');
        $type = 'momo';
        $book = session('BOOK');
        if($request['errorCode'] == 0) {
            $appointment = $this->appointmentRepository->save([
                'appointment_date' => $book['date'],
                'appointment_hour' => $book['time_slot'],
                'phone' => $phone,
                'status' => Appointment::$CONFIRMED,
                'customer_id' => Auth::guard('customer')->user()->customer_id,
                'employee_id' => $book['employee']->employee_id,
                'salon_id' => $book['salon_id'],
            ]);
            $this->serviceDetailRepositor
                ->saveListObjectServiceAndAppointment($book['services'], $appointment->appointment_id);
            $this->paymentServiceRepository
                ->save([
                    'payment_date' => HandleDateTimePickerHelper::getToday(),
                    'type' => PaymentService::$PAY_WITH_MOMO,
                    'total' => $book['total_price'],
                    'appointment_id' => $appointment->appointment_id,
                    'status' => 'payment'
                ]);
            SendMailUtil::sendMailServiceMomo('Đã xác nhận',$book, $phone);
            session(['BOOK' => null]);
            session(['BOOK_PHONE' => null]);
            return redirect()->route('customer.home');
        }
        session(['BOOK_PHONE' => null]);
        session(['BOOK' => null]);
        return redirect()->route('customer.salon-page.detail', $book['salon_id']);
    }
}
