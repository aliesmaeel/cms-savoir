<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function createpaymentindex()
    {
        $properties = Property::pluck("name");
        $users = User::select("id", "name")->where('role_id', '4')->get();
        return view('admin.createpayment')->with('properties', $properties)->with('users', $users);
    }
    public function createnewpayment(Request $request)
    {
        $request->validate(
            [
                'buyerid' => 'required|exists:users,id',
                'property' => 'required|exists:properties,name',
                'amount' => 'required',
                'Paymentdate' => 'required',
            ]
        );
        try {
            $property = Property::where('name', $request->property)->first();
            $totalpayments = Payment::where('buyer_id', $request->buyerid)->where('property', $request->property)->sum('payment_amount');
            if ($totalpayments > 0) {
                $remaining = $property->price - $totalpayments;
                if ($request->amount > $remaining)
                    return response()->json(['success' => false, 'message' => 'Property remaining amount is ' . $remaining . ' payment should be less than']);
            } else {
                if ($request->amount > $property->price)
                    return response()->json(['success' => false, 'message' => 'Property remaining amount is ' . $property->price . ' payment should be less than']);
            }
            $payment = Payment::create([
                'buyer_id' => $request->buyerid,
                'property' => $request->property,
                'payment_amount' => $request->amount,
                'date_of_payment' => $request->Paymentdate,
                'payment_status' => array_search('Paid', config('payment.payment_status'))
            ]);

            if ($payment != null)
                return response()->json(['success' => true, 'message' => 'Payment created successfully']);
            else
                return response()->json(['success' => false, 'message' => 'Error in creating new payment']);
            //code...
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
    public function listpaymentsindex()
    {
        if (Auth::user()->isadmin()) {
            $users = User::select('id', 'name')->where('role_id', 'LIKE', '%4%')->get();
            $properties = Property::select('name')->get();
            return view('admin.listpayments')->with('users', $users)->with('properties', $properties);
        } else if (Auth::user()->iscustomer()) {
            $properties = Property::select('name')->get();
            return view('admin.listcustomerpayments')->with('properties', $properties);
        }
    }
    public function listpayments(Request $request)
    {
        if (Auth::user()->isadmin()) {
            if ($request->propertyname == null) {
                $payments = Payment::where('buyer_id', $request->userid)->orderBy('created_at', 'DESC')->get();
                $users = User::select('id', 'name')->get();
            } else {
                $payments = Payment::where('buyer_id', $request->userid)->where('property', $request->propertyname)->orderBy('created_at', 'DESC')->get();
                $users = User::select('id', 'name')->get();
            }
            return DataTables::of($payments)
                ->addIndexColumn()
                ->addColumn('Buyer_name1', function ($row) use ($users) {
                    $buyername = $users->where('id', $row->buyer_id)->pluck('name')->first();
                    return $buyername;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else if (Auth::user()->iscustomer()) {
            if ($request->propertyname == null) {
                $payments = Payment::where('buyer_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
            } else {
                $payments = Payment::where('buyer_id', Auth::user()->id)->where('property', $request->propertyname)->orderBy('created_at', 'DESC')->get();
            }
            return DataTables::of($payments)
                ->addIndexColumn()
                ->addColumn('Buyer_name1', function ($row) {
                    return Auth::user()->name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function deletepayment(Request $request)
    {
        $payment = Payment::destroy($request->id);
        if ($payment)
            return response()->json(['success' => true, 'message' => 'Payment has been deleted successfully']);
        else
            return response()->json(['success' => true, 'message' => 'Error while deleting paymnet']);
    }
}
