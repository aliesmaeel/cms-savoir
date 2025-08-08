<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AgentAttendance;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use DateTime;
use Exception;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function authenticated(Request $request)
    {
        try{
            if (Auth::user()->isagent()) {
                AgentAttendance::create([
                'agent_id' => Auth::user()->id,
                'start_time' => Carbon::now()->toDateTimeString(),
                'end_time' => null,
                'duration'=> null,
                'date' => null,
                ]);
            }
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
    public function logout(Request $request) {
        try{
            if (Auth::user()->isagent()) {
                $timenow=Carbon::now()->toDateTimeString();
                $user = AgentAttendance::where('agent_id', Auth::user()->id)->where('end_time',null)->first();
                $user->end_time = $timenow;
                $user->save();
  
                $userminute = AgentAttendance::where('agent_id', Auth::user()->id)->where('end_time',$timenow)->first();
                $dteStart = new DateTime($userminute->start_time);
                $dteEnd   = new DateTime($userminute->end_time);
                $dteDiff  = $dteStart->diff($dteEnd);
                $parts = explode(':',$dteDiff->format("%H:%I"));
                $totalMinuts = $parts[0]*60 + $parts[1];
                $user->duration=$totalMinuts;
                $user->date = Carbon::now();
                $user->save();

            }
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
        Auth::logout();
        return redirect('/login');
      }
}
