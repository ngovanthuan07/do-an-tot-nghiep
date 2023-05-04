<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    use HasFactory;

    protected $primaryKey = 'ws_id';

    protected $table = 'workingschedule';

    public $timestamps = false;

    protected $casts = ['ws_id' => 'string'];

    protected $fillable = [
        'ws_id',
        'work_date',
        'hours',
        'salon_id'
    ];

}
