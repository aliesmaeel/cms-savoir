<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffPlanProject extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'off_plan_projects';
    protected $casts=['header_images'=>'array'];


}
