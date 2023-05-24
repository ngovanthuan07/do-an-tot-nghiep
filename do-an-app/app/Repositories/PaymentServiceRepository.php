<?php

namespace App\Repositories;

use App\Helpers\HandleDateTimePickerHelper;
use App\Models\PaymentService;
use App\Models\Salon;
use http\Env\Request;
use Illuminate\Support\Facades\Hash;

class PaymentServiceRepository
{
    public function save($data) {
        PaymentService::create($data);
    }

    public function updatePaymentComplete($appointmentId) {
        $payment = PaymentService::query()
            ->where('appointment_id', $appointmentId)
            ->first();
        if($payment->type != PaymentService::$PAY_WITH_MOMO) {
            $payment->payment_date = HandleDateTimePickerHelper::getToday();
            $payment->status = 'payment';
            $payment->update();
        }
       return $payment;
    }
}
