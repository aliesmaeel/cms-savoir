<?php

namespace App\Imports;

use App\Models\Building;
use App\Models\Community;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BuildingImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        if ($row['bulding_name'] != null && $row['place'] != null){
            $community = Community::where('name',$row['place'])->first();
            if($community){
                $building = Building::create([
                    'building_name' => $row['bulding_name'],
                    'community_id' => $community->id,
                ]);  
            }else{
                $building = Building::create([
                    'building_name' => $row['bulding_name'],
                    'community_id' => '2',
                ]);
            }
       
        return $building;
        }
    }
}
