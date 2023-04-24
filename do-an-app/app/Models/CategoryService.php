<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryService extends Model
{
    use HasFactory;

    protected $primaryKey = 'cse_id';

    protected $table = 'categoryservice';

    public $timestamps = false;

    protected $casts = ['cse_id' => 'string'];

    protected $fillable = [
        'cse_id',
        'name',
        'isSelect',
        'status',
        'salon_id'
    ];
}
