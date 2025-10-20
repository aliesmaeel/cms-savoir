<?php

namespace App\Http\Controllers;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use SendEmailT;
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function createuserindex()
    {
        return view('admin.createuser');
    }
     // create new agent
     public function createnewuser(Request $request)
     {
         if ($request->type == "3"||$request->type == "6") {
             $request->validate(
                 [
                     'name' => 'required',
                     'email' => 'required|email|unique:users,email',
                     'phone' => 'required|regex:/^\+(?:[0-9] ?){8,14}[0-9]$/',
                     'language' => 'required',
                     'type' => 'required',
                     'password' => 'required|required_with:password_confirm|same:password_confirm',
                     'websiteId' => 'required',
                     // 'brn' => 'required',
                     // 'bio' => 'required',
                     'Job_Description' => 'required',
                     'slug' =>'required',
                     // 'order' =>'required',
                 ]
             );
             // replace non letter or digits by divider
             $text = preg_replace('~[^\pL\d]+~u', '-', $request->slug);
             // transliterate
             $text = iconv('utf-8', 'utf-8//IGNORE', $text);

             // trim
             $text = trim($text, '-');

             // remove duplicate divider
             $text = preg_replace('~-+~', '-', $text);

             // lowercase
             $text = strtolower($text);

             if (empty($text)) {
                 $text = 'n-a';
             }else{
                 $slug = User::where('slug',$text)->get();
                 if(count($slug) > 0){
                     return response()->json(['success' => false, 'message' => 'This sulg already exists']);
                 }
             }
             $user = User::create([
                 'name' => $request->name,
                 'email' => $request->email,
                 'phone' => $request->phone,
                 'language' => $request->language,
                 'role_id' => $request->type,
                 'password' => Hash::make($request->password),
                 'websiteId' => $request->websiteId,
                 'brn' => $request->brn,
                 'bio' => $request->bio,
                 'Job_Description' => $request->Job_Description,
                 'slug' => $text,
                 'order' => $request->order,

             ]);
             if ($request->publish_to_web_site == '1') {
                 $user->update([
                     'publish_to_web_site' => '1',
                 ]);
             }
             $cloudName = "djd3y5gzw";

             if ($request->FloorPlan > 0) {
                 for ($x = 0; $x < $request->FloorPlan; $x++) {
                     if ($request->hasFile('floorplans' . $x)) {
                         $file = $request->file('floorplans');
                         $filename =uploadFile($file ,'image/Agent',false);
                         $originalUrl='https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/image/Agent/'.$filename;
                         $store = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);

                     }
                     $user->update([
                         'image' => $store
                     ]);
                 }
             }

             $details = [
                 'email' => $request->email,
                 'password' => $request->password
             ];

             try {
                 $details = [
                     'admin_name' => Auth::user()->name,
                     'created_date' => Carbon::parse($user->created_at)->format('Y-m-d h:m a'),
                     'role' => $user->role_id == 3 ? 'Agent' : 'Photographer',
                     'email' => $user->email,
                     'password' => $request->password,
                     'login_link' => route('login')
                 ];

                 $this->sendEmailNewUser([["email" => $user->email]],  $details);
                 // Mail::to($request->email)->send(new SendAgentInfoMail($details));
             } catch (Exception $th) {
                 // return response()->json(['success' => false, 'message' => 'Unable to send email to this user']);
             }


             if ($user != null)
                 return response()->json(['success' => true, 'message' => 'User created successfully']);
             else
                 return response()->json(['success' => false, 'message' => 'Error in creating new agent']);
         } else {
             $request->validate(
                 [
                     'name' => 'required',
                     'email' => 'required|email|unique:users,email',
                     'phone' => 'required|regex:/^\+(?:[0-9] ?){8,14}[0-9]$/',
                     'language' => 'required',
                     'type' => 'required',
                     'password' => 'required|required_with:password_confirm|same:password_confirm',
                 ]
             );

             $user = User::create([
                 'name' => $request->name,
                 'email' => $request->email,
                 'phone' => $request->phone,
                 'language' => $request->language,
                 'role_id' => $request->type,
                 'password' => Hash::make($request->password),
             ]);
             $details = [
                 'email' => $request->email,
                 'password' => $request->password
             ];

             try {
                 $details = [
                     'admin_name' => Auth::user()->name,
                     'created_date' => Carbon::parse($user->created_at)->format('Y-m-d h:m a'),
                     'role' => $user->role_id == 3 ? 'Agent' : 'Photographer',
                     'email' => $user->email,
                     'password' => $request->password,
                     'login_link' => route('login')
                 ];

                 $this->sendEmailNewUser([["email" => $user->email]],  $details);
                 // Mail::to($request->email)->send(new SendAgentInfoMail($details));
             } catch (Exception $th) {
                 // return response()->json(['success' => false, 'message' => 'Unable to send email to this user']);
             }


             if ($user != null)
                 return response()->json(['success' => true, 'message' => 'User created successfully']);
             else
                 return response()->json(['success' => false, 'message' => 'Error in creating new agent']);
         }
     }
     public function updateuserindex($id)
    {
        $user = User::find($id);
        // dd($user->id);
        if ($user->role_id == 4) {
            return view('admin.updatebuyer', ['username' => $user->name, 'userphone' => $user->phone, 'useremail' => $user->email, 'userid' => $id]);
        } else {
            return view('admin.updateuser', ['username' => $user->name, 'userphone' => $user->phone, 'useremail' => $user->email, 'userid' => $id, 'userlang' => $user->language, 'role' => $user->role_id, 'Job_Description' => $user->Job_Description, 'brn' => $user->brn, 'websiteId' => $user->websiteId, 'bio' => $user->bio, 'publish_to_web_site' => $user->publish_to_web_site, 'image' => $user->image, 'slug' => $user->slug,'order'=>$user->order,'user_id' => $user->id]);
        }
    }
    public function updateuser(Request $request)
    {
        if ($request->type == "3"||$request->type == "6") {
            $roles = [];
            $roles['email'] = 'required|unique:users,email,'.$request->user_id;
            $roles['name'] = 'required';
            $roles['language'] = 'required';
            $roles['type'] = 'required';
            if ($request->phone != null) {
                $roles['phone'] = 'regex:/^\+(?:[0-9] ?){8,14}[0-9]$/';
            }
            if ($request->password != null) {
                $roles['password'] = 'required_with:password_confirm|same:password_confirm';
            }
            $roles['websiteId'] = 'required';
            // $roles['brn'] = 'required';
            // $roles['bio'] = 'required';
            $roles['slug'] = 'required';

            // $roles['order'] = 'required';
            $roles['Job_Description'] = 'required';
            $request->validate($roles);

            try {
                $customer = User::where('id', $request->user_id)->first();

                // replace non letter or digits by divider
                $text = preg_replace('~[^\pL\d]+~u', '-', $request->slug);
                // transliterate
                $text = iconv('utf-8', 'utf-8//IGNORE', $text);

                // trim
                $text = trim($text, '-');

                // remove duplicate divider
                $text = preg_replace('~-+~', '-', $text);

                // lowercase
                $text = strtolower($text);

                if (empty($text)) {
                    $text = 'n-a';
                }else{
                    $slug = User::where('slug',$text)->where('id','!=',$customer->id)->get();
                    if(count($slug) > 0){
                        return response()->json(['success' => false, 'message' => 'This sulg already exists']);
                    }
                }
                $customer->name = $request->name;
                $customer->email = $request->email;
                $customer->language = $request->language;
                $customer->role_id = $request->type;
                if ($request->phone != null) {
                    $customer->phone = $request->phone;
                }
                if ($request->password != null) {
                    $customer->password = Hash::make($request->password);
                }
                $customer->websiteId = $request->websiteId;
                $customer->brn = $request->brn;
                $customer->bio = $request->bio;
                $customer->slug = $text;
                $customer->order = $request->order;
                $customer->Job_Description = $request->Job_Description;
                if ($request->publish_to_web_site == "1") {
                    $customer->update([
                        'publish_to_web_site' => '1',
                    ]);
                } else {
                    $customer->update([
                        'publish_to_web_site' => '0',
                    ]);
                }
                // dd($customer);
                // DB::table('user')->where('id', $id)->delete();
                $cloudName = "djd3y5gzw";

                if ($request->FloorPlan > 0) {
                    for ($x = 0; $x < $request->FloorPlan; $x++) {
                        if ($request->hasFile('floorplans' . $x)) {

                            $file = $request->file('floorplans'.$x);
                            $filename =uploadFile($file ,'image/Agent',false);
                            $originalUrl='https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/image/Agent/'.$filename;

                            $store = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);

                        }
                        $customer->update([
                            'image' => $store
                        ]);
                    }
                }
                $customer->save();


                if ($customer)
                    return response()->json(['success' => true, 'message' => 'Agent updated successfully']);
                else
                    return response()->json(['success' => false, 'message' => 'Error in updating agent data']);
            } catch (Exception $ex) {
                dd($ex->getMessage());
            }
        } else {
            $roles = [];
            $roles['email'] = 'required|unique:users,email,'.$request->user_id;
            $roles['name'] = 'required';
            $roles['language'] = 'required';
            $roles['type'] = 'required';
            if ($request->phone != null) {
                $roles['phone'] = 'regex:/^\+(?:[0-9] ?){8,14}[0-9]$/';
            }
            if ($request->password != null) {
                $roles['password'] = 'required_with:password_confirm|same:password_confirm';
            }
            $request->validate($roles);

            try {
                $customer = User::where('id', $request->user_id)->first();
                $customer->name = $request->name;
                $customer->email = $request->email;
                $customer->language = $request->language;
                $customer->role_id = $request->type;
                if ($request->phone != null) {
                    $customer->phone = $request->phone;
                }
                if ($request->password != null) {
                    $customer->password = Hash::make($request->password);
                }


                // dd($customer);
                // DB::table('user')->where('id', $id)->delete();
                $customer->save();
                if ($customer)
                    return response()->json(['success' => true, 'message' => 'Agent updated successfully']);
                else
                    return response()->json(['success' => false, 'message' => 'Error in updating agent data']);
            } catch (Exception $ex) {
                dd($ex->getMessage());
            }
        }
    }
    public function listusersindex()
    {
        return view('admin.listusers');
    }
    public function listusers(Request $request)
    {
        if (Auth::user()->isadmin()) {
            $users = User::wherenotIn('role_id', ['1', '5'])->orderBy('created_at', 'DESC')->get();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('role', function ($row) {
                    if ($row->role_id == '2')
                        return 'Consultant';
                    else if ($row->role_id == '3')
                        return 'Agent';
                    else if ($row->role_id == '2,3')
                        return 'Consultant Agent';
                    else if ($row->role_id == '4')
                        return 'Customer';
                    else if ($row->role_id == '6')
                        return 'Photographer';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    $actionBtn .= '<a class="edit btn btn-info btn-sm">Edit</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            $users = User::where('role_id', 'not like', '%5%')->orderBy('created_at', 'DESC')->get();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('role', function ($row) {
                    if ($row->role_id == '2')
                        return 'Consultant';
                    else if ($row->role_id == '3')
                        return 'Agent';
                    else if ($row->role_id == '2,3')
                        return 'Consultant Agent';
                    else if ($row->role_id == '4')
                        return 'Customer';
                    else if ($row->role_id == '6')
                        return 'Photographer';
                    else if ($row->role_id == '1')
                        return 'Admin';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    $actionBtn .= '<a class="edit btn btn-info btn-sm">Edit</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function deleteuser(Request $request)
    {
        $user = User::find($request->id);
        if ($user){
            deleteFile($user->image);
            $user->delete();
            return response()->json(['success' => true, 'message' => 'User has been deleted successfully']);
        }
        else{
            return response()->json(['success' => true, 'message' => 'Error while deleting user']);
        }

    }
    public function createbuyerindex()
    {
        return view('admin.createbuyer');
    }
    // create new buyers
    public function createnewbuyer(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email'
            ],
            [
                'required' => 'The :attribute field is required.',
                'unique' => ':attribute is already used',
            ]
        );
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            // 'password' => Hash::make($request->password),
            'role_id' => '4',
        ]);
        if ($user != null)
            return response()->json(['success' => true, 'message' => 'Buyer created successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error in creating new buyer']);
    }
    public function updatebuyer(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'name' => 'required'
        ]);
        try {
            $customer = User::where('email', $request->email)
                ->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email
                ]);
            if ($customer)
                return response()->json(['success' => true, 'message' => 'Buyer updated successfully']);
            else
                return response()->json(['success' => false, 'message' => 'Error in updating buyer data']);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
    public function createsuperAdmin()
    {
        return view('admin.createadmin');
    }
    public function storesuperAdmin(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->toArray(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'required|required_with:password_confirm|same:password_confirm'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
                'status' => false
            ]);
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->role_id = '1';
        $user->save();
        if ($user) {
            return response()->json([
                'messege' => 'Created Admin  Successfully',
                'status' => true
            ]);
        } else {
            return response()->json([
                'errors' => 'Error In  Creating  Admin Successfully',
                'status' => false
            ]);
        }
    }
}
