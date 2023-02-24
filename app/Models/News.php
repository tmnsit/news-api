<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date_publish',
        'images',
        'author',
        'ext_id'
    ];

    protected $casts = [
        'images' => 'array'
    ];

    protected $hidden = [
        'ext_id',
        'created_at',
        'updated_at',
        'id'
    ];
}
