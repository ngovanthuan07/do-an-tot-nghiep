<?php

namespace App\Util;

use Illuminate\Support\Facades\Mail;

class SendMailUtil
{
    public static function sendMailServiceMomo($status, $book, $phone) {
        Mail::send('emails.service_mail',
            [
                'phone' => $phone,
                'services' => $book['services'],
                'date' => $book['date'],
                'timeSlot' => $book['time_slot'],
                'employee' => $book['employee']->fullname,
                'price' => $book['total_price'],
                'salon' => SalonUtil::getById($book['salon_id']),
                'payment_status' => 'Đã thanh toán',
                'status' => $status
            ],
            function ($email) {
                $email->to('ngovanthuan07@gmail.com', 'Oke');
            }
        );
    }

    public static function statusPayment($status) {
        if($status == 'waiting')
            return 'Chưa thanh toán';
        else if($status == 'payment')
            return 'Đã thanh toán';
        return 'Chưa thanh toán';
    }

    public static function sendMailServiceSalon($status, $salonId, $data) {
        Mail::send('emails.service_mail_salon',
            [
                'phone' => $data['appointment']->phone,
                'customer' => $data['customer'],
                'services' => $data['services'],
                'date' => $data['appointment']->appointment_date,
                'timeSlot' => $data['appointment']->appointment_hour,
                'employee' => $data['employee']->fullname,
                'price' =>  $data['payment']->total,
                'salon' => SalonUtil::getById($salonId),
                'payment_status' => SendMailUtil::statusPayment($data['payment']->status),
                'status' => $status
            ],
            function ($email) {
                $email->to('ngovanthuan07@gmail.com', 'Oke');
            }
        );
    }
}
