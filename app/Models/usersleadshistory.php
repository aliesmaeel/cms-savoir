<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usersleadshistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'userstatus',
        'data_id',
        'user_id',
        'comment',
    ];
}
