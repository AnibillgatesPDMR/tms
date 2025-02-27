@extends('layouts.app')

@section('title', 'Users')

@section('content')
<?php
use App\Role;
use \App\Http\Controllers\UserController;
?>
<div class="row">
    <div class="col-md-5">
        <h3 class="modal-title">User Details</h3>
    </div>
    <div class="col-md-7 page-action text-right">
        <a href="{{ asset('users/add/user') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
    </div>
</div>
<div class="result-set">
    <table class="table table-bordered table-striped table-hover" id="data-table">
    <tr><td><b>Name</b></td><td>{{$user->name}}</td></tr>
    <tr><td><b>Email</b></td><td>{{$user->email}}</td></tr>
    <tr><td><b>Employee id</b></td><td>{{$user->emp_id}}</td></tr>
    <tr><td><b>Designation</b></td>
    <td>
    <?php
$designation_name = Role::getDesignationdetails($user->designation);
echo $designation_name[0]->emp_designation;
?>

    </td>
    </tr>
    <tr><td><b>Department</b></td>
    <td>
    {{$user->dept_name}}
    </td>

    </tr>


   

     <tr><td><b>Employee InterCom Number</b></td>
    <td>
    
    <?php
    $emp_intercom = Role::getIntercomdetails($user->emp_intercomeno);
    echo $emp_intercom[0]->emp_intercomeno;
    ?>
    </td>

    </tr>




  

    
    <tr><td><b>Manager Email Id</b></td><td>{{$user->group_emailids}}</td></tr>
    <tr><td><b>Login Access</b></td><td><?php if ($user->login_access == 1) {echo "Yes";} else {echo "Blocked";}?></td></tr>

    <tr><td><b>Gender</b></td><td><?php if ($user->gender == 1) {echo "Male";} else {echo "Female";}?></td></tr>
    <tr><td><b>Employee Category </b></td><td><?php $cat = UserController::getCategory($user->emp_category);
echo $cat->type;?></td></tr>

    <tr><td><b>Created By</b></td><td><?php $userdata = UserController::getUser($user->created_by);
compact('user');
echo $userdata->name;?></td></tr>
    <tr><td><b>Created At</b></td><td>{{$user->created_at}}</td></tr>
    <tr><td><b>Updated At</b></td><td>{{$user->updated_at}}</td></tr>
    </table>
</div>
@endsection