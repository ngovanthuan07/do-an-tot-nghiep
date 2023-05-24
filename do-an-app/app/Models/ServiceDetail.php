<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    use HasFactory;

    protected $primaryKey = ['service_id', 'appointment_id'];

    protected $table = 'servicedetail';

    public $timestamps = false;

    protected $casts = ['service_id' => 'string', 'appointment_id' => 'string'];

    protected $fillable = [
        'service_id',
        'appointment_id',
        'status',
    ];

    public $incrementing = false;
}

