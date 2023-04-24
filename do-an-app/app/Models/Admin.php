<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN= 'ROLE_ADMIN';

    protected $table = 'admin';

    protected $primaryKey = 'admin_id';

    protected $casts = ['admin_id' => 'string'];


    protected $fillable = [
        'admin_id',
        'username',
        'password',
        'first_name',
        'last_name',
        'image',
        'dob',
        'phone',
        'gender',
        'address',
        'role',
        'status',
    ];
    public function isAdmin() {
        if ($this->role !== self::ROLE_ADMIN) {
            return false;
        }
        return true;
    }
}
