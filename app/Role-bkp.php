<?php

namespace App;

use DB;

class Role extends \Spatie\Permission\Models\Role
{
    public static function getTeam()
    {
        $teams = DB::table('team')->select('id', 'team_name')->get()->toArray();
        return $teams;
    }

    public static function getTeamById($userId)
    {
        $team = DB::table('user_team')->select('team_id')->where('user_id', '=', $userId)->first();
        return $team;
    }

    public static function getCategoryById($userId)
    {
        $category = DB::table('users')->select('emp_category')->where('id', '=', $userId)->first();
        return $category;
    }

    public static function getCategory()
    {
        $category = DB::table('employee_category')->select('id', 'type')->get()->toArray();
        return $category;
    }

    public static function getDepartment()
    {
        $department = DB::table('department')->select('dept_id', 'dept_name')->where('dept_status', '=', 'Active')->get()->toArray();
        return $department;
    }

    public static function getDepartmentById($userId)
    {
        $category = DB::table('users')->select('department')->where('id', '=', $userId)->first();
        return $category;
    }

    public static function getGroupEmails()
    {
        $category = DB::table('group_emails')->select('gemail_id', 'group_emailids')->where('emailid_status', '=', 'Active')->get()->toArray();
        return $category;
    }

    public static function getEmailidById($userId)
    {
        $category = DB::table('users')->select('group_email')->where('id', '=', $userId)->first();
        return $category;
    }

    public static function getJobAssign()
    {
        $category = DB::table('job_assging')->select('ja_name', 'ja_id')->where('ja_status', '=', 'Active')->get()->toArray();
        return $category;
    }

    public static function getJobById($userId)
    {
        $job = DB::table('users')->select('job')->where('id', '=', $userId)->first();
        return $job;
    }
    public static function getLogindetail($user_id)
    {
        $today_date = date("Y-m-d");
        $logindetails = DB::table('entrance_logs')->select('loged_in_at', 'loged_out_at', 'user_id', 'work_type')
        //->where('loged_in_at', 'like', '%"'.DB::raw($today_date).'"%')
            ->where('loged_in_at', 'like', $today_date . '%')
            ->where('user_id', '=', $user_id)
        //->groupBy(DB::raw('Date(loged_in_at)'))
            ->orderBy('loged_in_at', 'ASC')
            ->first();

        //dd($logindetails); exit;
        return $logindetails;
    }

    public static function getShiftTime()
    {
        $shift_time = DB::table('shift_time')->select('id', 'shift_start', 'shift_end')->where('shit_status', '=', 'Active')->get()->toArray();
        return $shift_time;
    }

    public static function getWeekTimeSheet($user_id)
    {

        $timeSheet = DB::select(DB::raw("SELECT *,shift_time.shift_start,shift_time.shift_end
		FROM   employee_shifttime INNER JOIN shift_time on shift_time.id=employee_shifttime.shift_time
		WHERE  YEARWEEK(`shift_start_date`, 1) = YEARWEEK(CURDATE(), 1) and YEARWEEK(`shift_end_date`, 1) = YEARWEEK(CURDATE(), 1) and shift_emp_id= :params"), array(
            'params' => $user_id,
        ));
        return $timeSheet;

    }

    public static function getEmployeeDesignation()
    {

        $shift_time = DB::table('employee_designation')->select('id', 'emp_designation')->where('emp_degstatus', '=', 'Active')->get()->toArray();
        return $shift_time;

    }

    public static function getDesignationById($userId)
    {
        $designation = DB::table('users')->select('designation')->where('id', '=', $userId)->first();
        return $designation;
    }

    public static function getEmpFloorDetails()
    {

        $floor_details = DB::table('emp_floor')->select('id', 'emp_floor')->where('emp_floorstatus', '=', 'Active')->get()->toArray();
        return $floor_details;

    }

    public static function getFloorById($userId)
    {
        $floor = DB::table('users')->select('emp_floor')->where('id', '=', $userId)->first();
        return $floor;

    }

    public static function getIntercom()
    {

        $intercom_details = DB::table('emp_intercome')->select('id', 'emp_intercomeno')->where('emp_phonestatus', '=', 'Active')->get()->toArray();
        return $intercom_details;

    }

    public static function getIntercombyId($userid)
    {
        $floor = DB::table('users')->select('emp_intercomeno')->where('id', '=', $userid)->first();
        return $floor;
    }

    public static function getFloordetails($floor_id)
    {
        $floor_details = DB::table('emp_floor')->select('id', 'emp_floor')->where('id', '=', $floor_id)->get()->toArray();
        return $floor_details;

    }

    public static function getDepartmentdetails($department_id)
    {
        $deparment_details = DB::table('department')->select('dept_id', 'dept_name')->where('dept_id', '=', $department_id)->get()->toArray();
        return $deparment_details;

    }

    public static function getIntercomdetails($intercom_id)
    {
        $intercom_details = DB::table('emp_intercome')->select('id', 'emp_intercomeno')->where('id', '=', $intercom_id)->get()->toArray();
        return $intercom_details;

    }

    public static function getDesignationdetails($design_id)
    {
        $designation_details = DB::table('employee_designation')->select('*')->where('id', '=', $design_id)->get()->toArray();
        return $designation_details;

    }

    public static function password_encrptstring()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pin = mt_rand(1000000, 9999999)
        . mt_rand(1000000, 9999999)
            . $characters[rand(0, strlen($characters) - 1)];

        // shuffle the result
        return $string = str_shuffle($pin);

    }

    public static function getUserDetails($email_id)
    {
        $user_Details = DB::table('users')->select('*')->where('email', '=', $email_id)->first();
        return $user_Details;
    }

    public static function getUserDetailsByUserId($user_id)
    {
        $user_DetailsById = DB::table('users')->select('*')->where('id', '=', $user_id)
            ->join('department', 'department.dept_id', '=', 'users.department')
            ->first();
        return $user_DetailsById;
    }

    public static function getUserDetailsByUseremail($email_id)
    {
        $user_DetailsById = DB::table('users')->select('*')->where('email', '=', $email_id)
            ->join('department', 'department.dept_id', '=', 'users.department')
            ->first();
        return $user_DetailsById;
    }

    /**
     * Forget Password Email Functionality
     */

    public static function common_emails($email_array)
    {
        $data['users'] = $email_array;
        $Subject = $email_array['Subject'];
        $team_name = 'Compuscript Admin Team';
        $from_email = 'brohendry07@gmail.com';
        $to_email =  $email_array['datas']['data-manager'];  // 'muhammed@pdmrindia.com'; 
       // $cc_email = 'brohendry07@gmail.com';
        $cc_email = 'brohendry07@gmail.com';
        $email_template = $email_array['template_name'];
    

        if(strcmp($email_array['Subject'],"Compuscript Forget Password")==0) {

                try {
                    \Mail::send($email_template, $data, function ($message) use ($Subject, $team_name, $from_email, $to_email, $cc_email) {

                        $message->to($to_email, 'Dear Manager')->subject($Subject);
                        $message->cc($cc_email, 'Dear Admin');
                        $message->from($to_email, $team_name);
                    });
                    return "Success";
                } catch (Exception $ex) {
                    dd($ex->getMessage());
                    return "We've got errors!";
                }

        }

        if(strcmp($email_array['Subject'],"Compuscript Employee Leave Notification")==0) {

                    try {
                        \Mail::send($email_template, $data, function ($message) use ($Subject, $team_name, $from_email, $to_email, $cc_email) {

                            $message->to($to_email, 'Dear Manager')->subject($Subject);
                            // $message->bcc($cc_email, 'Dear Admin');
                            $message->from($to_email, $team_name);
                        });
                        return "Success";
                    } catch (Exception $ex) {
                        dd($ex->getMessage());
                        return "Try again later!"; 
                    } 

        }
    }

    /**
     * Displayed the holidays in login Page
     * Author : Muhammed Gani
     */

    public static function get_Holidays()
    {

        $today_date = date('Y-m-d');
        $holidays_Details = DB::table('holidays')->select('*')->where('date', '=', $today_date)->first();
        return $holidays_Details;

    }

    public static function getEmpworkstatus($emp_id)
    {

        $today_date = date('Y-m-d');
        $empworkstatus_Details = DB::table('entrance_logs')->select('*')
            ->where('user_id', '=', $emp_id)
            ->whereRaw('Date(loged_in_at) = CURDATE()')
            ->orderByRaw('id  DESC')
            ->first();
        return $empworkstatus_Details;

    }
    /**
     * Fetch All holiday List
     * Author : Muhammed Gani
     */

    public static function getAll_Holidays($year)
    {
       // $year = '2020';
        $holidays_Details = DB::table('holidays')->select('*')
        ->whereYear('date', '=', $year)
        ->get()->toArray();
        return $holidays_Details;
    }

    public static function getAll_HolidaysById($holiday_id)
    {
        $holidays_Details = DB::table('holidays')->select('*')->where('id', '=', $holiday_id)->get()->toArray();
        return $holidays_Details;

    }

    public static function getAll_HolidayType()
    {
        $holidays_Types = DB::table('hoidays_type')->select('id', 'name')->get()->toArray();
        return $holidays_Types;

    }

    public static function getAll_forgetlogin_currentMth($user_id,$role,$group_email)
    {
        $query  = DB::table('user_forgetlogin')
        ->join('users', 'users.id', '=', 'user_forgetlogin.user_id')
        
        ->select('*','user_forgetlogin.id as fid');
      //  $query->where('user_forgetlogin.forget_login_status!=', 'Approved');

        /* if ($user_id!='1') {
            $query->where('users.id', $user_id);
        } */


        if($user_id!='1') {

            if($role=='17') {
                 $query->where('users.group_email', $group_email);
            } 
            else {
                $query->where('users.id', $user_id);
             // $leave_Details_query->where('user_leavelist.user_id', $user_id);
            }
         }




        $forget_login_list = $query->get()->toArray();
        
        return $forget_login_list;

    }

    public static function get_ForgetLogin($forget_id)
    {
        $forget_login_list_byid = DB::table('user_forgetlogin')
            ->select('id', 'from_time', 'to_time', 'forget_date', 'forget_reason', 'created_date')
            ->where('id', '=', $forget_id)
            ->get()->toArray();
        return $forget_login_list_byid;

    }

    public static function get_ForgetLoginCal($forget_id)
    {
        $forget_login_list_byid = DB::table('user_forgetlogin')
            ->select('from_time', 'to_time', 'forget_date')
            ->where('user_id', '=', $forget_id)
            ->whereRaw('Date(created_date) = CURDATE()')
            ->get()->toArray();
        return $forget_login_list_byid;

    }

    /** User Leave Modules Code Start
     * Author : Muhammed Gani
     */

    public static function getAll_Leaves($user_id,$role,$group_email)
    {

        DB::enableQueryLog();

        $leave_Details_query = DB::table('user_leavelist')->select('leave_id', 'leave_type', 'from_date', 'to_date', 'no_ofdays', 'user_id', 'remarks', 'leave_status', 'created_date','users.name as name','users.emp_id as emp_id')
                            ->join('users', 'users.id', '=', 'user_leavelist.user_id');
                            

        /*  if ($user_id!='1') {
            $leave_Details_query->where('user_leavelist.user_id', $user_id);
        }  */

        if($user_id!='1') {

       if($role=='17') {
            $leave_Details_query->where('users.group_email', $group_email);
            
       } 
       else {
        $leave_Details_query->where('user_leavelist.user_id', $user_id);
        
       }
    }
         $leave_Details_query->orderBy('user_leavelist.leave_status', 'asc');
        // $leave_Details_query->groupBy('users.id');                
        $leave_Details = $leave_Details_query->get()->toArray();

   /*      $query = DB::getQueryLog();
$lastQuery = end($query);
print_r($lastQuery);
exit; */

        
      

       

        return $leave_Details;
    }

    public static function getUserLeaves($email) {
        $leave_Details = DB::table('users')
            ->join('user_leavelist', 'users.id', '=', 'user_leavelist.user_id')
            ->select('*')
            ->where('group_email', '=', $email)
            ->paginate(20);
        return $leave_Details;
    }

    public static function approveLeaveStatus($status, $leaveid) {
        if ($status) {
            $status = 'Approved';
        } else {
            $status = 'Reject';
        }
        return DB::table('user_leavelist')->where('leave_id', $leaveid)->update(['leave_status' => $status]);
    }

    public static function getAll_LeaveType()
    {
        $holidays_Types = DB::table('user_leavetype')->select('id', 'name')->get()->toArray();
        return $holidays_Types;

    }

    public static function getAll_EmployeeLeave($emp_id)
    {
        $today_date = date('Y-m-d');
        $emp_LeaveDetails = DB::table('user_leavelist')->select('*')
            ->where('user_id', '=', $emp_id)
            ->whereRaw('Date(from_date) = CURDATE()')
            ->orderByRaw('leave_id  DESC')
            ->first();
        return $emp_LeaveDetails;
    }


    public static function getEdit_Leaves($leave_id) {

        $emp_LeaveEdit = DB::table('user_leavelist')->select('*')
        ->where('leave_id', '=', $leave_id)       
        ->first();
        
        return $emp_LeaveEdit;


    }

    /** User Leave Moduels Code End */

    /**
     * Fetch All Managers Email ids
     * Author: Muhammed Gani
     */

    public static function getAll_ManagerEmailids()
    {

        $mgr_Emailids = DB::table('group_emails')
            ->select('gemail_id', 'group_emailids', 'emailid_status')
            ->get()->toArray();
        return $mgr_Emailids;

    }

    public static function get_MgrEmailid($gemail_id)
    {

        $mgr_EmailDetails = DB::table('group_emails')->select('gemail_id', 'group_emailids')
            ->where('gemail_id', '=', $gemail_id)
            ->first();

        return $mgr_EmailDetails;

    }

    /**
     * Cron Email Functionality
     * Reminder email to be sent in the morning at 10 am
     * if the employee has not signed in or registered a holiday/sick day
     * Author : Muhammed Gani
     */

    public static function withoutlogin_UsersList_today()
    {
        $withoutlogin_userList = DB::select('SELECT u.id, u.email, u.name FROM users u WHERE NOT EXISTS (SELECT user_id FROM entrance_logs e WHERE u.id = e.user_id AND date(e.loged_in_at) = CURDATE())');

        return $withoutlogin_userList;
    }

    /**
     * Cron Email Functionality
     * Reminder email to be sent in the evening if an employee has not signed out after 9 hours
     * Author : Muhammed Gani
     */

    public static function withoutlogged_UsersList_today()
    {

        $withoutlogin_userList = DB::table('users')
            ->select('users.id', 'users.email', 'users.name', 'entrance_logs.work_type')
            ->join('entrance_logs', 'users.id', '=', 'entrance_logs.user_id')
        // ->where('entrance_logs.loged_out_at',  " ")
            ->orWhereNull('entrance_logs.loged_out_at')
            ->whereRaw('Date(entrance_logs.loged_in_at) = CURDATE()')
            ->get()->toArray();

        return $withoutlogin_userList;

    }

    /** Tracking working hours Individual / Entire Report
     * Author : Muhammed Gani
     */

    public static function get_AllTrackingHours($id)
    {

        $tracking_hours = DB::table('users')
            ->select('users.id', 'users.email', 'users.name', 'entrance_logs.loged_in_at', 'entrance_logs.loged_out_at','users.emp_id as emp_id')
            ->join('entrance_logs', 'users.id', '=', 'entrance_logs.user_id')
            ->where('entrance_logs.user_id', '=', $id)
            ->orderByRaw('entrance_logs.loged_in_at DESC')
            ->get()->toArray();

        return $tracking_hours;

    }

    public static function get_AllTrackingHoursAdmin()
    {

        $tracking_hours = DB::table('users')
            ->select('users.id', 'users.email', 'users.name', 'entrance_logs.loged_in_at', 'entrance_logs.loged_out_at','users.emp_id as emp_id')
            ->join('entrance_logs', 'users.id', '=', 'entrance_logs.user_id')
            //->where('entrance_logs.user_id', '=', $id)
            ->orderByRaw('entrance_logs.loged_in_at DESC')
            ->get()->toArray();

        return $tracking_hours;

    }


    public static function get_AllTrackingHoursBydate($from_date, $to_date,$user_id)
    {

        $tracking_hours = DB::table('users')
            ->select('users.id', 'users.email', 'users.name', 'entrance_logs.loged_in_at', 'entrance_logs.loged_out_at','users.emp_id')
            ->join('entrance_logs', 'users.id', '=', 'entrance_logs.user_id')
            ->whereRaw('users.id ="'.$user_id.'"')
        // ->whereRaw('Date(entrance_logs.loged_in_at) ="'.$to_date.'"')
            ->whereBetween('entrance_logs.loged_in_at', [$from_date, $to_date])
            ->orderByRaw('entrance_logs.loged_in_at DESC')
            ->get()->toArray();

        return $tracking_hours;

    }



    public static function get_AllTrackingHoursBydateAdmin($from_date, $to_date)
    {

        $tracking_hours = DB::table('users')
            ->select('users.id', 'users.email', 'users.name', 'entrance_logs.loged_in_at', 'entrance_logs.loged_out_at','users.emp_id')
            ->join('entrance_logs', 'users.id', '=', 'entrance_logs.user_id')
            //->whereRaw('users.id ="'.$user_id.'"')
        // ->whereRaw('Date(entrance_logs.loged_in_at) ="'.$to_date.'"')
            ->whereBetween('entrance_logs.loged_in_at', [$from_date, $to_date])
            ->orderByRaw('entrance_logs.loged_in_at DESC')
            ->get()->toArray();

        return $tracking_hours;

    }

    

    public static function get_AllUsers()
    {

        $users_list = DB::table('users')->select('*')->get()->toArray();
        return $users_list;

    }


    public static function get_AllUsersbyMgr($group_emailid)
    {

        $users_list = DB::table('users')->select('*')->where('group_email', '=', $group_emailid)->get()->toArray();
        return $users_list;

    }



    public static function get_firstlogintimebyid($logged_in_at, $user_id)
    {

        $current_date = date('Y-m-d', strtotime($logged_in_at));

        $last_Logintime = DB::select("SELECT * from entrance_logs where user_id =$user_id and date(loged_out_at) LIKE '%$current_date%' order by loged_out_at DESC limit 1");

        return $last_Logintime;

    }


    public static function get_firstlogintimebyid_new($logged_in_at, $user_id)
    {

        $current_date = date('Y-m-d', strtotime($logged_in_at));

        $last_Logintime = DB::select("SELECT * from entrance_logs where user_id =$user_id and date(loged_in_at) LIKE '%$current_date%' order by loged_in_at ASC limit 1");

        return $last_Logintime;

    }






    public static function get_Usersid($id)
    {

        $user_Details = DB::table('users')->select('*')
            ->where('id', '=', $id)
            ->first();

        return $user_Details;

    }

    public static function get_AllTrackingReportHoursbyID($user_id)
    {

        $tracking_hours = DB::table('entrance_logs')
            ->select('*')
            ->where('user_id', '=', $user_id)
            ->groupBy(DB::raw('Date(entrance_logs.loged_in_at)'))
            ->get()->toArray();

        return $tracking_hours;
    }

    public static function get_AllTrackingReportHoursbydate($from_date, $todate)
    {

        $from_date = date('Y-m-d', strtotime($from_date));
        $to_date = (!empty($todate)) ? date('Y-m-d', strtotime($todate. ' +1 day')) : $from_date;
      
         DB::enableQueryLog();
         
      /*  $tracking_hours = DB::table('entrance_logs')
            ->select('*')
            ->whereBetween('entrance_logs.loged_in_at', array("'$from_date'", "'$to_date'"))
            ->groupBy('entrance_logs.user_id')
            ->get()->toArray();

            $query = DB::getQueryLog();

            $query = end($query); */
            
            return $tracking_hours = DB::select(DB::raw("select *  from entrance_logs where loged_in_at between '$from_date' and '$to_date' group by user_id"));

            

            //echo '<pre>Test'; print_r($tracking_hours);

    }

    public static function get_AllTrackingReportHoursbyAll($user_id, $from_date, $todate)
    {
        /* 
        echo 'Original_From:'.str_replace('/','-',$from_date);
        echo 'Original_End:'.$todate;
        echo '<br>'; */
        DB::enableQueryLog();
        $from_date = date('d-m-Y', strtotime($from_date));
        $to_date = (!empty($todate)) ? date('d-m-Y', strtotime($todate. ' +1 day')) : $from_date;
       // echo '<br>';

      /*   exit('Testing');   */
    
        return  $tracking_hours = DB::table('entrance_logs')
            ->select('*')
            ->where('user_id', '=', $user_id)
            ->whereBetween('loged_in_at', array($from_date, $to_date))
            ->groupBy(DB::raw('Date(entrance_logs.loged_in_at)'))
            ->get()->toArray();

            /* $query = DB::getQueryLog();
$lastQuery = end($query);
print_r($lastQuery);
exit; */

    }

    public static function get_AllTrackingReportHours()
    {

        $tracking_hours = DB::table('users')
            ->select('*')
            ->join('entrance_logs', 'users.id', '=', 'entrance_logs.user_id')
            ->groupBy(DB::raw('Date(entrance_logs.loged_in_at)'))
            ->groupBy(DB::raw('entrance_logs.user_id'))
            ->get()->toArray(); 
            
            

        return $tracking_hours;
    }


    /** Fetch the Weekly report records
     * Author : Muhammed Gani
     * 
     */

     public static function weekly_TimesheetReport($from_date,$to_date) {

        $from_date = date('Y-m-d', strtotime($from_date));
        $to_date = (!empty($to_date)) ? date('Y-m-d', strtotime($to_date)) : $from_date;

        return $tracking_hours = DB::table('entrance_logs')
            ->join('users', 'users.id', '=', 'entrance_logs.user_id')
            ->select('entrance_logs.*', 'users.group_email', 'users.email')            
            ->whereBetween('entrance_logs.loged_in_at', array($from_date, $to_date))
            ->groupBy(DB::raw('Date(entrance_logs.loged_in_at)'))
            ->get()->toArray();

     }



     /**
      * Fetch the National Holiday list 
      */
      public static function bank_NationalHolidays($tomorrow) {

        return $tracking_hours = DB::table('holidays')
                                        ->select('*') 
                                        ->whereRaw('Date(date) = "'.$tomorrow.'"')
                                        ->get()->first();
       
      }



      /** Department Modules
       * Author : Muhammed Gani
       */

     public static function get_AllDepartment() {

            $department_list = DB::table('department')
                                ->select('*')
                                ->orderByRaw('dept_name ASC')
                                ->get()->toArray();
            return $department_list;
    
       
     }   


     public static function get_Department($dep_id)
    {

        $dept_Details = DB::table('department')->select('*')
            ->where('dept_id', '=', $dep_id)
            ->first();

        return $dept_Details;

    }


    public static function get_WorkType($work_date,$user_id){

        $work_Type = DB::table('emp_work_status')->select('*')
                                    ->where('emp_work_date', '=', $work_date)
                                    ->where('emp_id', '=', $user_id)
                                    ->first();

        return $work_Type;

    }

    public static function get_WorkType1($work_date,$user_id){

        DB::enableQueryLog();
        $work_Type = DB::table('entrance_logs')->select('*')
                                  
                                    ->where('loged_in_at', 'like', $work_date.'%')
                                    ->where('user_id', '=', $user_id)
                                    ->first();

//dd(DB::getQueryLog());
//exit('Testing');
        return $work_Type;

    }


    public static function get_Officeholiday($work_date){

        DB::enableQueryLog();
        $work_Type = DB::table('holidays')->select('*')
                                  
                                    ->where('date', 'like', '%'.$work_date.'%')                                    
                                    ->first();

//dd(DB::getQueryLog());
//exit('Testing');
        return $work_Type;

    }




    /** Employee Leave Reports */

    public static function get_AllLeaveReports()
    {

        $leave_List = DB::table('users')
            ->select('*')
            ->join('user_leavelist', 'user_leavelist.user_id', '=', 'users.id')            
            ->get()->toArray(); 
            
            

        return $leave_List;
    }


    public static function get_AllEmpLeaveReportbyID($user_id)
    {

        $leave_List = DB::table('users')
        ->select('*')
        ->join('user_leavelist', 'user_leavelist.user_id', '=', 'users.id')   
        ->where('user_id', '=', $user_id)       
        ->get()->toArray();         

        return $leave_List;
    }

    public static function get_AllEmpLeaveReportbydate($from_date, $todate)
    {

        $from_date = date('Y-m-d', strtotime($from_date));
        $to_date = (!empty($todate)) ? date('Y-m-d', strtotime($todate. ' +1 day')) : $from_date;
      


        $leave_List = DB::table('users')
        ->select('*')
        ->join('user_leavelist', 'user_leavelist.user_id', '=', 'users.id') 
        ->whereBetween('user_leavelist.from_date', array($from_date, $to_date))                
        ->get()->toArray();         

        return $leave_List;

    }


    public static function get_AllEmpLeaveReportbyAll($user_id,$from_date, $todate)
    {

        $from_date = date('Y-m-d', strtotime($from_date));
        $to_date = (!empty($todate)) ? date('Y-m-d', strtotime($todate. ' +1 day')) : $from_date;
      


        $leave_List = DB::table('users')
        ->select('*')
        ->join('user_leavelist', 'user_leavelist.user_id', '=', 'users.id') 
        ->whereBetween('user_leavelist.from_date', array($from_date, $to_date))   
        ->where('user_leavelist.user_id', '=', $user_id)               
        ->get()->toArray();         

        return $leave_List;

    }


    /** Change Password Update */

    public static function Update_Password($password,$user_id) {

        DB::table('users')
        ->where('id', $user_id)
        ->update(['password' => $password]);
        return true;

    }

    /** Change Password Update End*/

    public static function Is_Leave_exist($from_date,$to_date,$user_id) {

       return DB::table('user_leavelist')
        ->select('*')
        ->whereDate('from_date', '<=', date("Y-m-d",strtotime($to_date)))
        ->whereDate('to_date', '>=', date("Y-m-d",strtotime($from_date)))
        ->where('user_id', $user_id)
        ->first();
      


    }



    /** Get Manager Details */

    public static function getManager() {


        $manager_list = DB::table('users')
        ->select('*')
        ->where('role', '=', '17')        
        ->get()->toArray();

    return $manager_list;

    }

    public static function getManagerbyid($id) {

        $manager_list_byid = DB::table('users')
        ->select('*')
        ->where('role', '=', '17')        
        ->where('id', '=', $id)
        ->first();

    return $manager_list_byid;

    }


    public static function getForget_user_detail($id) {


        $accept_user_byid = DB::table('user_forgetlogin')
        ->select('*')             
        ->where('id', '=', $id)
        ->first();
       return $accept_user_byid;

    }


    public static function getEntrance_log_details($user_id,$login_date,$from_time,$to_time) {

        DB::enableQueryLog();
        $entrance_user_byid = DB::table('entrance_logs')
        ->select('*')             
        ->where('user_id', '=', $user_id)
        //->where('loged_in_at', '=',$login_date)
        ->where('loged_in_at', 'like', '%'.$login_date.'%')
        ->delete();

        //->first();
        

 $loged_in_at = date('Y-m-d',strtotime($login_date))." ".$from_time;
 $loged_out_at = date('Y-m-d',strtotime($login_date))." ".$to_time;

 
 
 DB::table('entrance_logs')->insert(
    ['user_id' => $user_id, 'loged_in_at' => $loged_in_at, 'loged_out_at' =>$loged_out_at, 'work_type' => 'Office','emp_wrk_status' =>'Accept' ]
);

DB::table('user_forgetlogin')->where('user_id', $user_id)
                            ->where('forget_date', 'like', '%'.$login_date.'%')
                            ->update(['forget_login_status' => 'Approved']);


/* $query = DB::getQueryLog();
$lastQuery = end($query);
print_r($lastQuery);
exit;  */

         return 1;




    }

    public static function leavebalance_count($user_id,$leave_type) {


        $accept_user_byid = DB::table('user_leavelist')
        ->select('*')             
        ->where('user_id', '=', $user_id)
        ->where('leave_type', '=', $leave_type)
       ->get()->toArray();
       return $accept_user_byid;

    }




    public static function getAll_Employee($user_id,$role,$group_email)
    {

        DB::enableQueryLog();

        $Emp_details = DB::table('users')
        ->select('*');             
      //  ->where('user_id', '=', $user_id)
       // ->where('leave_type', '=', $leave_type)
    //   ->get()->toArray();
     //  return $accept_user_byid;
                            

       

        if($user_id!='1') {

       if($role=='17') {
            $Emp_details->where('users.group_email', $group_email);
            
       } 
       else {
        $Emp_details->where('users.id', $user_id);
        
       }
    }
        

    $leave_Details = $Emp_details->get()->toArray();
    return $leave_Details;
       
    }
    
    
  public static function getAll_Breaktime($user_id){
    
    
    $break_time_hours = DB::table('break_time')
        ->select('*')             
        ->join('users', 'users.id', '=', 'break_time.user_id')
        ->where('break_time.user_id', '=', $user_id)        
        ->get()->toArray();
       return $break_time_hours;
    
    
    
  }  


 public static function get_sumof_breaktime($user_id,$break_date) {
    
    $break_time_hours = DB::table('break_time')
        ->select(DB::raw("SUM(duration) as totalduration"))             
        ->join('users', 'users.id', '=', 'break_time.user_id')
        ->where('break_time.break_date', '=', date('Y-m-d',strtotime($break_date)))        
        ->get()->toArray();
       return $break_time_hours;
    
    
    
 }


 

 public static function leave_approval_mgr_bulk($leaveid) {
    
    
    $status = 'Approved';

    return DB::table('user_leavelist')->where('leave_id', $leaveid)->update(['leave_status' => $status]);
}


public static function leave_reject_mgr_bulk($leaveid) {
    
    
    $status = 'Reject';

    return DB::table('user_leavelist')->where('leave_id', $leaveid)->update(['leave_status' => $status]);
}



public static function getAll_EmployeeLeave_All($emp_id)
    {
        $today_date = date('Y-m-d');
        $emp_LeaveDetails = DB::table('user_leavelist')->select('*')
            ->where('user_id', '=', $emp_id)
            //->whereRaw('Date(from_date) = CURDATE()')
            ->orderByRaw('leave_status', 'DESC')
            ->get()->toArray();
        return $emp_LeaveDetails;
    }
 


  /** Forget login applied check */

  public static function get_forget_applied_check($logged_in_at, $user_id)
    {

        $current_date = date('Y-m-d', strtotime($logged_in_at));

        $forget_logintime = DB::select("SELECT * from user_forgetlogin where user_id =$user_id and date(forget_date) LIKE '%$current_date%' order by forget_date ASC limit 1");

        return $forget_logintime;

    }





    public static function ticket_emails($email_array)
    {
        $data['users'] = $email_array;
        $Subject = $email_array['Subject'];
        $team_name = 'Compuscript Team';
        $from_email = 'brohendry07@gmail.com';
        $to_email =  'muhammed@pdmrindia.com'; //$email_array['datas']['data-manager'];  // 'muhammed@pdmrindia.com'; 
       // $cc_email = 'brohendry07@gmail.com';
        $cc_email = 'selvi@pdmrindia.com';
        $email_template = $email_array['template_name'];
    
             try {
                    \Mail::send($email_template, $data, function ($message) use ($Subject, $team_name, $from_email, $to_email, $cc_email) {

                        $message->to($to_email, 'Dear Teresa')->subject($Subject);
                        $message->cc($cc_email, 'Dear Admin');
                        $message->from($to_email, $team_name);
                    });
                    return "Success";
                } catch (Exception $ex) {
                    dd($ex->getMessage());
                    return "We've got errors!";
                }

    }



    /* ticket acknowledgement mail */


    public static function ticket_ackn_emails($email_array)
    {

        $Subject = 'New ticket created  Type of request '.$email_array['type_of_request'].'Ticket NO : '.$email_array['ticket_id'];
        $data['users'] = $email_array;
       // $Subject = $email_array['Subject'];
        $team_name = 'Compuscript Team';
        $from_email = 'brohendry07@gmail.com';
        $to_email =  $email_array['user_email']; 
        //'muhammed@pdmrindia.com'; //$email_array['datas']['data-manager'];  // 'muhammed@pdmrindia.com'; 
       // $cc_email = 'brohendry07@gmail.com';
        $cc_email = 'muhammed@pdmrindia.com';
        $email_template = 'emails.tickets_ackn_notify';
    
             try {
                    \Mail::send($email_template, $data, function ($message) use ($Subject, $team_name, $from_email, $to_email, $cc_email) {

                        $message->to($to_email, 'Dear User')->subject($Subject);
                        $message->cc($cc_email, 'Dear Admin');
                        $message->from($to_email, $team_name);
                    });
                    return "Success";
                } catch (Exception $ex) {
                    dd($ex->getMessage());
                    return "We've got errors!";
                }

    }





    public static function getAll_tickets() {


        $tickets = DB::table('tickets')->select('*')->get()->toArray();
        return $tickets;



    }



    public static function ticketdepartment_notify_emails($email_array)
    {
        $data['users'] = $email_array;
        $Subject = $email_array['Subject'];
        $team_name = 'Compuscript Team';
        $from_email = 'brohendry07@gmail.com';
        $to_email =  'muhammed@pdmrindia.com'; //$email_array['datas']['data-manager'];  // 'muhammed@pdmrindia.com'; 
       // $cc_email = 'brohendry07@gmail.com';
        $cc_email = 'selvi@pdmrindia.com';
        $email_template = $email_array['template_name'];
    
             try {
                    \Mail::send($email_template, $data, function ($message) use ($Subject, $team_name, $from_email, $to_email, $cc_email) {

                        $message->to($to_email, 'Dear Backend Team')->subject($Subject);
                        $message->cc($cc_email, 'Dear Admin');
                        $message->from($to_email, $team_name);
                    });
                    return "Success";
                } catch (Exception $ex) {
                    dd($ex->getMessage());
                    return "We've got errors!";
                }

    }


 

    public static function ticketdepartment_notify_ackn_emails($email_array)
    {
        $data['users'] = $email_array;
        $Subject = $email_array['Subject'];
        $team_name = 'Compuscript Team';
        $from_email = 'brohendry07@gmail.com';
        $to_email =  $email_array['user_email']; //$email_array['datas']['data-manager'];  // 'muhammed@pdmrindia.com'; 
       // $cc_email = 'brohendry07@gmail.com';
        $cc_email = 'selvi@pdmrindia.com';
        $email_template = 'emails.tickets_department_ackn_notify';
    
             try {
                    \Mail::send($email_template, $data, function ($message) use ($Subject, $team_name, $from_email, $to_email, $cc_email) {

                        $message->to($to_email, 'Dear Backend Team')->subject($Subject);
                        $message->cc($cc_email, 'Dear Admin');
                        $message->from($to_email, $team_name);
                    });
                    return "Success";
                } catch (Exception $ex) {
                    dd($ex->getMessage());
                    return "We've got errors!";
                }

    }





    public static function getTicketById($id) {

        $tickets = DB::table('tickets')->select('*')
        ->where('id', '=', $id)
        
        ->get()->toArray();
        return $tickets;  
    }


    public static function getAll_ticketsByUsersId($user_id) {


        $tickets = DB::table('tickets')->select('*')
        ->where('request_user', '=', $user_id)
        ->get()->toArray();
        return $tickets;
        
    }

     public static function getticket_userdetail($id) {

        $tickets = DB::table('users')->select('*')
        ->where('id', '=', $id)
        
        ->get()->toArray();
        return $tickets; 

     }  
     
     
     public static function ticketresponse_emails($email_array)
    {
        $data['users'] = $email_array;
        $Subject = $email_array['Subject'];
        $team_name = 'Compuscript Team';
        $from_email = 'brohendry07@gmail.com';
        $to_email =  $email_array['users_email']; //$email_array['datas']['data-manager'];  // 'muhammed@pdmrindia.com'; 
       // $cc_email = 'brohendry07@gmail.com';
        $cc_email = 'muhammed@pdmrindia.com';
        $email_template = $email_array['template_name'];
    
             try {
                    \Mail::send($email_template, $data, function ($message) use ($Subject, $team_name, $from_email, $to_email, $cc_email) {

                        $message->to($to_email, 'Dear Users')->subject($Subject);
                        $message->cc($cc_email, 'Dear Admin');
                        $message->from($to_email, $team_name);
                    });
                    return "Success";
                } catch (Exception $ex) {
                    dd($ex->getMessage());
                    return "We've got errors!";
                }

    }



    public static function getAll_ticketsbytypenew($type) {


        $tickets = DB::table('tickets')->select('*')
        ->where('request_type', '=', $type)
        ->get()->toArray();
        return $tickets;



    }



    /** Check date already leave applied */


    /** Check date already leave applied End */




    /** Employee Leave Reports End */


}
