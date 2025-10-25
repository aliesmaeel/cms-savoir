<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class OffPlanProject extends Model
{
    use HasFactory,Searchable;
    protected $guarded=[];
    protected $table = 'off_plan_projects';
    protected $casts=['header_images'=>'array'];

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'link' => $this->link,
            'image'=> $this->image,
            'location' => $this->location,
            'developer' => $this->developer,
            'completion_date' => $this->completion_date,
            'price' => $this->starting_price,
        ];
    }

    public function searchableSettings() :array
    {
        return [
            "filterableAttributes" => [
                "location",
                "developer",
                "completion_date",
            ],
            'sortableAttributes' => [
                'price',
                'updated_at',
                'title',
            ],
        ];
    }

    public function searchableAs(): string
    {
        return 'off_plan_projects';
    }


}
