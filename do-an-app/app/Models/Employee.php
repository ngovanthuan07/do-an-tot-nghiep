<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'employee_id';

    protected $table = 'employees';

    public $timestamps = false;

    protected $casts = ['employee_id' => 'string'];

    protected $fillable = [
        'employee_id',
        'image',
        'description',
        'fullname',
        'phone',
        'dob',
        'cic',
        'gender',
        'status',
        'salon_id'
    ];
}
