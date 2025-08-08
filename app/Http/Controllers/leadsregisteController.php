<?php

namespace App\Http\Controllers;

header('Access-Control-Allow-Origin: *');

use App\Mail\compaignregister;
use App\Models\booktable;
use App\Models\Data;
use App\Models\User;
use App\Models\Campaign;
use App\Models\LandingAgent;
use App\Models\UserLeadsPool;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

class leadsregisteController extends Controller
{
    use SendEmailT;
    public function damac(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'na' => 'required',
            'em' => 'required|email',
            'ph' => 'required|regex:/^\+(?:[0-9] ?){8,13}[0-9]$/'
        ], [
            'na.required' => 'Please enter your name',
            'em.required' => 'Please enter your email',
            'ph.required' => 'Please enter your phone number',
            'ph.regex' => 'Please enter valid phone number',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
                'status' => false
            ]);
        }
        $datacount = Data::where('phone', $request->ph)->where('source', $request->src)->count();

        if ($datacount > 0) {
            return response()->json([
                'errors' => ['You already registerd with this phone number'],
                'status' => false
            ]);
        }

        $detels = [
            'name' => $request->na,
            'email' => $request->em,
            'phone' => $request->ph
        ];

        try {
            Mail::to('admin@remaxnetworkhome.com')->send(new compaignregister($detels));
        } catch (Exception $th) {
            //throw $th;
        }
        $data = Data::create([
            'name' => $request->na,
            'email' => $request->em,
            'phone' => $request->ph,
            'phone_whatsup' => trim($request->ph),
            'source' => $request->src,
            'data_status' => 8,
            'is_campaign' => 1
        ]);


        // get external user
        $user = User::where('email', 'externaluser@remaxnetworkhome.com')->first();
        if ($user == null) {
            $user = User::create([
                'name' => 'external user',
                'email' => 'externaluser@remaxnetworkhome.com',
                'role_id' => '3',
            ]);
        }

        // check if capmaign already exists
        $campaign = Campaign::where("name", "Damac lagoon")->first();
        if (!$campaign) {
            $campaign = Campaign::create(["name" => "Damac lagoon"]);
        } else {
            $landing_agents = LandingAgent::where('landing_name', $campaign->id)->get();
            if (count($landing_agents) > 0) {
                foreach ($landing_agents as $key) {
                    try {
                        $Supervisor_agent = User::where('id', $key->user_id)->first();
                        Mail::to($Supervisor_agent->email)->send(new compaignregister($detels));
                    } catch (Exception $th) {
                    }
                }
            }
        }
        $leads = new booktable;
        $leads->data_id = $data->id;
        $leads->name = $request->na;
        $leads->email = $request->em;
        $leads->phone = $request->ph;
        $leads->source = $request->src;
        $leads->request_call_back = $request->rcb;
        $leads->campaign_name = "Damac lagoon";
        $leads->utm_id = $request->ui;
        $leads->utm_campaign = $request->uc;
        $leads->utm_medium = $request->um;
        $leads->utm_source = $request->us;
        $leads->phone_whatsapp = trim($request->ph);
        $leads->previous_state = '0';
        $leads->previous_state_id = $data->id;
        $leads->created_by = $user->id;
        $leads->save();
        // return
        return response()->json([
            'status' => true,
            'massege' => "Register successfully"
        ]);
    }

    public function safa(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'ti' => 'required',
            'em' => 'required|email',
            'ph' => 'required|regex:/^\+(?:[0-9] ?){8,13}[0-9]$/'
        ], [
            'ti.required' => 'Please enter title',
            'na.required' => 'Please enter your name',
            'em.required' => 'Please enter your email',
            'ph.required' => 'Please enter your phone number',
            'ph.regex' => 'Please enter valid phone number',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
                'status' => false
            ]);
        }

        $datacount = Data::where('phone', $request->ph)->where('source', 'Safa')->count();

        if ($datacount > 0) {
            return response()->json([
                'errors' => ['You already registerd with this phone number'],
                'status' => false
            ]);
        }

        $data = Data::create([
            'name' => $request->fn . ' ' . $request->ln,
            'email' => $request->em,
            'phone' => $request->ph,
            'phone_whatsup' => trim($request->ph),
            'source' => "Safa",
            'data_status' => 8,
            'is_campaign' => 1
        ]);


        // get external user
        $user = User::where('email', 'externaluser@remaxnetworkhome.com')->first();
        if ($user == null) {
            $user = User::create([
                'name' => 'external user',
                'email' => 'externaluser@remaxnetworkhome.com',
                'role_id' => '3',
            ]);
        }


        // check if capmaign already exists
        $campaign = Campaign::where("name", "Safa")->first();
        if (!$campaign) {
            $campaign = Campaign::create(["name" => "Safa"]);
        }

        $leads = new booktable;
        $leads->id = $data->id;
        $leads->name = $request->fn . ' ' . $request->ln;
        $leads->email = $request->em;
        $leads->phone = $request->ph;
        $leads->source = "Safa";
        $leads->title = $request->ti;
        $leads->utm_id = $request->ui;
        $leads->utm_campaign = $request->uc;
        $leads->utm_medium = $request->um;
        $leads->utm_source = $request->us;
        $leads->phone_whatsapp = trim($request->ph);
        $leads->campaign_name = "Safa";
        $leads->previous_state = '0';
        $leads->previous_state_id = $data->id;
        $leads->created_by = $user->id;
        $leads->save();
        // return
        return response()->json([
            'status' => true,
            'massege' => "Register successfully"
        ]);
    }

    public function property_finder_webhook_lead_store(Request $request)
    {
        // params list
        // first_name
        // middle_name
        // last_name
        // email
        // mobile
        // source
        // title
        // notes

        if ($request->mobile) {
            $data = Data::where('phone', $request->mobile)->where('source', $request->source)->first();
            if ($data != null) {
                return response()->json(['success' => false, 'message' => "Mobile already found in this source"]);
            }
        }

        if ($request->email) {
            $data = Data::where('email', $request->email)->where('source', $request->source)->first();
            if ($data != null) {
                return response()->json(['success' => false, 'message' => "Email already found in this source"]);
            }
        }

        if ($request->mobile == null && $request->email == null) {
            return response()->json(['success' => false, 'message' => "You should pass email or mobile"]);
        }

        try {
            $fName = $request->first_name;
            $mName = $request->middle_name;
            $lName = $request->last_name;
            $name = $fName . ' ' . $mName . ' ' . $lName;
            $email = $request->email;
            $phone = $request->mobile;
            $mobile = $request->mobile;
            $source = $request->source;
            $title = $request->title;
            $comment = $request->notes;
            $address = $request->address;

            // $campaign_name = $request->campaign_name;
            // $project = $request->project;
            // $phone_whatsapp = $request->phone_whatsapp;

            $data = Data::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'mobile' => $mobile,
                'phone_whatsup' => $phone,
                'address' => $address,
                'source' => $source,
                'data_status' => 8,
                'is_campaign' => 1
            ]);

            // get admin user
            $user = User::where('email', 'property_finder@remaxnetworkhome.com')->first();
            if ($user == null) {
                $user = User::create([
                    'name' => 'Property Finder',
                    'email' => 'property_finder@remaxnetworkhome.com',
                    'role_id' => '8',
                ]);
            }

            $leads = new booktable;
            $leads->data_id = $data->id;
            $leads->title = $title;
            $leads->name = $name;
            $leads->email = $email;
            $leads->phone = $phone;
            $leads->mobile = $mobile;
            $leads->source = $source;
            // $leads->campaign_name = $campaign_name;
            $leads->phone_whatsapp = $phone;
            $leads->comment = $comment;
            // $leads->project = $project;
            $leads->previous_state = '0';
            $leads->previous_state_id = $data->id;
            $leads->created_by = $user->id;
            $leads->save();

            return response()->json(['success' => true, 'message' => 'Lead created successfully']);
        } catch (Exception $th) {
            Log::warning('Server error happen while adding new lead from property finder portal', ['details' => $th->getMessage()]);
            $details = [
                'source' => 'Property finder integration',
                'message' => $th->getMessage()
            ];
            $this->sendErrorEmail([], $details);

            return response()->json(['success' => false, 'message' => 'server error'], 500);
        }
    }

    public function facebook_jvc_lead_store()
    {
        // params list
        // email
        // full_name
        // phone_number

        try {
            $api_key = config('services.facebook.access_token');
            $url = 'https://graph.facebook.com/v14.0/619254256585380/leads?limit=999999';
            $headers = array(
                'Authorization:' . $api_key,
                'accept: application/json',
                'Content-Type: application/json'
            );
            // Open connection
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute post
            $result = curl_exec($ch);
            $data = json_decode($result);
            if (isset(json_decode($result)->error)) {
                Log::critical('Facebook JVC leads import error _ ' . json_decode($result)->error->message);
                $details = [
                    'source' => 'Facebook JVC leads import error',
                    'message' => json_decode($result)->error->message
                ];
                $this->sendErrorEmail([], $details);
                exit();
            }
            $leads_array = [];
            foreach ($data->data as $key => $item) {
                $columns = $item->field_data;
                $email = '';
                $full_name = '';
                $phone_number = '';
                foreach ($columns as $key => $column) {
                    if ($column->name == "email")
                        $email = $column->values[0];
                    if ($column->name == "full_name")
                        $full_name = $column->values[0];
                    if ($column->name == "phone_number")
                        $phone_number = $column->values[0];
                }
                $leads_array[] = [
                    'name' => $full_name,
                    'email' => $email,
                    'phone' => $phone_number
                ];
            }

            // get jvc user
            $user = User::where('email', 'facebook_jvc@remaxnetworkhome.com')->first();
            if ($user == null) {
                $user = User::create([
                    'name' => 'Facebook JVC',
                    'email' => 'facebook_jvc@remaxnetworkhome.com',
                    'role_id' => '8',
                ]);
            }

            // get admins list
            $admins = User::where('role_id', 1)->get();
            $admins_list = [];
            foreach ($admins as $key => $admin) {
                $admins_list[] = ["email" => $admin->email, "name" => $admin->name];
            }

            $unimported_leads = [];
            foreach ($leads_array as $key => $lead) {
                try {
                    $data = Data::firstOrCreate([
                        'phone' => $lead['phone'],
                        'source' => 'jvc'
                    ], [
                        'name' => $lead['name'],
                        'email' => $lead['email'],
                        'phone' => $lead['phone'],
                        'mobile' => $lead['phone'],
                        'phone_whatsup' => $lead['phone'],
                        'source' => 'jvc',
                        'data_status' => 8,
                        'is_campaign' => 1
                    ]);
                } catch (Exception $th) {
                    $unimported_leads[] = $lead['name'];
                }

                try {
                    $booktable = booktable::firstOrCreate([
                        'phone' => $lead['phone'],
                        'source' => 'jvc'
                    ], [
                        'data_id' => $data->id,
                        'name' => $data->name,
                        'email' => $data->email,
                        'phone' => $data->phone,
                        'mobile' => $data->mobile,
                        'mobile' => $data->mobile,
                        'source' => $data->source,
                        'phone_whatsapp' => $data->mobile,
                        'previous_state' => 0,
                        'previous_state_id' => $data->id,
                        'created_by' => $user->id
                    ]);

                    if ($booktable->wasRecentlyCreated) {

                        $details = [
                            "admin_name" => "Admin",
                            "data_source" => $data->source
                        ];
                        $this->sendEmailNewLeadAdmin($admins_list, $details);
                    }
                } catch (Exception $th) {
                    if ($data)
                        Data::where('id', $data->id)->delete();
                    if ($booktable)
                        booktable::where('id', $booktable->id)->delete();
                }
            }
            if (count($unimported_leads) > 0) {
                Log::critical('unimported names _ ' . json_encode($unimported_leads));
            }

            Log::info("Leads imported from facebook jvc successfully");
        } catch (Exception $th) {
            Log::warning('Server error happen while adding new lead from facebook jvc source', ['details' => $th->getMessage()]);
            $details = [
                'source' => 'Facebook JVC leads import error',
                'message' => json_decode($result)->error->message
            ];
            $this->sendErrorEmail([], $details);
            exit();
        }
    }

    public function facebook_westwood_lead_store()
    {
        // note
        // this leads source should be assigned to chakir@remaxnetworkhome.com
        // params list
        // email
        // full_name
        // phone_number

        try {
            $api_key = config('services.facebook.access_token');
            $url = 'https://graph.facebook.com/v14.0/1096099161112767/leads?limit=999999';
            $headers = array(
                'Authorization:' . $api_key,
                'accept: application/json',
                'Content-Type: application/json'
            );
            // Open connection
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute post
            $result = curl_exec($ch);
            $data = json_decode($result);
            if (isset(json_decode($result)->error)) {
                Log::critical('Facebook westwood leads import error _ ' . json_decode($result)->error->message);
                $details = [
                    'source' => 'Facebook westwood leads import error',
                    'message' => json_decode($result)->error->message
                ];
                $this->sendErrorEmail([], $details);
                exit();
            }
            $leads_array = [];
            foreach ($data->data as $key => $item) {
                $columns = $item->field_data;
                $email = '';
                $full_name = '';
                $phone_number = '';
                foreach ($columns as $key => $column) {
                    if ($column->name == "email")
                        $email = $column->values[0];
                    if ($column->name == "full_name")
                        $full_name = $column->values[0];
                    if ($column->name == "phone_number")
                        $phone_number = $column->values[0];
                }
                $leads_array[] = [
                    'name' => $full_name,
                    'email' => $email,
                    'phone' => $phone_number
                ];
            }

            // get westwood user
            $user = User::where('email', 'facebook_westwood@remaxnetworkhome.com')->first();
            if ($user == null) {
                $user = User::create([
                    'name' => 'Facebook Westwood',
                    'email' => 'facebook_westwood@remaxnetworkhome.com',
                    'role_id' => '8',
                ]);
            }

            // get chakir@remaxnetworkhome.com account
            $chakir = User::where('email', 'chakir@remaxnetworkhome.com')->first();

            // get admins list
            $admins = User::where('role_id', 1)->get();
            $admins_list = [];
            foreach ($admins as $key => $admin) {
                $admins_list[] = ["email" => $admin->email, "name" => $admin->name];
            }

            $unimported_leads = [];
            foreach ($leads_array as $key => $lead) {
                try {
                    $data = Data::firstOrCreate([
                        'phone' => $lead['phone'],
                        'source' => 'westwood'
                    ], [
                        'name' => $lead['name'],
                        'email' => $lead['email'],
                        'phone' => $lead['phone'],
                        'mobile' => $lead['phone'],
                        'phone_whatsup' => $lead['phone'],
                        'source' => 'westwood',
                        'data_status' => 8,
                        'is_campaign' => 1,
                        'assigned' => 1
                    ]);
                } catch (Exception $th) {
                    $unimported_leads[] = $lead['name'];
                }

                try {
                    $booktable = booktable::firstOrCreate([
                        'phone' => $lead['phone'],
                        'source' => 'westwood'
                    ], [
                        'data_id' => $data->id,
                        'name' => $data->name,
                        'email' => $data->email,
                        'phone' => $data->phone,
                        'mobile' => $data->mobile,
                        'mobile' => $data->mobile,
                        'source' => $data->source,
                        'phone_whatsapp' => $data->mobile,
                        'previous_state' => 0,
                        'previous_state_id' => $data->id,
                        'created_by' => $user->id,
                        'assigned' => 1
                    ]);

                    if ($booktable->wasRecentlyCreated) {
                        if ($chakir) {
                            UserLeadsPool::create([
                                'user_id' => $chakir->id,
                                'leads_pool_id' => $booktable->id
                            ]);
                        }

                        $details = [
                            "admin_name" => "Admin",
                            "data_source" => $data->source
                        ];
                        $this->sendEmailNewLeadAdmin($admins_list, $details);
                    }
                } catch (Exception $th) {
                    if ($data)
                        Data::where('id', $data->id)->delete();
                    if ($booktable)
                        booktable::where('id', $booktable->id)->delete();
                }
            }

            Log::info("Leads imported from facebook westwood successfully");
        } catch (Exception $th) {
            Log::warning('Server error happen while adding new lead from facebook westwood source', ['details' => $th->getMessage()]);
            $details = [
                'source' => 'Facebook westwood leads import error',
                'message' => json_decode($result)->error->message
            ];
            $this->sendErrorEmail([], $details);
            exit();
        }
    }

    public function facebook_miami_lead_store()
    {
        // note
        // params list
        // email
        // full_name
        // phone_number

        try {
            $api_key = config('services.facebook.access_token');
            $url = 'https://graph.facebook.com/v14.0/1587200395028442/leads?limit=999999';
            $headers = array(
                'Authorization:' . $api_key,
                'accept: application/json',
                'Content-Type: application/json'
            );
            // Open connection
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute post
            $result = curl_exec($ch);
            $data = json_decode($result);
            if (isset(json_decode($result)->error)) {
                Log::critical('Facebook miami leads import error _ ' . json_decode($result)->error->message);
                $details = [
                    'source' => 'Facebook miami leads import error',
                    'message' => json_decode($result)->error->message
                ];
                $this->sendErrorEmail([], $details);
                exit();
            }
            $leads_array = [];
            foreach ($data->data as $key => $item) {
                $columns = $item->field_data;
                $email = '';
                $full_name = '';
                $phone_number = '';
                foreach ($columns as $key => $column) {
                    if ($column->name == "email")
                        $email = $column->values[0];
                    if ($column->name == "full_name")
                        $full_name = $column->values[0];
                    if ($column->name == "phone_number")
                        $phone_number = $column->values[0];
                }
                $leads_array[] = [
                    'name' => $full_name,
                    'email' => $email,
                    'phone' => $phone_number
                ];
            }

            // get miami user
            $user = User::where('email', 'facebook_miami@remaxnetworkhome.com')->first();
            if ($user == null) {
                $user = User::create([
                    'name' => 'Facebook Miami',
                    'email' => 'facebook_miami@remaxnetworkhome.com',
                    'role_id' => '8',
                ]);
            }

            // get admins list
            $admins = User::where('role_id', 1)->get();
            $admins_list = [];
            foreach ($admins as $key => $admin) {
                $admins_list[] = ["email" => $admin->email, "name" => $admin->name];
            }

            $unimported_leads = [];
            foreach ($leads_array as $key => $lead) {
                try {
                    $data = Data::firstOrCreate([
                        'phone' => $lead['phone'],
                        'source' => 'miami'
                    ], [
                        'name' => $lead['name'],
                        'email' => $lead['email'],
                        'phone' => $lead['phone'],
                        'mobile' => $lead['phone'],
                        'phone_whatsup' => $lead['phone'],
                        'source' => 'miami',
                        'data_status' => 8,
                        'is_campaign' => 1,
                        'assigned' => 0
                    ]);
                } catch (Exception $th) {
                    $unimported_leads[] = $lead['name'];
                }

                try {
                    $booktable = booktable::firstOrCreate([
                        'phone' => $data->phone,
                        'source' => $data->source
                    ], [
                        'data_id' => $data->id,
                        'name' => $data->name,
                        'email' => $data->email,
                        'phone' => $data->phone,
                        'mobile' => $data->mobile,
                        'mobile' => $data->mobile,
                        'source' => $data->source,
                        'phone_whatsapp' => $data->mobile,
                        'previous_state' => 0,
                        'previous_state_id' => $data->id,
                        'created_by' => $user->id,
                        'assigned' => 0
                    ]);

                    if ($booktable->wasRecentlyCreated) {
                        $details = [
                            "admin_name" => "Admin",
                            "data_source" => $data->source
                        ];
                        $this->sendEmailNewLeadAdmin($admins_list, $details);
                    }
                } catch (Exception $th) {
                    if ($data)
                        Data::where('id', $data->id)->delete();
                    if ($booktable)
                        booktable::where('id', $booktable->id)->delete();
                }
            }

            Log::info("Leads imported from facebook miami successfully");
        } catch (Exception $th) {
            Log::warning('Server error happen while adding new lead from facebook miami source', ['details' => $th->getMessage()]);
            $details = [
                'source' => 'Facebook miami leads import error',
                'message' => json_decode($result)->error->message
            ];
            $this->sendErrorEmail([], $details);
            exit();
        }
    }
}
