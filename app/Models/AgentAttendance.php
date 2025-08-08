<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentAttendance extends Model
{
    use HasFactory;
    protected $table = "agent_attendances";
    protected $fillable = [
        'agent_id',
        'start_time',
        'end_time',
        'duration',
        'date',
    ];
}
