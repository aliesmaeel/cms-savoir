<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Carbon\Carbon;


class BayutProperty extends Model implements Feedable
{
    use HasFactory;
    protected $guarded = [];

    public function toFeedItem(): FeedItem
    {
        $NewProperty = NewProperty::where('id',$this->newProperty_id)->first();
        $features = explode(',',  $NewProperty->private_amenities);
        return FeedItem::create([
            'id' => $this->id,
            'title' => "bayut",
            'summary' => "bayut",
            'updated' => Carbon::now(),
            'link' => "bayut",
            'authorName' => "bayut",
            'property_ref_no' =>  $NewProperty->reference_number,
            'permit_number' =>  $NewProperty->permit_number,
            'property_purpose' => $NewProperty->offering_type,
            'property_type' =>  $NewProperty->property_type,
            'property_status' => $this->property_status,
            'city' =>  $NewProperty->city,
            'locality' =>  $NewProperty->pcommunity,
            'sub_locality' =>  $NewProperty->psubcommunity,
            'tower_name' => $this->tower_name,
            'property_title' =>  $NewProperty->title_en,
            'property_title_ar' =>  $NewProperty->title_ar,
            'property_description' =>  $NewProperty->description_en,
            'property_description_ar' =>  $NewProperty->description_ar,
            'property_size' =>  $NewProperty->size,
            'property_size_unit' => $this->property_size_unit,
            'bedrooms' =>  $NewProperty->bedroom,
            'bathroom' =>  $NewProperty->bathroom,
            'price' =>  $NewProperty->price,
            'user_id' =>  $NewProperty->user,
            'features' =>  $features,
            'images' =>  $NewProperty->propertyImages,
            'videos' => $NewProperty->propertyVideos,
            'floor_plans' =>  $NewProperty->propertyFloorPlans,
            'rent_Frequency' => $this->rent_Frequency,
            'off_plan' => $this->off_plan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
    }

    public static function getFeedBayuts()
    {

        return BayutProperty::all();
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function newProperty()
    {
        return $this->belongsTo('App\Models\NewProperty');
    }
   
    
}
