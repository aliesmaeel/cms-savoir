<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class followupstatuscommentshistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'userstatus',
        'follow_up_id',
        'user_id',
        'comment',
    ];

}
