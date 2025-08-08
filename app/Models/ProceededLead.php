<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProceededLead extends Model
{
    use HasFactory;
    protected $table = "proceeded_lead";
    protected $guarded = [];

    public function userproceededleadcomment()
    {
        return $this->hasMany('App\Models\UserProceededLeadComment');
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s'
   ];
}
