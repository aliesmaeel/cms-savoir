<?php

namespace App\Imports;

use App\Models\booktable;
use App\Models\Data;
use App\Models\UserData;
use App\Models\UserDataComment;
use App\Models\UserLeadsPool;
use Exception;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Events\BeforeImport;

class EnquriyCustomerImport implements ToCollection
{
    public function Collection(collection $rows)
    {

        foreach ($rows as $key => $row) {
            // dd($row);
            if($row[0] == "name" && $row[1] == "email" && $row[2]=='phone'&& $row[3]=='utm_source' && $row[4]=='utm_medium' && $row[5]=='utm_campaign' && $row[6]=='project' ){
                unset($row);
            }else{
                try {
                    if($row[0] == '' || $row[6] == ''){
                        unset($row);
                    }else{
                        if(Auth::user()->isagent()){
                            $data=Data::firstOrCreate([
                                'phone' => $row[2],
                                'source' => $row[6],
                            ],[
                                'name' => $row[0],
                                'email' => $row[1],
                                'phone' => $row[2],
                                'source' => $row[6],
                                'project' => $row[6] ,
                                'agents' => Auth::user()->name,
                                'data_status' => 8,
                                'previous_status' => 0,
                                'is_campaign' => 1,
                                'assigned'=> true
                            ]);
                            $booktable=booktable::firstOrCreate([
                                'phone' => $row[2],
                                'source' => $row[6],
                            ],[
                                'name' => $row[0] == '' ? null : $row[0],
                                'email' => $row[1],
                                'phone' => $row[2],
                                'utm_source' => isset($row[3]) ? $row[3] : null,
                                'campaign_name' => $row[6],
                                'utm_medium'=> $row[4] == '' ? null : $row[4],
                                'utm_campaign'=>$row[5] == '' ? null : $row[5],
                                'project' => $row[6],
                                'created_by' => Auth::user()->id,
                                'data_id' => $data->id,
                                'source' => $row[6],
                                'previous_state' => 0,
                                'previous_state_id' => $data->id,
                                'assigned'=> true
                            ]);
                            $userdata = new UserLeadsPool;
                            $userdata->user_id = Auth::user()->id;
                            $userdata->leads_pool_id = $booktable->id;
                            $userdata->save();
                        }else{
                            $data=Data::firstOrCreate([
                                'phone' => $row[2],
                                'source' => $row[6],
                            ],[
                                'name' => $row[0],
                                'email' => $row[1],
                                'phone' => $row[2],
                                'source' => $row[6],
                                'project' => $row[6] ,
                                'agents' => Auth::user()->name,
                                'data_status' => 8,
                                'previous_status' => 0,
                                'is_campaign' => 1,
                            ]);
                            $booktable=booktable::firstOrCreate([
                                'phone' => $row[2],
                                'source' => $row[6],
                            ],[
                                'name' => $row[0] == '' ? null : $row[0],
                                'email' => $row[1],
                                'phone' => $row[2],
                                'utm_source' => isset($row[3]) ? $row[3] : null,
                                'campaign_name' => $row[6],
                                'utm_medium'=> $row[4] == '' ? null : $row[4],
                                'utm_campaign'=>$row[5] == '' ? null : $row[5],
                                'project' => $row[6],
                                'created_by' => Auth::user()->id,
                                'data_id' => $data->id,
                                'source' => $row[6],
                                'previous_state' => 0,
                                'previous_state_id' => $data->id,
                            ]);
                        }
                    }
                } catch (Exception $ex) {
                    dd($ex);
                }

            }

        }
    }

    public static function beforeImport(BeforeImport $event)
    {
        $options = LIBXML_COMPACT | LIBXML_PARSEHUGE;

        \PhpOffice\PhpSpreadsheet\Settings::setLibXmlLoaderOptions($options);
    }
}
