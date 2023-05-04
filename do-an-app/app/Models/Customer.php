<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const CUSTOMER_ROLE= 'CUSTOMER_ROLE';

    protected $table = 'customer';

    protected $primaryKey = 'customer_id';

    protected $casts = ['customer_id' => 'string'];

    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'email',
        'password',
        'fullname',
        'image',
        'dob',
        'phone',
        'gender',
        'type_login',
        'token',
        'confirm',
        'confirmation_code',
        'confirmation_code_expired_in',
        'role',
        'status',
        'address',
        'ward_code'
    ];

    protected $hidden = [
        'password',
    ];


    public function isCustomer() {
        if ($this->role !== self::CUSTOMER_ROLE) {
            return false;
        }
        return true;
    }
}
