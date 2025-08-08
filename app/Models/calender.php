<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calender extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_title',
        'start_time',
        'end_time',
        'event_id',
        'user_id',
        'event_title',
        'event_type',
        'event_source'
    ];
}
