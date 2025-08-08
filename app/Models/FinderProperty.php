<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use App\Models\NewProperty;
use Carbon\Carbon;

class FinderProperty extends Model implements Feedable
{
    use HasFactory;
    protected $guarded = [];

    public function toFeedItem(): FeedItem
    {
        $NewProperty = NewProperty::where('id',$this->newProperty_id)->first();
        return FeedItem::create([
            'id' => $this->id,
            'title' => "property",
            'summary' => "property",
            'updated' => Carbon::now(),
            'link' => "property",
            'authorName' => "property",
            'reference_number' =>  $NewProperty->reference_number,
            'permit_number' =>  $NewProperty->permit_number,
            'offering_type' => $NewProperty->offering_type,
            'property_type' =>$NewProperty->property_type,
            'price' =>  $NewProperty->price,
            'service_charge' => $this->service_charge,
            'cheques' => $this->cheques,
            'city' =>  $NewProperty->city,
            'community' =>  $NewProperty->pcommunity,
            'sub_community' =>  $NewProperty->psubcommunity,
            'property_name' => $this->property_name,
            'title_en' =>  $NewProperty->title_en,
            'title_ar' =>  $NewProperty->title_ar,
            'description_en' =>  $NewProperty->description_en,
            'description_ar' =>  $NewProperty->description_ar,
            'private_amenities' =>  $NewProperty->private_amenities,
            'plot_size' => $this->plot_size,
            'size' =>  $NewProperty->size,
            'bedroom' =>  $NewProperty->bedroom,
            'bathroom' =>  $NewProperty->bathroom,
            'user_id' => $NewProperty->user,
            'developer' => $this->developer,
            'build_year' => $this->build_year,
            'completion_status' => $this->completion_status,
            'floor' => $this->floor,
            'stories' => $this->stories,
            'parking' => $this->parking,
            'furnished' => $this->furnished,
            'view360' => $this->view360,
            'photo' =>  $NewProperty->propertyImages,
            'floor_plan' => $NewProperty->propertyFloorPlans,
            'geopoints' => $this->geopoints,
            'title_deed' => $this->title_deed,
            'availability_date' => $this->availability_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
    }
    public static function getFeedItems()
    {

        return FinderProperty::all();
    }
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s'
    ];

    public function newProperty()
    {
        return $this->belongsTo('App\Models\NewProperty');
    }

}
