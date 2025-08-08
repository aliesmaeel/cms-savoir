<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUpLeads extends Model
{
    use HasFactory;
    protected $table = "follow_up_leads";
    protected $guarded = [];

    public function userfollowupdatacomments()
    {
        return $this->hasMany('App\Models\UserFollowUpLeadsComment', 'follow_up_id', 'id');
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s'
   ];

}
