<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\EntranceLog;
use DB;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public static function createTeam($userId, $teamId)
    {
        $id = DB::table('user_team')->insertGetId(['user_id' => $userId, 'team_id' => $teamId]);
        return $id;
    }

    public static function updateTeam($userId, $teamId)
    {
        DB::table('user_team')->where('user_id', $userId)->update(['team_id' => $teamId]);
    }

    public static function updateUser($userData, $userId) {
        DB::table('users')->where('id', $userId)->update($userData);    
    }

    public static function getUser($userid) {
        $user = DB::table('users')->select('*')        
        ->join('department', 'users.department', '=', 'department.dept_id')
        // ->join('group_emails', 'group_emails.gemail_id', '=', 'users.group_email')
        ->where('id', '=', $userid)
        ->first();
        return $user;
    }

    public static function getCategory($cat) {
        $category = DB::table('employee_category')->select('type')->where('id', '=', $cat)->first();
        return $category;
    }

    public static function addShiftTime($shifTimeData) {

      
        $is_exists = DB::table('employee_shifttime')->select('*')
                        ->where('shift_emp_id',$shifTimeData['shift_emp_id'])                        
                        ->whereBetween('shift_start_date', array($shifTimeData['shift_start_date'], $shifTimeData['shift_start_date']))->first();

        if(count($is_exists)==0) {        
        $id = DB::table('employee_shifttime')->insertGetId(
            $shifTimeData
        );     
        } else {
            DB::table('employee_shifttime')
            ->where('shift_emp_id', $shifTimeData['shift_emp_id'])
            ->whereBetween('shift_start_date', array($shifTimeData['shift_start_date'], $shifTimeData['shift_start_date']))
            ->update($shifTimeData);
        }


       // echo '<pre>'; print_r($shifTimeData);


    }
}
