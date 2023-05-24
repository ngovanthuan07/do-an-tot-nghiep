<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    public static  $SCHEDULED = 'scheduled';
    public static  $CONFIRMED = 'confirmed';
    public static  $COMPLETED = 'completed';
    public static  $CANCEL = 'cancel';
    public static  $REJECT = 'reject';


    protected $table = 'appointment';

    protected $primaryKey = 'appointment_id';

    protected $casts = ['appointment_id' => 'string'];

    public $timestamps = false;

    protected $fillable = [
        'appointment_id',
        'appointment_date',
        'appointment_hour',
        'email',
        'phone',
        'status',
        'customer_id',
        'employee_id',
        'salon_id'
    ];

}