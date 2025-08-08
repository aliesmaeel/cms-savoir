<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLeadsPoolComment extends Model
{
    use HasFactory;
    protected $table = "user_leads_pool_comments";

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s'
   ];

    protected $guarded = [];
}
