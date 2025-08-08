<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class NewProperty extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // Newproperty has many Finders
    public function finderProperties()
    {
        return $this->hasMany(FinderProperty::class, 'newProperty_id', 'id');
    }
    public function bayutProperties()
    {
        return $this->hasMany(BayutProperty::class, 'newProperty_id', 'id');
    }
    public function emiratesProperties()
    {
        return $this->hasMany(EmiratesProperty::class, 'newProperty_id', 'id');
    }
    public function dubizzleProperties()
    {
        return $this->hasMany(DubizzleProperty::class, 'newProperty_id', 'id');
    }
    public function propertyImages()
    {
        return $this->hasMany(PropertyImage::class, 'newProperty_id', 'id');
    }

    public function propertyFloorPlans()
    {
        return $this->hasMany(PropertyFloorPlan::class, 'newProperty_id', 'id');
    }

    public function propertyVideos()
    {
        return $this->hasMany(PropertyVideo::class, 'newProperty_id', 'id');
    }

    public function finder()
    {
        return $this->hasMany(PropertyFinder::class);
    }

    public function scopeGetLive($query)
    {
        return $query->Where("property_status","live")
        ->select("new_properties.*")
        ->groupBy("new_properties.reference_number");
    }

    public function scopeGetArchived($query)
    {
        return $query->Where("property_status","archive")
        ->select("new_properties.*")
        ->groupBy("new_properties.reference_number");
    }

    public function pcommunity()
    {
        return $this->belongsTo(Community::class, 'community');
    }

    public function psubcommunity()
    {
        return $this->belongsTo(SubCommunity::class, 'sub_community');
    }
}
