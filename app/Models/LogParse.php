<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogParse extends Model
{
    use HasFactory;

    protected $fillable = [
        'method',
        'url',
        'response',
        'time_request'
    ];
}
