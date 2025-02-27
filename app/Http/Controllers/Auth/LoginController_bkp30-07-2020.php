<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Role;
use Session;
use Auth;
use DB;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $msg='Invalid User Name / Password';
        \Session::flash('message', $msg);
        $errors = ["username" => trans('auth.failed')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only("username", 'remember'))
            ->withErrors($errors);
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required', 'password' => 'required',
        ]);
    }

    protected function credentials(Request $request)
    {
        return [
            $this->username() => $request->input($this->username()),
            'password'        => $request->input('password'),
        ];
    }

    public function authenticated(Request $request, $user)
    {
        $leave_details = Role::getAll_EmployeeLeave(Auth::user()->id);
        
       /*  if(!empty($leave_details)) {
            $this->UserLeaveStatus($request->email,$leave_details);
        } */

        $user->is_logged = '1';
        $user->last_login_ip = $request->getClientIp();
       
        $user->update(); 
        $holiday_details = Role::get_Holidays();
        $emp_wrk_status = ($holiday_details!='')?"Reject":"Accept";     
        DB::table('entrance_logs')->insert(
            ['user_id' => Auth::user()->id, 
            'loged_in_at' => date('Y-m-d H:i:s'),
            'work_type'=>$request->work_type,
            'emp_wrk_status'=>$emp_wrk_status]);

        setcookie('username', $user->name);
        setcookie('empid', $user->emp_id);
        setcookie('empemailid', $user->email);
        setcookie('manager', $user->group_email);

        $datas = array(
            'data-username' => $user->name,
            'data-empid' => $user->emp_id,
            'data-emailtext' => $user->name.' logged in at '.date('l jS \of F Y h:i:s A'),
            'data-empemailid' => $user->email,
            'data-manager' => $user->group_email,
            'data-empworktype' => $request->work_type,
        );
        $email_array = array(
            'template_name' => 'emails.user_loginreminder',
            'Subject' => 'Compuscript Employee Login Notification',
            'datas' => $datas,
        );

        $email_send = Role::common_emails($email_array);
    }

    public function logout(Request$request) {
        $user = Auth::user();
        $user->is_logged = '0';
        $user->last_logout_ip = $request->getClientIp();
        $user->save();

        /* Enterance log calculation */

        $EntranceLog = DB::table('entrance_logs')
            ->select('*')
            ->where('loged_in_at', '>=', date('Y-m-d H:i:s', time() - 86400))
            ->whereNull('loged_out_at')
            ->where('user_id', '=', Auth::user()->id)
            ->orderBy('loged_in_at', 'desc')->first();

        if ($EntranceLog) {
            $loged_out_at = date('Y-m-d H:i:s');            
            DB::table('entrance_logs')->where('user_id', $EntranceLog->user_id)->where('id',
                $EntranceLog->id)->update(['loged_out_at' => $loged_out_at]);            
            $hours = strtotime($EntranceLog->loged_out_at) - strtotime($EntranceLog->
                loged_in_at);
            $hours /= 3600;
            $hours = (double)$hours;

            $LoginHour = DB::table('login_hours')->select('*')->where('user_id', '=', Auth::
                user()->id)->first();
            $LoginHour_user_id = Auth::user()->id;

            $LoginHourhours =  $hours;

            $hrs =8;
            $logged_out_time = date('H:i',strtotime($EntranceLog->loged_in_at)+ 60*60*$hrs);
            $current_logout =  date('H:i',strtotime($loged_out_at));

            // echo $early_exits_hrs = $logged_out_time-$current_logout;
            $to_time = strtotime($logged_out_time);
            $from_time = strtotime($current_logout);
            $early_exits_hrs = round(abs($to_time - $from_time) / 60,2);
            $early_exits_hrs =  round(($early_exits_hrs/60),3). " Hrs";

            $data_early_exist = ($logged_out_time!=$current_logout)?"".$early_exits_hrs:"";
           
            DB::table('login_hours')->insert(['user_id' => $LoginHour_user_id, 'hours' => $LoginHourhours]);
            
            DB::table('users')->where('id',$LoginHour_user_id)->update(['emp_wrk_status' =>'Accept']);

            $user_Details = Role::getUserDetailsByUserId(Auth::user()->id);
            $holiday_details = Role::get_Holidays();

            $datas = array(            
                'data-username' =>$user_Details->name,
                'data-empid' => $user_Details->emp_id,
                'data-department' =>$user_Details->dept_name,
                'data-manager' =>$user_Details->group_email,
                'data-empworktype' => $EntranceLog->work_type,
                'data-logged_in' => date('Y-m-d H:i A'),
                'data-log-content' => 'Log Out',
                'data-holiday' => ($holiday_details!='')?$holiday_details->holiday_type:"",
                'data-earlyexits' => $data_early_exist,
                'data-emp_id' =>$user_Details->emp_id
            );
            $subject ='Employee Logout Notification --'.$user_Details->name.'--'.$user_Details->emp_id."--".$data_early_exist;
            $email_array = array(
                'template_name' =>'emails.login_notification',
                'Subject' =>$subject,
                'datas' =>$datas
            );
            $email_send = Role::common_emails($email_array);
        }
        /* Enterance log calculation End */

        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }
}
