@extends('layouts.app')

@section('title', 'Users')

@section('content')
<?php 
use \App\Http\Controllers\UserController;
use App\Role;
 ?>
<div class="row">
    <div class="col-md-5">
        <h3 class="modal-title">User Shift Time</h3><br />
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

    <tr><td><b>Department</b></td><td>
    {{$user->dept_name}}
    
    </td></tr>

   <tr><td><b>Time</b></td>
   <td>
    <div class="form-group @if ($errors->has('group_email')) has-error @endif">
    {!! Form::open(['method' => 'post', 'url' => 'users/insertshit']) !!}
    <select name="shift_time" class="form-control" required="required">
        <option value="">Select Shift Time</option>
        <?php foreach($shifttime as $shift) { ?>
        <option value="<?php echo $shift->id; ?>"><?php echo $shift->shift_start." -- ".$shift->shift_end; ?></option>
        <?php } ?>

    </select>
    </div>
</td>
   </tr>

<tr><td><b>Start Date</b></td>
   <td>
   <div class="form-group @if ($errors->has('shift_end_date')) has-error @endif">
                        
                        <div class="input-group col-md-12 date">
                            <input type="text" name="shift_start_date" class="form-control pull-right" id="duedate" required="required">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                        @if ($errors->has('shift_start_date')) <p class="help-block">{{ $errors->first('shift_start_date') }}</p> @endif
                    </div>
</td>
   </tr>

<input type="hidden" id="shift_emp_id" name="shift_emp_id" value="{{ collect(request()->segments())->last() }}" />

   <tr><td><b>End Date</b></td>
   <td>
   <div class="form-group @if ($errors->has('shift_end_date')) has-error @endif">
                        
                        <div class="input-group col-md-12 date">
                            <input type="text" name="shift_end_date" class="form-control pull-right" id="duedate" required="required">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                        @if ($errors->has('shift_end_date')) <p class="help-block">{{ $errors->first('shift_end_date') }}</p> @endif
                    </div>
</td>
   </tr>
            <tr align="center">
            <td colspan="2">
                <div class="row">
                        <div class="col-lg-12">
                                                      
                                <!-- Submit Form Button -->
                                {!! Form::submit('Add Shift', ['class' => 'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
            </td>
            </tr>

    </table>
</div>
@endsection