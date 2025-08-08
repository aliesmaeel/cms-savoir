<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotosheetType extends Model
{
    use HasFactory;
    protected $table = "photoshoot_types";
    protected $fillable=['name'];

    public function appointmentwithtype()
    {
        return $this->hasMany(Appointment::class, 'photoshoot_type_id', 'id');
        
    }
}
