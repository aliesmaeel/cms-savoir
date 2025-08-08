<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'date',
        'address',
        'description',
        'created_by',
        'path',
        'event_type_id',
        'status'
    ];
}
