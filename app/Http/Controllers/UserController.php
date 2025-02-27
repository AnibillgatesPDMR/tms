<?php

namespace App\Http\Controllers;

use App\Authorizable;
use App\Permission;
use App\Role;
use App\User;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Input;
use Mail;

class UserController extends Controller
{
    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Role::get_AllUsers(); //User::all();
        return view('user.dashboard', compact('result'));
    }

    public function users()
    {

        $result = User::latest()->paginate(10);
        $roles = Role::pluck('name', 'id');
        $teams = Role::getTeam();
        $category = Role::getCategory();
        $department = Role::getDepartment();
        $teamId = (object) array('team_id' => '');
        $catId = (object) array('emp_category' => '');
        $val = array('department' => '', 'job' => '');
        $department_Id = '';
        $group_emails = Role::getGroupEmails();
        $group_emails_Id = '';
        $job_assign = Role::getJobAssign();
        $jobs = '';
        $emp_designation = Role::getEmployeeDesignation();
        $designation_Id = '';
        $emp_floorDetails = Role::getEmpFloorDetails();
        $floor_Id = '';
        $emp_intercom = Role::getIntercom();
        $emp_intercom_Id = '';
        $user = '';
        $profile = '';
        $managers_Id = '';

        $managers = Role::getManager();
        
        //echo '<pre>'; print_r($result);
        //exit;

        return view('user.index', compact('result', 'roles', 'teams', 'category', 'teamId', 'catId', 'department', 'department_Id', 'group_emails', 'group_emails_Id', 'job_assign', 'jobs', 'emp_designation', 'designation_Id', 'emp_floorDetails', 'floor_Id', 'emp_intercom', 'emp_intercom_Id', 'val','profile','managers','managers_Id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id');
        $teams = Role::getTeam();
        $teamId = (object) array('team_id' => '');

        return view('user.new', compact('roles'), compact('teams', 'teamId'));
    }

    public function viewUser($id)
    {

        $user = User::getUser($id);

       
       
        return view('user.view', compact('user'));
    }

    public function shifttime($id)
    {
        $user = User::getUser($id);
        $shifttime = Role::getShiftTime();
        return view('user.shift', compact('user', 'shifttime'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'roles' => 'required|min:1',
            'created_by' => 'required|min:1',           
            'emp_id' => 'required|min:1',
            'designation' => 'required|min:1',
            'department' => 'required|min:1',
            'group_email' => 'required|min:1',
            'gender' => 'required|min:1',           

        ]);

        // hash password
        $request->merge(['password' => bcrypt($request->get('password'))]);
        $team ='';
        $createdBy = $request->get('created_by');


       
            
        $file = $request->file('profile');
        if ($file) {
            $inputPath =  public_path().'/images';
            if($file->move($inputPath,$file->getClientOriginalName())) {
                $fileName = $file->getClientOriginalName();
                $filePath = url('/').'/images/'.$file->getClientOriginalName();
            } else {
                $filePath = '';
            }  
        } else {
            $filePath = '';
        }


        // Create the user
        if ($user = User::create($request->except('roles', 'permissions', 'emp_id', 'designation', 'department', 'group_email', 'login_access', 'gender'))) {
            $userData = [
                'emp_id' => $request->get('emp_id'),
                'designation' => $request->get('designation'),
                'department' => $request->get('department'), //implode(",", $request->get('department')),
                'group_email' => $request->get('group_email'),
                'login_access' => $request->get('login_access'),
                'gender' => $request->get('gender'),               
                'created_by' => $createdBy,
                'profile_path' => $filePath,
                'emp_intercomeno' => $request->get('emp_intercomeno'),
                'birthday' => date('Y-m-d',strtotime($request->get('birthday'))),
                'bloodgroup' => $request->get('bloodgroup'),
                'mobilenumber' => $request->get('mobilenumber'),
                'managername' => $request->get('managername'),
                'role' => $request->get('roles'),
            ];
            User::updateUser($userData, $user->id);
            User::createTeam($user->id, $team);
            // Mail::to('shajacse786@gmail.com')->send(new AppMailler);
            $this->syncPermissions($request, $user);

            flash('User has been created.');

        } else {
            flash()->error('Unable to create user.');
        }

        return redirect()->back();
    }

    public static function insertshift(Request $request)
    {

        $begin = new DateTime($request->get('shift_start_date'));
        $end = new DateTime($request->get('shift_end_date'));

        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
            // echo $i->format("Y-m-d");
            // echo "<br />";

            $shifData = [
                'shift_time' => $request->get('shift_time'),
                'shift_start_date' => $i->format("Y-m-d"),
                'shift_end_date' => $i->format("Y-m-d"),
                'shift_emp_id' => $request->get('shift_emp_id'),
                'created_by' => Auth::id(),

            ];
            User::addShiftTime($shifData);

        }
        flash('Shift Time Added Successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
      
        $jobs = Role::getJobById($id);
        $val = ['job' => '', 'department' => $user->department];
        $roles = Role::pluck('name', 'id');
        $teams = Role::getTeam();
        $category = Role::getCategory();
        $teamId = '';
        $catId = Role::getCategoryById($id);
        $permissions = Permission::all('name', 'id');
        $department = Role::getDepartment();
        $department_Id = Role::getDepartmentById($id);
        $group_emails = Role::getGroupEmails();
        $group_emails_Id = Role::getEmailidById($id);
        $job_assign = Role::getJobAssign();
        $emp_designation = Role::getEmployeeDesignation();
        $designation_Id = Role::getDesignationById($id);
        $emp_floorDetails = Role::getEmpFloorDetails();
        $floor_Id = Role::getFloorById($id);
        $emp_intercom = Role::getIntercom();
        $emp_intercom_Id = Role::getIntercombyId($id);
        $profile = $user->profile_path;
        $managers_Id = Role::getManagerbyid($id);
        $managers = Role::getManager();

        return view('user.edit', compact('user', 'roles', 'permissions', 'teams', 'teamId', 'category', 'catId', 'department', 'department_Id', 'group_emails', 'group_emails_Id', 'job_assign', 'jobs', 'emp_designation', 'designation_Id', 'emp_floorDetails', 'floor_Id', 'emp_intercom', 'emp_intercom_Id', 'val','profile','managers_Id','managers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


 

        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required|min:1',
            
        ]);

        // Get the user
        $user = User::findOrFail($id);

        // Update user
        $user->fill($request->except('roles', 'permissions', 'password', 'team', 'emp_id', 'designation', 'department', 'ot', 'job', 'group_email', 'login_access', 'gender', 'emp_category','profile'));
        User::updateTeam($id,'');
        $userData = [
            'emp_id' => $request->get('emp_id'),
            'designation' => $request->get('designation'),
            //'department' => implode(",", $request->get('department')),
            'department' => $request->get('department'),
            'group_email' => $request->get('group_email'),
            'login_access' => $request->get('login_access'),
            'gender' => $request->get('gender'),            
            'emp_intercomeno' => $request->get('emp_intercomeno'),
            'birthday' => date('Y-m-d',strtotime($request->get('birthday'))),
            'bloodgroup' => $request->get('bloodgroup'),
            'mobilenumber' => $request->get('mobilenumber'),
            'managername' => $request->get('managername'),
            'role' => $request->get('roles'),
        ];



        $file = $request->file('profile');
        if ($file) {
            $inputPath =  public_path().'/images';
            if($file->move($inputPath,$file->getClientOriginalName())) {
                $fileName = $file->getClientOriginalName();
                $filePath = url('/').'/images/'.$file->getClientOriginalName();
                $userData['profile_path'] = $filePath;
            }   
        }

        User::updateUser($userData, $id);
        // check for password change
        if ($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        // Handle the user roles
        $this->syncPermissions($request, $user);

        $user->save();

        flash()->success('User has been updated.');

        return redirect('users/add/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function destroy($id)
    {
        if (Auth::user()->id == $id) {
            flash()->warning('Deletion of currently logged in user is not allowed :(')->important();
            return redirect()->back();
        }

        if (User::findOrFail($id)->delete()) {
            flash()->success('User has been deleted');
        } else {
            flash()->success('User not deleted');
        }

        return redirect()->back();
    }

    /**
     * Sync roles and permissions
     *
     * @param Request $request
     * @param $user
     * @return string
     */
    private function syncPermissions(Request $request, $user)
    {
        // Get the submitted roles
        $roles = $request->get('roles', []);
        $permissions = $request->get('permissions', []);

        // Get the roles
        $roles = Role::find($roles);

        // check for current role changes
        if (!$user->hasAllRoles($roles)) {
            // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);

        return $user;
    }

    public static function getUser($userid)
    {
        $user = User::find($userid);
        return $user;
    }

    public static function getCategory($cat)
    {
        $category = User::getCategory($cat);
        return $category;
    }

    public static function getLogindetailById($uer_id)
    {
        $login_details = Role::getLogindetail($uer_id);
        return $login_details;
    }

    public static function getWeekTimeSheet($user_id)
    {

        $weekTimeSheet = Role::getWeekTimeSheet($user_id);
        return $weekTimeSheet;

    }

    /**
     * Holidays functionality start
     * Author : Muhammed Gani
     */

    public static function holidayslist()
    {

        
        $current_year = date('Y');
        
        $result = Role::getAll_Holidays($current_year);
        return view('holidays.dashboard', compact('result'));
    }

    public static function holidays(Request $request)
    {

        //echo '<pre>'; print_r($request->holidayyear);
        //exit;

        if($request->holidayyear!='') {

            $current_year = $request->holidayyear;
        } else {
        $current_year = date('Y');
        }

        $result = User::latest()->paginate(10);
        $holidays_list = Role::getAll_Holidays($current_year);
        $holidays_edit = '';
        $holidays_types = Role::getAll_HolidayType();
        return view('holidays.index', compact('result', 'holidays_list', 'holidays_edit', 'holidays_types'));
    }

    public static function holidaysearch(Request $request) {

        echo "testingn";

    }

    public function holidaystore(Request $request)
    {

        if ($request->id == '') {
            DB::table('holidays')->insert(
                ['holiday_type' => $request->holiday_type, 'date' => date('Y-m-d', strtotime($request->date)), 'created_by' => $request->created_by, 'holiday_remarks' => $request->holiday_remarks]
            );

            flash('Holiday has been created.');

        } else {

            DB::table('holidays')
                ->where('id', $request->id)
                ->update(['holiday_type' => $request->holiday_type, 'date' => date('Y-m-d', strtotime($request->date)), 'created_by' => $request->created_by, 'holiday_remarks' => $request->holiday_remarks]);

            flash('Holiday has been updated.');

        }

        return redirect('holidays/add/holiday');
    }

    public function holidays_edit($id)
    {

        $user = User::find($id);
        $holidays_types = Role::getAll_HolidayType();

        $holidays_edit = Role::getAll_HolidaysById($id);
        // echo '<pre>'; print_r($holidays_edit);
        return view('holidays.edit', compact('user', 'holidays_edit', 'holidays_types'));
    }




    /** Holiday Delete */

    public  function holidays_delete(Request $request) {
        
        
       $affected_row = DB::table('holidays')->where('id', '=', $request->id)->delete();
       return ($affected_row==1)?$affected_row:0;
      


    }





    /**
     * Forget Login Functionality
     * Author : Muhammed Gani - A
     */

    public static function forget_loginlist()
    {

        $role =  Auth::user()->role;
        $current_year = date('Y');
        $holidays_list = Role::getAll_Holidays($current_year);
        $holidays_edit = '';
        $holidays_types = Role::getAll_HolidayType();

      

        /*get All forget Login time */

        // $forget_login_list = Role::getAll_forgetlogin_currentMth(Auth::user()->id);
        $forget_login_list = Role::getAll_forgetlogin_currentMth(Auth::user()->id,Auth::user()->role,Auth::user()->group_email);
      // dd($forget_login_list);

        return view('forgetlogin.index', compact('forget_login_list','role'));
    }

    public static function insertforgetlogin(Request $request)
    {

        /* echo '<pre>'; print_r($request->from_time);
        exit; */
        $forget_type = '';
        $forget_pid = '';

        if ($request->id == '') {
            $lastInsertedID =  DB::table('user_forgetlogin')->insertGetId(
                ['from_time' => $request->from_time,
                    'to_time' => $request->to_time,
                    'forget_date' => date('Y-m-d', strtotime($request->forget_date)),
                    'forget_reason' => $request->forget_reason,
                    'user_id' => Auth::user()->id,
                ]
            );

            $forget_type = 'Added';
            $forget_pid = $lastInsertedID;
            flash('Forget Login Time has been added.');

        } else {

            DB::table('user_forgetlogin')
                ->where('id', $request->id)
                ->update([
                    'from_time' => $request->from_time,
                    'to_time' => $request->to_time,
                    'forget_date' => date('Y-m-d', strtotime($request->forget_date)),
                    'forget_reason' => $request->forget_reason,
                    'user_id' => Auth::user()->id,
                ]);
            $forget_type = 'Updated';
            $forget_pid = $request->id;

            flash('Forget Login Updated has been updated.');

        }

        /** Forget Login Email when user add / edit the forget login email
         * trigger to the particular managet
         *  Author : Muhammed Gani
         */

            
        $user_Details = Role::getUserDetailsByUserId(Auth::user()->id);
        $mgr_Details = Role::getManager_byemail($user_Details->group_email);

      //  echo '<pre>'; print_r($user_Details); exit;


      
        if(!empty($user_Details)) {
        $datas = array(
            'data-username' => $user_Details->name,
            'data-empid' => $user_Details->emp_id,
            'data-department' => $user_Details->department,
            'data-manager' => $user_Details->group_email,
            'data-manager-name' => $mgr_Details->name,
            'data-manager-response' => '',
            'data-empemailid' => $user_Details->email,
            'data-forgettype' => $forget_type,
            'data-forgetdate' => date('Y-m-d', strtotime($request->forget_date)),
            'data-from_time' => $request->from_time,
            'data-to_time' => $request->to_time,
            'data-forgetreason' => $request->forget_reason,
            'data-forgettype' => $forget_type,
            'data-forget_id' => $forget_pid,

        );
        $email_array = array(
            'template_name' => 'emails.user_forgetlogin',
           // 'Subject' => 'Compuscript  Employee ' . $forget_type . ' Notification',
            'Subject' => 'Forgot login',
            'datas' => $datas,
        );

        $email_send = Role::common_emails($email_array);
    }
        return redirect('forgetlogin');

    }

    public function forgetlogin_edit($id)
    {

      //  echo $id;
        $user = User::find($id);
        $forget_login_edit = Role::get_ForgetLogin($id);
       // dd( $forget_login_edit);
       // exit;
        // echo '<pre>'; print_r($holidays_edit);
        return view('forgetlogin.edit', compact('user', 'forget_login_edit'));
    }

    /** User Leave Modules Code
     * Author : Muhammed Gani
     */

    public static function leavedashboard()
    {

// echo Auth::user()->id.' - '.Auth::user()->role.' - '.Auth::user()->group_email;
        $result = Role::getAll_Leaves(Auth::user()->id,Auth::user()->role,Auth::user()->group_email);
        
        return view('leave.dashboard', compact('result'));

    }

    public function leaves(Request $request)
    {

        // echo 'Role Test:'.Auth::user()->role;
        $permissions = Permission::all('name', 'id');

        // print_r($permissions);
        $result = User::latest()->paginate(10);
        $role = Auth::user()->role;
        $user_id = Auth::user()->id;

        if($user_id!='1' && $user_id!='60' && $user_id!='92' && $user_id!='73')  {
        $leave_list = Role::getAll_Leaves(Auth::user()->id,Auth::user()->role,Auth::user()->group_email);
        } else {
            $leave_list = Role::getAll_LeavesAdmin();

        }


        $leave_edit = '';
        $leave_types = Role::getAll_LeaveType();
        return view('leave.index', compact('result', 'leave_list', 'leave_edit', 'leave_types','permissions','role'));

    }

    /*Breadking Hours */
    
    public function breakinghours(Request $request)
    {

        
        $permissions = Permission::all('name', 'id');

        // print_r($permissions);
        $result = User::latest()->paginate(10);
        $role = Auth::user()->role;
        $leave_list = Role::getAll_Leaves(Auth::user()->id,Auth::user()->role,Auth::user()->group_email);
        $leave_edit = '';
        $leave_types = Role::getAll_LeaveType();
        $break_time_hours = Role::getAll_Breaktime(Auth::user()->id);
        return view('breaktime.index', compact('result', 'leave_list', 'leave_edit', 'leave_types','permissions','role','break_time_hours'));

    }
    
    
    /* Breaking Hours */
    
    
    

    /* Leave Balance */

    public function leavebalance() {

        $permissions = Permission::all('name', 'id');

        // print_r($permissions);
        $result = User::latest()->paginate(10);
        $user_id = Auth::user()->id;
        //$leave_list = Role::getAll_Leaves(Auth::user()->id,Auth::user()->role,Auth::user()->group_email);
        if($user_id!='1' && $user_id!='60' && $user_id!='92' && $user_id!='73')  {
        $leave_list = Role::getAll_Employee(Auth::user()->id,Auth::user()->role,Auth::user()->group_email);
        } else {

            $leave_list = Role::getAll_EmployeeAdmin();

        }
        $leave_edit = '';
        $leave_types = Role::getAll_LeaveType();
        return view('leave.leavebalance', compact('result', 'leave_list', 'leave_edit', 'leave_types','permissions'));

    }

    public function leaveApprove() {
        $leave_list = Role::getUserLeaves(Auth::user()->email);
        return view('leave.approve', compact('leave_list'));
    }

    public function userLeaveApprove($status, $leaveid, $userid) {
        $approve = Role::approveLeaveStatus($status, $leaveid);

        if ($status) {
            $status = 'Approved';
            flash('Leave Approved.');
        } else {
            $status = 'Rejected';
            flash('Leave Rejected.');
        }

        $user_Details = Role::getUserDetailsByUserId($userid);
        $datas = array(
            'data-username' => $user_Details->name,
            'data-manager' => $user_Details->email,
            'data-leavestatus' => $status
        );
        $email_array = array(
            'template_name' => 'emails.approve_leave_status',
            'Subject' => 'Compuscript Leave Notification',
            'datas' => $datas,
        );

        $email_send = Role::common_emails($email_array);

        return redirect('leave/approve');
    }

    public function leavestore(Request $request) {
    

        

        //    echo '<pre>'; print_r($_REQUEST['fromdate']);
         //   exit;
    
    
            $leave_id = ''   ;
            $from_date = date('Y-m-d', strtotime($request->get('fromdate')));
            $to_date = date('Y-m-d', strtotime($request->get('todate')));
    
            $is_leave_existing = Role::Is_Leave_exist($request->get('fromdate'),$request->get('todate'),Auth::user()->id);
    
            if(!empty($is_leave_existing)) {
                
                //flash('Leave already Applied in between dates Please Check.');
    
                echo 'Leave already Applied in between dates Please Check.';
    
            } else {
               
    
    
           $date1Timestamp = strtotime($request->get('fromdate'));
    
           $date2Timestamp= strtotime($request->get('todate'));
    
           $difference = $date2Timestamp - $date1Timestamp;
    
            
           
           $date1=date_create(date('Y-m-d',strtotime($request->get('fromdate'))));
           $date2=date_create(date('Y-m-d',strtotime($request->get('todate'))));
           $diff=date_diff($date1,$date2);
    
           /* $diff1 = strtotime($_REQUEST['todate']) - strtotime($_REQUEST['fromdate']);*/
          /*  echo 'Test'.$diff->format('%a'); 
    
           exit; */
    
    
              //  $days = floor($difference / (60*60*24) );
    
                $days = $diff->format('%a'); 
    
              
           
                $is_weekend = 0;
                $fromDate = strtotime($request->get('fromdate'));
                $toDate = strtotime($request->get('todate'));
                while (date("Y-m-d", $fromDate) != date("Y-m-d", $toDate)) {
    
    
                  $day = date("N", $fromDate);
                
                
                    
    
                if ($day == 6 || $day == 7) {
                    $is_weekend = $is_weekend + 1;                
                }
            
                $fromDate = strtotime(date("Y-m-d", $fromDate) . "+1 day");
                
                }
             // echo "Weekend".$is_weekend;
           //    echo '<br />';
               if($is_weekend!=0 && $is_weekend!=1) {
    
                $days =  $days + 1;
                   
               } else {
               // $days = 1;
    
                 $days =  $days+1; 
                // echo 'TMSS'.$days; 
               }
                 $days = $days - $is_weekend;  //$days - $is_weekend;
    
                  
                // exit; 
       
               
                if($days==0)  {
    
                 //   flash('Your are applied Weekend.');
                 echo 'Your are applied Weekend.';
    
                }    else {
                      
            
    
           if($request->id=='') {
    
    
                           /*  if($_REQUEST['session1']=='S1') {
    
                                $days = '0.5';
    
                            } else {
    
                                $days = $days; 
    
                            } */
    
    
                           /*  $bank_holidays = Role::get_bank_holidays_inbetweendays(date('Y-m-d',strtotime($_REQUEST['fromdate'])),date('Y-m-d',strtotime($_REQUEST['todate'])));
    
                            $no_of_bank_holdays = $bank_holidays;
                            
    
                            if($no_of_bank_holdays!=0) {
                                $days = abs($_REQUEST['total_leave'] - $no_of_bank_holdays);
    
                            } else {
                                $days = $_REQUEST['total_leave'];
    
                            } */
    
                            $days = $request->get('total_leave');

                            $fileName='';
                            if($request->get('leavetype')=="Paid sick leave")
                            {
                                $file = $request->file('file_upload');
                                if ($file) {
                                $inputPath =  public_path().'/leave_images';
                                if($file->move($inputPath,$file->getClientOriginalName())) {
                                $fileName = $file->getClientOriginalName();
                                $filePath = url('/').'/leave_images/'.$file->getClientOriginalName();
                                $userData['profile_path'] = $filePath;
                                }  
                                }
            
                            }
    
                               
                                DB::table('user_leavelist')->insert(
                                [
                                    'leave_type' => $request->get('leavetype'),
                                    'from_date' => date('Y-m-d', strtotime( $request->get('fromdate'))),
                                    'to_date' => date('Y-m-d', strtotime( $request->get('todate'))),
                                    'no_ofdays' => $days,
                                    'user_id' => Auth::user()->id,
                                    'remarks' =>$request->get('remarks'),
                                    'leave_image' => $fileName,
                                ]
                                );
                                $leave_id = DB::getPdo()->lastInsertId();
                                $leave_status ="Applied";
    
                             //   flash('Leave has been applied.');
    
                           //  echo 'Leave has been applied.';
                             echo '1';
    
    
    
       
    
              } else {

                            $fileName='';
                            if($request->get('leavetype')=="Paid sick leave")
                            {
                                $file = $request->file('file_upload');
                                if ($file) {
                                $inputPath =  public_path().'/leave_images';
                                if($file->move($inputPath,$file->getClientOriginalName())) {
                                $fileName = $file->getClientOriginalName();
                                $filePath = url('/').'/leave_images/'.$file->getClientOriginalName();
                                $userData['profile_path'] = $filePath;
                                }  
                                } else {
                                    $fileName= $request->get('previous_file_upload');
                                }

                            }
    
                            DB::table('user_leavelist')
                            ->where('leave_id', $request->id)
                            ->update( [
                                'leave_type' => $request->get('leavetype'),
                                'from_date' => date('Y-m-d', strtotime( $request->get('fromdate'))),
                                'to_date' => date('Y-m-d', strtotime( $request->get('todate'))),
                                'no_ofdays' => $days,
                                'user_id' => Auth::user()->id,
                                'remarks' => $request->get('remarks'),
                                'leave_image' => $fileName,
                            ]);
                            $leave_status ="Modified";
    
                        //    flash('Leave has been updated.');
                            echo 'Leave has been updated.';
            
              }
    
            $user_Details = Role::getUserDetailsByUserId(Auth::user()->id);
           // echo '<pre>'; print_r($user_Details); 
            $mgr_Details = Role::getManager_byemail($user_Details->group_email);
    
          //  echo '<pre> Manager Details : '; print_r($mgr_Details); exit;
    
            $datas = array(
                'data-username' => $user_Details->name,
                'data-empid' => $user_Details->emp_id,
                'data-department' => $user_Details->department,
                'data-manager' => $user_Details->group_email,
                'data-manager-response' => '',
                'data-manager-name' => $mgr_Details->name,
                'data-empemailid' => $user_Details->email,
                'data-leavereason' => $request->get('remarks'),
                'data-leavetype' => $request->get('leavetype'),
                'data-from_date' => $request->get('fromdate'),
                'data-to_date' => $request->get('todate'),
                'data-no_ofdays' => $days,
                'data-leavestatus' => $leave_status,
                'data-leaveid' => $leave_id,
                'data-leave-image' => $fileName
            );
            $email_array = array(
                'template_name' => 'emails.user_leave_request',
                'Subject' => 'Leave request',
                'datas' => $datas,
            );
    
            
    
            $email_send = Role::common_emails($email_array);
    
    
        } 
    
            }
    
            
           // return redirect('leave/add/leave');
           // echo "1";
    
        }

   
    public  function userleave_delete(Request $request) {    
        
        
        $leave_CancelRequest = DB::table('user_leavelist')
                                        ->select('*')
                                        ->where('leave_id', '=', $request->id)
                                        ->where('user_id', '=', $request->user_id)
                                        ->get()->first();


        // echo '<pre>'; print_r($leave_CancelRequest->leave_type); exit('Testing');                                   ;


        /** User Deleted the leave email trigger to the respective manager and Account Team */
        $user_Details = Role::getUserDetailsByUserId($request->user_id);
        $datas = array(
            'data-username' => $user_Details->name,
            'data-empid' => $user_Details->emp_id,
            'data-department' => $user_Details->department,
            'data-manager' => $user_Details->group_email,
            'data-manager-response' => '',
            'data-empemailid' => $user_Details->email,
            'data-emailtext' =>'Cancel Leave Request',
            'data-empemailid' => $user_Details->email,
            'data-leavereason' => $leave_CancelRequest->remarks,
            'data-leavetype' => $leave_CancelRequest->leave_type,
            'data-from_date' => $leave_CancelRequest->from_date,
            'data-to_date' => $leave_CancelRequest->to_date,
            'data-no_ofdays' => $leave_CancelRequest->no_ofdays,
        );
        $email_array = array(
            'template_name' => 'emails.user_cancel_leave_request',
            'Subject' => 'Compuscript Employee Cancel Leave Notification',
            'datas' => $datas,
        );

        $email_send = Role::common_emails($email_array);
        
        $affected_row = DB::table('user_leavelist')
        ->where('leave_id', '=', $request->id)
        ->where('user_id', '=', $request->user_id)
        ->delete();
        if($affected_row==1) {
            return 1;
        } else {
            return 0;
        }
         
        

 
     }



     /* Accept Leave Application */


     public  function acceptuserleave(Request $request) {    
        
        
        $leave_CancelRequest = DB::table('user_leavelist')
                                        ->select('*')
                                        ->where('leave_id', '=', $request->id)
                                        ->where('user_id', '=', $request->user_id)
                                        ->get()->first();


        // echo '<pre>'; print_r($leave_CancelRequest->leave_type); exit('Testing');                                   ;


        /** User Deleted the leave email trigger to the respective manager and Account Team */
        $user_Details = Role::getUserDetailsByUserId($request->user_id);
        $mgr_Details = Role::getManager_byemail($user_Details->group_email);
        $datas = array(
            'data-username' => $user_Details->name,
            'data-empid' => $user_Details->emp_id,
            'data-department' => $user_Details->department,
            'data-manager' => $user_Details->group_email,
            'data-manager-response' => '',
            'data-manager-name' => $mgr_Details->name,
            'data-empemailid' => $user_Details->email,
            'data-emailtext' =>'Approve Leave Request',
            'data-empemailid' => $user_Details->email,
            'data-leavereason' => $leave_CancelRequest->remarks,
            'data-leavetype' => $leave_CancelRequest->leave_type,
            'data-from_date' => $leave_CancelRequest->from_date,
            'data-to_date' => $leave_CancelRequest->to_date,
            'data-no_ofdays' => $leave_CancelRequest->no_ofdays,
        );
        $email_array = array(
            'template_name' => 'emails.user_cancel_leave_request',
            'Subject' => 'Your leave request is approved',
            'datas' => $datas,
        );

        $email_send = Role::common_emails($email_array);
        
        $affected_row = DB::table('user_leavelist')
        ->where('leave_id', '=', $request->id)
        ->where('user_id', '=', $request->user_id)
        ->update([
            'leave_status' => 'Approved',

        ]);
        if($affected_row==1) {
            return 1;
        } else {
            return 0;
        }
         
        

 
     }









     /** User Leave Edit
      * Author : Muhammed Gani
      */

      public function user_leaveedit($id)
      {
  
          $user = User::find($id);
          
          $leave_list = Role::getAll_Leaves(Auth::user()->id,Auth::user()->role,Auth::user()->group_email);
          $leave_edit = Role::getEdit_Leaves($id);
          $leave_types = Role::getAll_LeaveType();
           // echo '<pre>'; print_r($leave_edit);
          return view('leave.edit', compact('user', 'leave_list', 'leave_types','leave_edit'));
      }
 

    /** User Leave Modules End */





    public static function manageremail()
    {

        $result = User::latest()->paginate(10);
        $mgr_emaillist = Role::getAll_ManagerEmailids();
        return view('manageremail.dashboard', compact('result', 'mgr_emaillist'));

    }

    public static function mgremaillist()
    {

        $mgr_emaillist = Role::getAll_ManagerEmailids();
        return view('manageremail.index', compact('mgr_emaillist'));

    }

    public static function insertmgremailid(Request $request)
    {

        if ($request->id == '') {

            DB::table('group_emails')->insert(
                [
                    'group_emailids' => $request->group_emails,

                ]
            );

            flash('Forgot Login Time has been added.');

        } else {

            DB::table('group_emails')
                ->where('gemail_id', $request->id)
                ->update([
                    'group_emailids' => $request->group_emails,

                ]);

            flash('Forgot Login Updated has been updated.');

        }

        return redirect('manageremail/add/mgremail');

    }

    public static function deletemgremailid(Request $request)
    {

        echo 'Delete this';

    }

    public function manageremailidedit($id)
    {

        $user = User::find($id);
        $mgr_Emailid = Role::get_MgrEmailid($id);

        return view('manageremail.edit', compact('user', 'mgr_Emailid'));
    }

    

    /** Trackingworkinghours functionality */

    public static function trackingworkinghours()
    {
        if(Auth::user()->designation=='1'){
            $tracking_hours_list = Role::get_AllTrackingHoursAdmin();

        
        } else {

            $tracking_hours_list = Role::get_AllTrackingHours(Auth::user()->id);
        }   
        return view('trackworkinghours.index', compact('tracking_hours_list'));

    }

    public static function trackingsearch(Request $request)
    {

        $from_date = date('y-m-d', strtotime($request->from_date));
        $to_date = date('y-m-d', strtotime($request->to_date));

        if(Auth::user()->designation=='1'){

            $tracking_hours_list = Role::get_AllTrackingHoursBydateAdmin($from_date, $to_date);

        }else {
            $tracking_hours_list = Role::get_AllTrackingHoursBydate($from_date, $to_date,Auth::user()->id);
        }


        
        return view('trackworkinghours.index', compact('tracking_hours_list'));

    }

    /** Trackingworkinghours functionality End */

    /** Report Module functionality Start */



    public static function reportdashboard()
    {

        $result = User::latest()->paginate(10);
        $mgr_emaillist = Role::getAll_ManagerEmailids();
        return view('reports.dashboard', compact('result', 'mgr_emaillist'));

    }





    public static function reports(Request $request)
    {

       // echo Auth::user()->group_email;

        if (!empty($request->emp_name) && empty($request->from_date) && empty($request->to_date)) {

            $tracking_hours_list = Role::get_AllTrackingReportHoursbyID($request->emp_name);
        } elseif (!empty($request->from_date) && empty($request->emp_name)) {
           

            $tracking_hours_list = Role::get_AllTrackingReportHoursbydate($request->from_date, $request->to_date);

        } elseif (!empty($request->emp_name) && !empty($request->from_date) && !empty($request->to_date)) {

            $tracking_hours_list = Role::get_AllTrackingReportHoursbyAll($request->emp_name, $request->from_date, $request->to_date);
        } else {

            if(Auth::user()->designation==1) {
            $tracking_hours_list = Role::get_AllTrackingReportHours();
            } else {
                $tracking_hours_list = Role::get_AllTrackingReportHoursbyID(Auth::user()->id);

            }


        }

        

        $user_list = Role::get_AllUsers();
        $user_listbymanager = Role::get_AllUsersbyMgr(Auth::user()->group_email);

        return view('reports.index', compact('tracking_hours_list', 'user_list','user_listbymanager'));

    }

    





    /** Report Module functionality End */


    /** Attendance Module Start */

    public static function attentance(Request $request)
    {

       // echo Auth::user()->group_email;

       

       $month_start_date = $request->from_date; //'01-'.date('m-Y');

       $end_start_date = $request->to_date; // '30-'.date('m-Y');
       

       $serach_from_date = '';
       $serach_end_date = '';


        $serach_from_date = $request->from_date; //str_replace('/','-',$request->from_date);
        $serach_end_date = $request->from_date; //str_replace('/','-',$request->to_date);

        if (!empty($request->emp_name) && empty($request->from_date) && empty($request->to_date)) {
           

            $tracking_hours_list = Role::get_AllTrackingReportHoursbyID($request->emp_name);

           /*  $serach_from_date = $request->from_date;
            $serach_end_date = $request->to_date; */
            


        } elseif (!empty($request->from_date) && empty($request->emp_name)) {
           

            $tracking_hours_list = Role::get_AllTrackingReportHoursbydate($request->from_date, $request->to_date);
          /*   $serach_from_date = $request->from_date;
            $serach_end_date = $request->to_date; */

        } elseif (!empty($request->emp_name) && !empty($request->from_date) && !empty($request->to_date)) {

           /*  echo "1111";
            echo $request->from_date;
       echo '<br>';
       echo $request->to_date;
       echo '<br>';
       echo 'User Id'.$request->emp_name; */

            $serach_from_date = $request->from_date;
            $serach_end_date = $request->to_date;

            $tracking_hours_list = Role::get_AllTrackingReportHoursbyID($request->emp_name);
            
            //Role::get_AllTrackingReportHoursbyAll($request->emp_name, $request->from_date, $request->to_date);
            /* $serach_from_date = $request->from_date;
            $serach_end_date = $request->to_date;  */
          //  echo '<pre>'; print_r($tracking_hours_list);


        } else {

            if(Auth::user()->designation==1) {
            $tracking_hours_list = Role::get_AllTrackingReportHours();
            } else {
                $tracking_hours_list = Role::get_AllTrackingReportHoursbyID(Auth::user()->id);

            }


        }

        if (empty($request->emp_name) && empty($request->from_date) && empty($request->to_date)) {

            $month_start_date = '01-'.date('m-Y');

            $end_start_date =  '30-'.date('m-Y');
           // echo "2222";

        $tracking_hours_list = Role::get_AllTrackingReportHoursbyAll(Auth::user()->id, $month_start_date,$end_start_date);
        }

        //  echo '<pre>Group Email Id :'; print_r(Auth::user()->group_email);

        $user_list = Role::get_AllUsers();
        $user_listbymanager = Role::get_AllUsersbyMgr(Auth::user()->group_email);

        return view('attentance.index', compact('tracking_hours_list', 'user_list','user_listbymanager','serach_from_date','serach_end_date'));

    }






    /** Attendance Module End */










    /** Cron Jobs */


    /**
     * Cron Email Functionality
     * Reminder email to be sent in the morning at 10 am
     * if the employee has not signed in or registered a holiday/sick day
     * Author : Muhammed Gani
     */

    public static function user_forgetlogin_email_cron()
    {

        $without_login_userlist = Role::withoutlogin_UsersList_today();

        foreach ($without_login_userlist as $user_Details) {

            $datas = array(
                'data-username' => $user_Details->name,
                'data-empid' => $user_Details->id,
                'data-emailtext' => 'You are not logged in 10 AM . if you forget please login immediately',
                'data-empworktype' => '',
                'data-empemailid' => $user_Details->email,
                'data-manager' => $user_Details->email,
            );
            $email_array = array(
                'template_name' => 'emails.user_loginreminder',
                'Subject' => 'Compuscript  Employee Login Reminder Notification',
                'datas' => $datas,
            );

            $email_send = Role::common_emails($email_array);

        }

        echo 'Emails Send Successfully';

    }

    /**
     * Cron Email Functionality
     * Reminder email to be sent in the evening if an employee has not signed out after 9 hours
     * Author : Muhammed Gani
     */

    public static function user_forgetloggedout_email_cron()
    {

        $without_logout_userlist = Role::withoutlogged_UsersList_today();

        foreach ($without_logout_userlist as $user_Details) {

            $datas = array(
                'data-username' => $user_Details->name,
                'data-empid' => $user_Details->id,
                'data-emailtext' => 'You are not logged today you system. if you forget please logout immediately',
                'data-empemailid' => $user_Details->email,
                'data-manager' => $user_Details->email,
                'data-empworktype' => $user_Details->work_type,
            );
            $email_array = array(
                'template_name' => 'emails.user_loginreminder',
                'Subject' => 'Compuscript  Employee Logout Reminder Notification',
                'datas' => $datas,
            );

            $email_send = Role::common_emails($email_array);

        }

        echo 'Emails Send Successfully';

    }



    public static function weekly_TimesheetReport() {
        $monday = strtotime("last monday");
        $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
        $sunday = strtotime(date("Y-m-d",$monday)." +4 days");
        $this_week_sd = date("Y-m-d",$monday);
        $this_week_ed = date("Y-m-d",$sunday);
        $weekly_TimeSheet = Role::weekly_TimesheetReport($this_week_sd,$this_week_ed);

        foreach ($weekly_TimeSheet as $week) {
            $datas = array(
                'data-username' => 'Account Team',
                'data-empid' => '',
                'data-emailtext' => 'This is a weekly report of the employee’s working status. This is an auto-generated email.',
                'data-empemailid' => $week->email,
                'data-manager' => $week->group_email,
            );

            $email_array = array(
                'template_name' => 'emails.employees_weekly_report',
                'Subject' => 'Compuscript  Employees Weekly Reports',
                'datas' => $datas,
                'reports' => $weekly_TimeSheet,
            );

            $email_send = Role::common_emails($email_array);
        }
    }


    public static function bank_NationalHolidaynotify() {

        $tomorrow = date("Y-m-d", strtotime("+ 1 day"));

        $is_CheckNationalHolidays = Role::bank_NationalHolidays($tomorrow);

        if(!empty($is_CheckNationalHolidays)) {

            
            $Users  = Role::get_AllUsers();
            

            foreach($Users  as $user_Details) {

                $datas = array(
                    'data-username' => $user_Details->name,
                    'data-empid' => $user_Details->emp_id,
                    'data-emailtext' => 'Today - '.$is_CheckNationalHolidays->holiday_type,
                    'data-empemailid' => $user_Details->email,
                    'data-manager' => $user_Details->email,
                    'data-holidaydate' => $is_CheckNationalHolidays->date,
                );
                $email_array = array(
                    'template_name' => 'emails.bank_holiday_notify',
                    'Subject' => 'Compuscript Bank/Public Holidays Notification',
                    'datas' => $datas,
                );

                try {
                    $email_send = Role::common_emails($email_array);
                    if($email_send) {
                       
                        DB::table('tracking_emails_history')->insert([
                            ['email_subject' => 'Bank/Holiday', 'email_id' => $user_Details->email,'send_date'=>date('Y-m-d')],
                            
                        ]); 

                    }
                  }
                  catch (\Exception $e) {
                     // return $e->getMessage();
                  }

            }
           
           
        }


    }


    /** Department Module Start */

    public static function departmentlist()
    {

        $result = User::latest()->paginate(10);
        $department_list = Role::get_AllDepartment();
        return view('department.dashboard', compact('result', 'department_list'));

    }

    public static function department()
    {

        $department_List = Role::get_AllDepartment();
        return view('department.index', compact('department_List'));

    }

       public static function insertdepartment(Request $request)
    {

        if ($request->id == '') {

            DB::table('department')->insert(
                [
                    'dept_name' => $request->dept_name,

                ]
            );

            flash('Department has been added.');

        } else {

            DB::table('department')
                ->where('dept_id', $request->id)
                ->update([
                    'dept_name' => $request->dept_name,

                ]);

            flash('Department has been updated.');

        }

        return redirect('department/add/department');

    }


    public function departmentEdit($id)
    {

        $user = User::find($id);
        $dept_Details = Role::get_Department($id);

        return view('department.edit', compact('user', 'dept_Details'));
    }

     public static function deletedepartment(Request $request)
    {

        return $is_delete = DB::table('department')->where('dept_id', $request->id)->delete();


    }

    /** Department Modules End */


    /** Employee Leave Report Modules */
    public static function emplleavereports(Request $request)
    {

        if (!empty($request->emp_name) && empty($request->from_date) && empty($request->to_date)) {

            $leave_list = Role::get_AllEmpLeaveReportbyID($request->emp_name);
        } elseif (!empty($request->from_date) && empty($request->emp_name)) {
           

            $leave_list = Role::get_AllEmpLeaveReportbydate($request->from_date, $request->to_date);

        } elseif (!empty($request->emp_name) && !empty($request->from_date) && !empty($request->to_date)) {

            $leave_list = Role::get_AllEmpLeaveReportbyAll($request->emp_name, $request->from_date, $request->to_date);
        } else {
            $leave_list = Role::get_AllLeaveReports();
        }

        $user_list = Role::get_AllUsers();

        return view('employeeleavereport.index', compact('leave_list', 'user_list'));

    }




    /** Author : Muhammed
     *  Change Password Module
     */

    public function change_password()
    {
        $id=1;
        $user = User::find($id);
        $holidays_types = Role::getAll_HolidayType();

        $holidays_edit = Role::getAll_HolidaysById($id);
        // echo '<pre>'; print_r($holidays_edit);
        return view('changepassword.edit', compact('user', 'holidays_edit', 'holidays_types'));
    }

    public function update_password() {

        $password = Role::Update_Password(bcrypt($_POST['password']),Auth::user()->id);        
        flash('Password has been updated.');
        return redirect('home');

    }




    public static function openexefiles() {
       // $answer = shell_exec("D://PythonClass/XmlWX.exe");
     $file_name ="\\\\pdmr-dc01\SoftwareTeam\Web_Technology_Teams\\test.pdf";
     $answer = shell_exec($file_name);
    //  $answer = shell_exec("E:\Muhammedgani_Time_Sheet\TaskList.xlsx");
    //   echo $answer."</br>";
    }



    public static function forgetlogin_accept_user(Request $request) {

        

        $accept_ids = trim($request->id,",");
        
        //echo '<pre>Explode Value : '; print_r(explode(",",$accept_ids));

        $accept_ids_value = explode(",",$accept_ids);

        foreach($accept_ids_value as $accept_v) {
           // echo "Accept Val".$accept_v;


            $accept_user_detail = Role::getForget_user_detail($accept_v);

          //  echo '<pre>Entrance Log Details'; print_r($accept_user_detail); exit;   

          


            

            $entrance_log_details = Role::getEntrance_log_details($accept_user_detail->user_id,$accept_user_detail->forget_date,$accept_user_detail->from_time,$accept_user_detail->to_time);
            

            //exit;
        }

        echo $entrance_log_details;
        
    }



   public static function breakstore(Request $request){
    
        
        DB::table('break_time')->insert(
                            [
                                'break_out' => $_REQUEST['break_out'],
                                'break_date' => date('Y-m-d'),
                                'break_reason' => $_REQUEST['break_reason'],
                                'user_id' => Auth::user()->id,
                                
                            ]
                            );
    
    echo "1";
    
   }




   /** Leave bulk approval */



   public static function leave_acceptbulk_mgr(Request $request) {

        

    $accept_ids = trim($request->id,",");
    
    //echo '<pre>Explode Value : '; print_r(explode(",",$accept_ids));

    $accept_ids_value = explode(",",$accept_ids);



   


    foreach($accept_ids_value as $accept_v) {
      
        $accept_leave = Role::leave_approval_mgr_bulk($accept_v);



        $get_user_id =   Role::getUserId($accept_v);    
        $user_Details = Role::getUserDetailsByUserId($get_user_id->user_id);

        $mgr_Details = Role::getManager_byemail($user_Details->group_email);
            $datas = array(
                'data-username' => $user_Details->name,
                'data-manager' => $user_Details->email,
                'data-leavestatus' => $get_user_id->leave_status,
                'data-from_date' => date('d-m-Y',strtotime($get_user_id->from_date)),
                'data-to_date' => date('d-m-Y',strtotime($get_user_id->to_date)),
                'data-manager-name' => $mgr_Details->name,
                'data-leave_type' => $get_user_id->leave_type
            );
            $email_array = array(
                'template_name' => 'emails.approve_leave_status',
                'Subject' => 'Your leave request is approved',
                'datas' => $datas,
            );
    
            $email_send = Role::common_emails($email_array);




    }

    echo $accept_leave;
    
}



public static function leave_rejectbulk(Request $request) {

        

    $accept_ids = trim($request->id,",");
    
    //echo '<pre>Explode Value : '; print_r(explode(",",$accept_ids));

    $accept_ids_value = explode(",",$accept_ids);

    foreach($accept_ids_value as $accept_v) {
      
        $accept_leave = Role::leave_reject_mgr_bulk($accept_v);


        $get_user_id =   Role::getUserId($accept_v);    
        $user_Details = Role::getUserDetailsByUserId($get_user_id->user_id);

        $mgr_Details = Role::getManager_byemail($user_Details->group_email);

            $datas = array(
                'data-username' => $user_Details->name,
                'data-manager' => $user_Details->email,
                'data-leavestatus' => $get_user_id->leave_status,
                'data-from_date' => date('d-m-Y',strtotime($get_user_id->from_date)),
                'data-to_date' => date('d-m-Y',strtotime($get_user_id->to_date)),
                'data-manager-name' => $mgr_Details->name,
                'data-leave_type' => $get_user_id->leave_type
            );
            $email_array = array(
                'template_name' => 'emails.reject_leave_status',
                'Subject' => 'Your leave request is not approved',
                'datas' => $datas,
            );
    
            $email_send = Role::common_emails($email_array);




    }

    echo $accept_leave;
    
}







public function leavebalance_details($id)  {

    
   

        $emp_id = $id;

        // print_r($permissions);
        $result = User::latest()->paginate(10);
        //$leave_list = Role::getAll_Leaves(Auth::user()->id,Auth::user()->role,Auth::user()->group_email);
        $leave_list = Role::getAll_EmployeeLeave_All($emp_id);
       

        $leave_edit = '';
        $leave_types = Role::getAll_LeaveType();
       /*  echo '<pre>'; print_r($leave_list);
        exit('Testing'); */
        return view('leave.leavebalance_details', compact('result', 'leave_list', 'leave_edit', 'leave_types'));

    }



    /* Tickets Moduels */

    public static function tickets()
    {
        $user_id = Auth::user()->id;

        if($user_id==1 || $user_id==60 || $user_id==84 || $user_id==92 || $user_id==73) {
        $result = Role::getAll_tickets();
        } else {
            $result = Role::getAll_ticketsByUsersId($user_id);
        }
        return view('tickets.dashboard', compact('result','user_id'));


    }


    public static function ticket_list(Request $request)
    {

        //echo '<pre>'; print_r($request->holidayyear);
        //exit;

        if($request->holidayyear!='') {

            $type_of_request =$request->holidayyear;
        } else {
            $type_of_request ='';
        }
        $current_year = date('Y');
        $result = User::latest()->paginate(10);
        $holidays_list = Role::getAll_Holidays($current_year);
        $holidays_edit = '';
        $holidays_types = Role::getAll_HolidayType();

        $user_id =Auth::user()->id;
        


        if($user_id==1 || $user_id==60 || $user_id==84 || $user_id==92 || $user_id==73) {

            if(empty($type_of_request)) {
            $tickets_list = Role::getAll_tickets();
            } else {
                $tickets_list = Role::getAll_ticketsbytypenew($type_of_request);
            }
            } else {
                $tickets_list = Role::getAll_ticketsByUsersId($user_id);
            }
        
        // $tickets_list = Role::getAll_tickets();


        return view('tickets.index', compact('result', 'holidays_list', 'holidays_edit', 'holidays_types','tickets_list','user_id'));
    }


    public function ticketstore(Request $request)
    {

        
        $filePath ='';
      //  echo '<pre>'; print_r($request->file('file_attached'));
        $file = $request->file('file_attached');
      //  if(!empty($file)) {
        $file = $request->file('file_attached');
        if ($file) {
            $inputPath =  public_path().'/uploads';
            if($file->move($inputPath,$file->getClientOriginalName())) {
                $fileName = $file->getClientOriginalName();
                $filePath = url('/').'/uploads/'.$file->getClientOriginalName();
            } else {
                $filePath = '';
            }  
        } else {
            $filePath = '';
        }

/*         echo $filePath;
        exit;   */

        DB::table('tickets')->insert(
            ['ticket_id' => $request->ticket_id, 'request_type' => $request->request_type, 'ticket_remarks' => $request->ticket_remarks, 'cc_email' => $request->cc_email, 'request_user' => Auth::user()->id,'file_attached'=>$filePath]
        );
        flash('Ticket has been created.');

       // echo 'User Id'.Auth::user()->id;

        $user_Details = Role::getUserDetailsByUserId(Auth::user()->id);

        /* echo '<pre>'; print_r($user_Details);
        exit; */

        $types_of_request = '';
        if($request->request_type=='TS') {
            $types_of_request = 'Time Sheet';

        }else if($request->request_type=='SI') {
            $types_of_request = 'System Issue';

        }else if($request->request_type=='Tech') {
            $types_of_request = 'Technical Support';

        }else if($request->request_type=='PI') {
            $types_of_request = 'Personal Information';

        }else if($request->request_type=='H') {
            $types_of_request = 'Holidays';

        }






        if(!empty($user_Details)) {
        $datas = array(
            'data-username' => $user_Details->name,
            'data-empid' => $user_Details->emp_id,
            'data-department' => $user_Details->department,
            'data-manager' => $user_Details->group_email,
            'data-manager-response' => '',
            'data-empemailid' => $user_Details->email,
            'data-ticketid' =>$request->ticket_id,
            'data-remarks' =>$request->ticket_remarks,
            'data-typeof' => $types_of_request
        );
        $email_array = array(
            'template_name' => 'emails.tickets_notify',
            'Subject' => 'TMS ticket raised. Reference : '.$request->ticket_id,
            'type_of_request' => $types_of_request,  
            'ticket_id' => $request->ticket_id, 
            'user_email' => $user_Details->email,
            'datas' => $datas,
        );

        $email_send = Role::ticket_emails($email_array);
        $email_send = Role::ticket_ackn_emails($email_array);

    }

        return redirect('tickets/add/ticket');
        


    }



    public  function ticket_assign_department(Request $request) {
        

       /*  echo $request->id;
        echo $request->department; */
        //exit;
        DB::enableQueryLog();
        $affected_row = DB::table('tickets')->where('id', $request->id)->update(['assign_to' => $request->department]);
       /*  $query = DB::getQueryLog();
        $lastQuery = end($query);
        print_r($lastQuery);
        exit; */

        $ticket_details = Role::getTicketById($request->id);

        if($request->department=='Backend Support') {


        $types_of_request = '';
        if($ticket_details[0]->request_type=='TS') {
            $types_of_request = 'Time Sheet';

        }else if($ticket_details[0]->request_type=='SI') {
            $types_of_request = 'System Issue';

        }else if($ticket_details[0]->request_type=='Tech') {
            $types_of_request = 'Technical Support';

        }else if($ticket_details[0]->request_type=='PI') {
            $types_of_request = 'Personal Information';

        }else if($ticket_details[0]->request_type=='H') {
            $types_of_request = 'Holidays';

        }

        $user_Details = Role::getUserDetailsByUserId($ticket_details[0]->request_user);

        $subject = 'Ticket forwarded to backend team  Type of request : '.$types_of_request.' Ticket NO : '.$ticket_details[0]->ticket_id;

            
            if(!empty($ticket_details)) {
                $datas = array(
                    'data-ticketid' => $ticket_details[0]->ticket_id,
                    'data-ccemail'  => $ticket_details[0]->cc_email,
                    'data-ticket_remarks' => $ticket_details[0]->ticket_remarks,
                    'data-username' => $user_Details->name,
                    'data-typesofrequest' =>$types_of_request
                    
                );
                $email_array = array(
                    'template_name' => 'emails.tickets_department_notify',
                    'Subject' => $subject, 
                    'user_email' =>$user_Details->email,
                    'type_of_request' => $types_of_request,                
                    'datas' => $datas,
                );
        
                $email_send = Role::ticketdepartment_notify_emails($email_array);
                $email_ackn_send = Role::ticketdepartment_notify_ackn_emails($email_array);
        
            }

        }


        return ($affected_row==1)?$affected_row:0;
       
 
 
     }




     public  function ticket_compus_assign_status(Request $request) {
        

        /*  echo $request->id;
         echo $request->department; */
         //exit;
         DB::enableQueryLog();
         $affected_row = DB::table('tickets')->where('id', $request->id)->update(['ticket_status' => $request->status]);
        /*  $query = DB::getQueryLog();
         $lastQuery = end($query);
         print_r($lastQuery);
         exit; */
        
         return ($affected_row==1)?$affected_row:0;
        
  
  
      }



      public function ticketEdit($id)
    {

       
        $ticket_Details = Role::getTicketById($id);

        return view('tickets.edit', compact('ticket_Details'));
    }


     public function updatetikcets(Request $request) {

       // echo $request->id;
        $response_date = date('d-m-Y');
        $response_date_status = $request->ticket_status;

        DB::table('tickets')->where('id',$request->id)->update(['response_comment' => $request->response_comment,'response_date' =>$response_date,'ticket_status'=>$response_date_status]);
        flash('Ticket response successfully.');



        $ticket_details = Role::getTicketById($request->id);

       // echo '<pre>'; print_r($ticket_details[0]->request_user); exit;

        $user_Details = Role::getUserDetailsByUserId($ticket_details[0]->request_user);

        /* echo '<pre>'; print_r($user_Details);
        exit; */
         
        $types_of_request = '';
        if($ticket_details[0]->request_type=='TS') {
            $types_of_request = 'Time Sheet';

        }else if($ticket_details[0]->request_type=='SI') {
            $types_of_request = 'System Issue';

        }else if($ticket_details[0]->request_type=='Tech') {
            $types_of_request = 'Technical Support';

        }else if($ticket_details[0]->request_type=='PI') {
            $types_of_request = 'Personal Information';

        }else if($ticket_details[0]->request_type=='H') {
            $types_of_request = 'Holidays';

        }    


        if(!empty($user_Details)) {
        $datas = array(
            'data-username' => $user_Details->name,
            'data-empid' => $user_Details->emp_id,
            'data-department' => $user_Details->department,
            'data-manager' => $user_Details->group_email,
            'data-manager-response' => '',
            'data-empemailid' => $user_Details->email,
            'data-ticketid' => $ticket_details[0]->ticket_id,
            'data-ccemail'  => $ticket_details[0]->cc_email,
            'data-ticketdate'  => date('d-m-Y',strtotime($ticket_details[0]->created_date)),
            'data-responsecomment' => $request->response_comment,
            'data-responsestatus' => $response_date_status,
            'data-typesofresponse' => $response_date_status
        );
        

        $subject = 'TMS ticket resolved. Reference : '.$ticket_details[0]->ticket_id;
        $email_array = array(
            'template_name' => 'emails.tickets_response_notify',
            'Subject' => $subject,
            'users_email' => $user_Details->email,
            'datas' => $datas,
        );

        $email_send = Role::ticketresponse_emails($email_array);

    }

        return redirect('tickets/add/ticket');

     }


public function leave_approve_via_email(Request $request) {

    $accept_v = $request->id;

    $accept_leave = Role::leave_approval_mgr_bulk($accept_v);
   // echo 'Success';    

    return view('leave.leave_confirmation_viamail');
}

public function leave_reject_via_email(Request $request) {

    $accept_v = $request->id;

    $accept_leave = Role::leave_reject_mgr_bulk($accept_v);
   // echo 'Success';    

    return view('leave.leave_confirmation_viamail');
}

public function forgetlogin_accept_via_email(Request $request) {

    $accept_v = $request->id;

    $accept_leave = Role::forget_approval_mgr_bulk($accept_v);
   // echo 'Success';    

    return view('leave.leave_confirmation_viamail');
}

public function forgetlogin_reject_via_email(Request $request) {

    $reject_v = $request->id;

    $accept_leave = Role::forget_reject_mgr_bulk($reject_v);
   // echo 'Success';    

    return view('leave.leave_confirmation_viamail');
}


public function leavelistdeatils_ajax() {


    $leave_details =  Role::getAll_Leaves_bymonth(Auth::user()->id,'0',Auth::user()->group_email);

    $bank_holidays =  Role::getAll_bank_bymonth();

   
    


foreach($leave_details as $item)
{
 $data[] = array(
  'id'   =>  $item->leave_id,
  'title'   => $item->name,
  'start'   => $item->from_date.' 00:00:00',
  'end'   => $item->to_date. ' 12:12:00',
  'reason' =>(Auth::user()->role=='17')?'Reason :'.$item->remarks:"",
  //'reason' =>'Reason :'.$item->remarks,
  'noofdays' =>$item->no_ofdays,
  'status' =>(Auth::user()->role=='17')?'Leave Status : '.$item->leave_status:"",
 );
}


foreach($bank_holidays as $b_item)
{
 $b_data[] = array(
  'id'   =>  $b_item->id,
  'title'   => $b_item->holiday_remarks,
  'start'   => $b_item->date.' 00:00:00',
  'end'   => $b_item->date. ' 12:12:00',
  'reason' =>$b_item->holiday_remarks,
  'noofdays' =>1,
  'status' =>"public Holiday",
 );
}


$final_array = array_merge($data,$b_data);
/*  echo '<pre>'; print_r($final_array);
    exit; */


echo json_encode($final_array);



   // echo '[{"id":"3","title":"GK","start":"2021-03-10 00:00:00","end":"2021-03-11 00:00:00"},{"id":"4","title":"I need to show a popup (balloon popup as in google calendar) while creating an event in the jquery full calenda","start":"2021-03-10 00:00:00","end":"2021-03-11 00:00:00"},{"id":"5","title":"Welcome to leave calendar","start":"2021-03-10 00:00:00","end":"2021-03-11 00:00:00"}]';



}


public function leavelistdeatils_ajax_bkp() {


    $leave_details =  Role::getAll_Leaves_bymonth(Auth::user()->id,Auth::user()->role,Auth::user()->group_email);

    


    foreach($leave_details as $item)
{
 $data[] = array(
  'id'   =>  $item->leave_id,
  'title'   => $item->name,
  'start'   => $item->from_date.' 00:00:00',
  'end'   => $item->to_date. ' 12:12:00',
  'reason' =>$item->remarks,
  'noofdays' =>$item->no_ofdays,
  'status' =>$item->leave_status,
 );
}

echo json_encode($data);



   // echo '[{"id":"3","title":"GK","start":"2021-03-10 00:00:00","end":"2021-03-11 00:00:00"},{"id":"4","title":"I need to show a popup (balloon popup as in google calendar) while creating an event in the jquery full calenda","start":"2021-03-10 00:00:00","end":"2021-03-11 00:00:00"},{"id":"5","title":"Welcome to leave calendar","start":"2021-03-10 00:00:00","end":"2021-03-11 00:00:00"}]';



}



/* with draw functionality */

public  function userleave_withdraw(Request $request) {   
    
    

       //echo 'Testing'.$request->id ; exit;
        
    $leave_CancelRequest = DB::table('user_leavelist')
                                    ->select('*')
                                    ->where('leave_id', '=', $request->id)                                   
                                    ->get()->first();


                                   


    /** User Deleted the leave email trigger to the respective manager and Account Team */
    $user_Details = Role::getUserDetailsByUserId($leave_CancelRequest->user_id);
    $mgr_Details = Role::getManager_byemail($user_Details->group_email);

    $datas = array(
        'data-username' => $user_Details->name,
        'data-empid' => $user_Details->emp_id,
        'data-department' => $user_Details->department,
        'data-manager' => $user_Details->group_email,
        'data-manager-response' => '',
        'data-manager-name' => $mgr_Details->name,
        'data-empemailid' => $user_Details->email,
        'data-emailtext' =>'Cancel Leave Request',
        'data-empemailid' => $user_Details->email,
        'data-leavereason' => $leave_CancelRequest->remarks,
        'data-leavetype' => $leave_CancelRequest->leave_type,
        'data-from_date' => $leave_CancelRequest->from_date,
        'data-leave_status' => $leave_CancelRequest->leave_status,
        'data-to_date' => $leave_CancelRequest->to_date,
        'data-no_ofdays' => $leave_CancelRequest->no_ofdays,
    );
    $email_array = array(
        'template_name' => 'emails.user_withdraw_leave_request',
        'Subject' => 'Leave withdrawn',
        'datas' => $datas,
    );

    $email_send = Role::withdraw_common_emails($email_array);
    
    $affected_row =  DB::table('user_leavelist')
    ->where('leave_id', $request->id)
    ->update(['leave_status' => 'Withdraw']);


    if(true) {
        return 1;
    } else {
        return 0;
    }
     
 }


 public function all_leaves_bymonth_ajax(Request $request ) {

     $month = $request->id;  
     $year = $request->year; //exit;
    //print_r($leave_details); exit;
    $leave_details =  Role::getAll_Leaves_bymonth_ajax(Auth::user()->id,Auth::user()->role,Auth::user()->group_email,$month,$year);
   //$leave_details =  Role::getAll_Leaves_bymonth_ajax($month,$year);
 
   // print_r($leave_details); exit;
  
$result1 = '<tr>';
foreach($leave_details as $item) {

//echo $item->leave_status;



$result1 .= '<td>'.$item->name.'</td>';
$result1 .= '<td>'.$item->leave_type.'</td>';
$result1 .= '<td>'.$item->no_ofdays.'</td>';
$result1 .= '<td>'.$item->from_date."--".$item->to_date.'</td>';
if($item->leave_status=='Pending'){
    $result1 .= '<td><a href="leave/add/leave"  >'.$item->leave_status.'</a></td>';
}else{
    $result1 .= '<td>'.$item->leave_status.'</td>';
}


$result1 .= '</tr>';

}

$bank_holidays =  Role::getAll_bank_bymonth_table($year,$month);


foreach($bank_holidays as $b_item) {
    $result1 .= '<tr style="color:red;font-weight:bold;">';

    $no_ofdays = '1';
    $leave_type = 'Ireland Holiday';
   // $no_ofdays = 'Bank Holidays';
    $status = 'N/A';
    $result1 .= '<td>'.$leave_type.'</td>';
    $result1 .= '<td>'.$b_item->holiday_remarks.'</td>';
    $result1 .= '<td>'.$no_ofdays.'</td>';
    $result1 .= '<td>'.$b_item->date."--".$b_item->date.'</td>';
    $result1 .= '<td>'.$status.'</td>';
    
    
    
    
    $result1 .= '</tr>';
    
    }

   
   echo $result1;
    

 }


 /* break time user */

 public static function get_break_time_user($user_id) 
      {


$break_time =  Role::get_break_time($user_id);

return $break_time;

 
      }

     
    public static function getbankholidays_count() {

       /*  echo $_REQUEST['fromdate'].$_REQUEST['todate'];
        exit; */

        $bank_holidays = Role::get_bank_holidays_inbetweendays(date('Y-m-d',strtotime($_REQUEST['fromdate'])),date('Y-m-d',strtotime($_REQUEST['todate'])));

        print_r($bank_holidays);

        // return $bank_holidays;


    }
     
 






} // Main End