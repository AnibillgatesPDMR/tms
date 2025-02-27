<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\Authorizable;
use APP\Enterance_log;
use App\Mail\AppMailler;
use Mail;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;


class HolidayController extends Controller
{
    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
       
        $result = User::all();
        return view('holidays.dashboard', compact('result'));
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
        $val = array('department' =>'','job' => '');
        $department_Id = '';
        $group_emails = Role::getGroupEmails();
        $group_emails_Id = '';
        $job_assign = Role::getJobAssign();    
        $jobs ='';    
        $emp_designation = Role::getEmployeeDesignation();
        $designation_Id ='';
        $emp_floorDetails = Role::getEmpFloorDetails();
        $floor_Id = '';
        $emp_intercom = Role::getIntercom();
        $emp_intercom_Id ='';
        $user= '';

        return view('user.index', compact('result', 'roles', 'teams', 'category', 'teamId', 'catId','department','department_Id','group_emails','group_emails_Id','job_assign','jobs', 'emp_designation','designation_Id','emp_floorDetails','floor_Id','emp_intercom','emp_intercom_Id','val'));
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

    public function viewUser($id) {
        $user = User::getUser($id);        
        return view('user.view', compact('user'));
    }

    public function shifttime($id) {
        $user = User::getUser($id);
        $shifttime = Role::getShiftTime();
        return view('user.shift', compact('user','shifttime'));
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
            'team' => 'required|min:1',
            'emp_id' => 'required|min:1',
            'designation' => 'required|min:1',
            'department' => 'required|min:1',  
            'group_email' => 'required|min:1',           
            'gender' => 'required|min:1',
            'emp_category' => 'required|min:1'
            
            
        ]);


        // hash password
        $request->merge(['password' => bcrypt($request->get('password'))]);
        $team = $request->get('team');
        $createdBy = $request->get('created_by');
        // Create the user
        if ( $user = User::create($request->except('roles', 'permissions', 'team', 'emp_id', 'designation', 'department', 'group_email', 'login_access', 'gender', 'emp_category')) ) {
            $userData = [
                'emp_id' => $request->get('emp_id'),
                'designation' => $request->get('designation'),
                'department' => $request->get('department'), //implode(",", $request->get('department')), 
                'group_email' => $request->get('group_email'),
                'login_access' => $request->get('login_access'),
                'gender' => $request->get('gender'),
                'emp_category' => $request->get('emp_category'),
                'created_by' => $createdBy,                
                'emp_intercomeno' =>$request->get('emp_intercomeno'),
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

    public static function insertshift(Request $request) {


        $begin = new DateTime($request->get('shift_start_date'));
        $end   = new DateTime($request->get('shift_end_date'));

        for($i = $begin; $i <= $end; $i->modify('+1 day')){
           // echo $i->format("Y-m-d");
           // echo "<br />";

            $shifData = [
                'shift_time' => $request->get('shift_time'),
                'shift_start_date' => $i->format("Y-m-d"),
                'shift_end_date' => $i->format("Y-m-d"),
                'shift_emp_id' => $request->get('shift_emp_id'),
                'created_by' =>Auth::id()
                
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
         $user= User::find($id);
      //  print_r($user);     


        $jobs = Role::getJobById($id);        
        $val = ['job' => '', 'department' => $user->department];
        $roles = Role::pluck('name', 'id');
        $teams = Role::getTeam();
        $category = Role::getCategory();
        $teamId = Role::getTeamById($id);
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
       
       
        return view('user.edit', compact('user', 'roles', 'permissions', 'teams', 'teamId', 'category', 'catId', 'department','department_Id','group_emails','group_emails_Id','job_assign','jobs','emp_designation','designation_Id','emp_floorDetails','floor_Id','emp_intercom','emp_intercom_Id','val'));
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
            'team' => 'required|min:1'
        ]);

        // Get the user
        $user = User::findOrFail($id);

        // Update user
        $user->fill($request->except('roles', 'permissions', 'password', 'team', 'emp_id', 'designation', 'department', 'ot', 'job', 'group_email', 'login_access', 'gender', 'emp_category'));
        User::updateTeam($id, $request->get('team'));
        $userData = [
            'emp_id' => $request->get('emp_id'),
            'designation' => $request->get('designation'),
            //'department' => implode(",", $request->get('department')),
            'department' => $request->get('department'),
            'group_email' => $request->get('group_email'),
            'login_access' => $request->get('login_access'),
            'gender' => $request->get('gender'),
            'emp_category' => $request->get('emp_category'),           
            'emp_intercomeno' =>$request->get('emp_intercomeno'),
        ];
        User::updateUser($userData, $id);
        // check for password change
        if($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        // Handle the user roles
        $this->syncPermissions($request, $user);

        $user->save();

        flash()->success('User has been updated.');

        return redirect()->route('users.index');
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
        if ( Auth::user()->id == $id ) {
            flash()->warning('Deletion of currently logged in user is not allowed :(')->important();
            return redirect()->back();
        }

        if( User::findOrFail($id)->delete() ) {
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
        if( ! $user->hasAllRoles( $roles ) ) {
            // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);

        return $user;
    }

    public static function getUser($userid) {
        $user = User::find($userid);
        return $user;
    }

    public static function getCategory($cat) {
        $category = User::getCategory($cat);
        return $category;
    }

    public static function getLogindetailById($uer_id) {
       $login_details = Role::getLogindetail($uer_id);
       return $login_details;
    }

    public static function getWeekTimeSheet($user_id) {

        $weekTimeSheet = Role::getWeekTimeSheet($user_id);
        return $weekTimeSheet;

    }

    


 

}
