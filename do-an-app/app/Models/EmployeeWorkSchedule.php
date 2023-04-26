<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeWorkSchedule extends Model
{
    use HasFactory;

    protected $primaryKey = 'ews_id';

    protected $table = 'employeeworkingschedule';

    public $timestamps = false;

    protected $casts = ['ews_id' => 'string'];

    protected $fillable = [
        'ews_id',
        'work_date',
        'start_time',
        'end_time',
        'employee_id'
    ];
}
