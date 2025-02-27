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
<?php // echo '<pre>'; print_r($user); exit; ?>
<div class="result-set">
    <table class="table table-bordered table-striped table-hover" id="data-table">
    
    <tr><td><b>Name</b></td><td><?php echo $user->name; ?></td></tr>
    <tr><td><b>Email</b></td><td><?php echo $user->email; ?></td></tr>
    <tr><td><b>Employee id</b></td><td><?php echo $user->emp_id; ?></td></tr>
    <tr><td><b>Designation</b></td>
    <td>
    <?php
    if(!empty($user->designation)) {
        $designation_name = Role::getDesignationdetails($user->designation);
        echo $designation_name[0]->emp_designation;
    }
    
    ?>

    </td>
    </tr>
    <tr><td><b>Department</b></td>
    <td>
    <?php echo $user->dept_name; ?>
    </td>

    </tr>


   

     <tr><td><b>Employee InterCom Number</b></td>
    <td>
    
    <?php
    if(!empty($user->emp_intercomeno)) {
        $emp_intercom = Role::getIntercomdetails($user->emp_intercomeno);
        echo $emp_intercom[0]->emp_intercomeno;
    }
    
    ?>
    </td>

    </tr>




  

    
    <tr><td><b>Manager Email Id</b></td><td><?php echo $user->group_email; ?></td></tr>
    <tr><td><b>Login Access</b></td><td><?php if ($user->login_access == 1) {echo "Yes";} else {echo "Blocked";}?></td></tr>

    <tr><td><b>Gender</b></td><td><?php if ($user->gender == 1) {echo "Male";} else {echo "Female";}?></td></tr>

    <tr><td><b>Birth Day</b></td><td><?php echo $user->birthday; ?></td></tr>
    <tr><td><b>Blood Group</b></td><td><?php echo $user->bloodgroup; ?></td></tr>
    <tr><td><b>Contact / Emergency Number</b></td><td><?php echo $user->mobilenumber; ?></td></tr>
    <tr><td><b>Manager Name</b></td><td><?php echo $user->managername; ?></td></tr>
    
    <?php 
    if(!empty($user->created_by) && $user->created_by!=0) { ?>
    <tr><td><b>Created By</b></td><td>
    
    
       
   <?php 

$userdata = UserController::getUser($user->created_by);
        
echo $userdata->name;

} ?>

</td></tr>
    <tr><td><b>Created At</b></td><td><?php echo $user->created_at; ?></td></tr>
    <tr><td><b>Updated At</b></td><td><?php echo $user->updated_at; ?></td></tr>
    </table>
</div>
@endsection