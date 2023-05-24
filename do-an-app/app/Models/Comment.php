<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $primaryKey = 'comment_id';

    protected $table = 'comment';

    public $timestamps = false;

    protected $casts = ['comment_id' => 'string'];

    protected $fillable = [
        'comment_id',
        'star',
        'date',
        'content',
        'customer_id',
        'salon_id'
    ];
}
