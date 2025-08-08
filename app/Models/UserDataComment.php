<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\VarDumper\Cloner\Data;

class UserDataComment extends Model
{
    use HasFactory;
    protected $table = "user_data_comment";
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s'
   ];

    // relations
    public function data()
    {
        return $this->belongsTo('App\Models\Data');
    }
}
