<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Data;
use App\Models\UserData;
use App\Models\booktable;
use Illuminate\Http\Request;
use App\Models\UserDataComment;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function createcustomerindex()
    {
        return view('adminagent.createcustomer');
    }
    public function createnewcustomer(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required_if:,null&email&unique:users,email',
                'phone' => 'required_if:email,null&regex:/^\+(?:[0-9] ?){8,14}[0-9]$/',
                // 'password' => 'required|required_with:password_confirm|same:password_confirm'
            ],
            [
                'required' => 'The :attribute field is required.',
                'unique' => ':attribute is already used',
                // 'same'    => 'passwrod and confirmed password should be equal',
            ]
        );

        /////////// add to data
        $data = Data::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'source' => "customer enquiry",
            'project' => $request->projectname,
            'agents' => Auth::user()->name,
            'data_status' => 8,
            'previous_status' => 0
        ]);

        /////////// asign to user
        UserData::create([
            'user_id' => Auth::user()->id,
            'data_id' => $data->id
        ]);

        // add comment
        UserDataComment::create([
            'user_id' => Auth::user()->id,
            'data_id' => $data->id,
            'comment' => $request->notes,
            'userstatus' => "Interested"
        ]);

        // add data to leads pool
        $user = booktable::create([
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $data->phone,
            'source' => $data->source,
            'project' => $data->project,
            'title' => $data->unique,
            'data_id' => $data->id,
            'previous_state' => '0',
            'previous_state_id' => $data->id,
            'created_by' => Auth::user()->id,
            'is_enquiry_customer' => true,
        ]);

        if ($user != null)
            return response()->json(['success' => true, 'message' => 'Customer created successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error in creating new customer']);
    }
    public function updatecustomerindex($id)
    {
        $customer = booktable::where('id', $id)->first();
        return view('admin.updatecustomer', ['username' => $customer->name, 'userphone' => $customer->phone, 'useremail' => $customer->email, 'projectname' => $customer->project, 'notes' => $customer->notes, 'userid' => $id]);
    }
    public function updatecustomer(Request $request)
    {
        $request->validate([
            'userid' => 'required|exists:booktables,id',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^\+(?:[0-9] ?){8,14}[0-9]$/',
        ]);
        try {
            $customer = booktable::find($request->userid);
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            if ($request->projectname != null)
                $customer->project = $request->projectname;
            if ($request->notes != null)
                $customer->comment = $request->notes;
            $res = $customer->save();

            if ($res)
                return response()->json(['success' => true, 'message' => 'Customer updated successfully']);
            else
                return response()->json(['success' => false, 'message' => 'Error in updating customer data']);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function deletecustomer(Request $request)
    {
        $booktable = booktable::find($request->id);
        UserDataComment::where('data_id', $booktable->data_id)->where('user_id', $booktable->created_by)->delete();
        UserData::where('data_id', $booktable->data_id)->where('user_id', $booktable->created_by)->delete();
        Data::destroy($booktable->data_id);
        $booktable->Delete();
        return response()->json(['success' => true, 'message' => 'Customer has been deleted successfully']);
    }
}
