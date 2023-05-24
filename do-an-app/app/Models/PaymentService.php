<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentService extends Model
{
    use HasFactory;

    public static $PAY_WITH_CASH = 'cash';
    public static $PAY_WITH_MOMO = 'momo';
    public static $PAY_WITH_VNPAY = 'vnpay';


    protected $primaryKey = 'payment_id';

    protected $table = 'paymentservice';

    public $timestamps = false;

    protected $casts = ['payment_id' => 'string'];

    protected $fillable = [
        'payment_id',
        'payment_date',
        'type',
        'total',
        'status',
        'appointment_id'
    ];
}
