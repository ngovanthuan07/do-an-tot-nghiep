<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Salon extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'salon_id';

    protected $table = 'salon';

    public $timestamps = false;

    protected $casts = ['salon_id' => 'string'];

    protected $fillable = [
        'salon_id',
        'username',
        'password',
        'name',
        'phone',
        'images',
        'address',
        'description',
        'time_working_desc',
        'time_slot_desc',
        'role',
        'status',
        'ward_cod'
    ];
}
