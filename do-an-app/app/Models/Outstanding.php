<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outstanding extends Model
{
    use HasFactory;

    protected $primaryKey = 'oustanding_id';

    protected $table = 'outstanding';

    public $timestamps = false;

    protected $casts = ['oustanding_id' => 'string'];

    protected $fillable = [
        'oustanding_id',
        'admin_id',
        'salon_id',
    ];

    protected $hidden = [
        'password',
    ];
}
