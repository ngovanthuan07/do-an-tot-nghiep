<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;


    protected $primaryKey = 'post_id';

    protected $table = 'post';

    public $timestamps = true;

    protected $casts = ['post_id' => 'integer'];

    protected $fillable = [
        'post_id',
        'title',
        'image',
        'content',
        'created_at',
        'updated_at',
        'admin_id'
    ];
}
