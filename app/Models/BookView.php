<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookView extends Model
{
    use HasFactory;

    protected $table = 'bookviews';
    protected $guarded = [];
    protected $casts = [
         'created_at' => 'datetime:Y-m-d H:m:s',
         'updated_at' => 'datetime:Y-m-d H:m:s'
    ];

}
