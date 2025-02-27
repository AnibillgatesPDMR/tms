<style>

</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>

<div class="form-group" style='margin-bottom:125px;' >
    <div class="circle">
        <!-- User Profile Image -->
        <img class="profile-pic" src="<?php if ($profile) { echo $profile; } else { ?>{{ asset('images/profile.png') }} <?php } ?>">
    </div>

    <div class="p-image" >
        <i class="fa fa-camera upload-button"></i>
        <input class="file-upload" type="file" name="profile" accept="image/*"/>
    </div>
</div>
<p class="text-center">Image size must be 225X225</p>
<!-- Name Form Input -->
<div class="form-group @if ($errors->has('name')) has-error @endif">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name', 'required' => 'required']) !!}
    @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>

<!-- email Form Input -->
<div class="form-group @if ($errors->has('email')) has-error @endif">
    {!! Form::label('email', 'Email') !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required']) !!}
    @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
</div>





<div class="form-group @if ($errors->has('emp_id')) has-error @endif">
    {!! Form::label('emp_id', 'Employee id') !!}
    {!! Form::text('emp_id', null, ['class' => 'form-control', 'placeholder' => 'Employee id', 'required' => 'required']) !!}
    @if ($errors->has('emp_id')) <p class="help-block">{{ $errors->first('emp_id') }}</p> @endif
</div>


<!-- password Form Input -->
<div class="form-group @if ($errors->has('password')) has-error @endif">
    {!! Form::label('password', 'Password') !!}
    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required' => 'required']) !!}
    @if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
</div>


<div class="form-group @if ($errors->has('Birth Day')) has-error @endif">
    {!! Form::label('birthday', 'Birth Day') !!}
    {!! Form::text('birthday', null, ['class' => 'form-control', 'placeholder' => 'BirthDay','id' =>'datepicker']) !!}
    @if ($errors->has('birthday')) <p class="help-block">{{ $errors->first('birthday') }}</p> @endif

    
</div>



<div class="form-group @if ($errors->has('bloodgroup')) has-error @endif">
    {!! Form::label('bloodgroup', 'Blood Group') !!}
    {!! Form::text('bloodgroup', null, ['class' => 'form-control', 'placeholder' => 'Blood Group',]) !!}
    @if ($errors->has('bloodgroup')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('mobilenumber')) has-error @endif">
    {!! Form::label('mobilenumber', 'Contact Number / Emergency Number') !!}
    {!! Form::text('mobilenumber', null, ['class' => 'form-control', 'placeholder' => 'Contact Number / Emergency Number',]) !!}
    @if ($errors->has('mobilenumber')) <p class="help-block">{{ $errors->first('mobilenumber') }}</p> @endif
</div>




<div class="form-group @if ($errors->has('designation')) has-error @endif">
    {!! Form::label('designation', 'Designation') !!} <br />
   <!--  {!! Form::text('designation', null, ['class' => 'form-control', 'placeholder' => 'Designation', 'required' => 'required']) !!} -->

    <select name="designation" class="form-control" required='required'>
        <option value="">--Select--</option>
        <?php foreach ($emp_designation as $emp_designation) { ?>
        <option value="<?php echo $emp_designation->id; ?>"  <?php  if($designation_Id!='') {  if ($emp_designation->id == $designation_Id->designation) { echo "selected"; } } ?>><?php echo $emp_designation->emp_designation; ?></option>


        <?php } ?>
        
    </select>



    @if ($errors->has('designation')) <p class="help-block">{{ $errors->first('designation') }}</p> @endif
</div>
<?php $dept = explode(",", $val['department']); ?>
<div class="form-group @if ($errors->has('department')) has-error @endif">
    {!! Form::label('department', 'Department') !!}<br>

    
  <!--   <label class="checkbox-inline"><input type="checkbox" name="department[]" value="1" <?php if (in_array("1", $dept)){ echo "checked"; } ?>>Book</label>
    <label class="checkbox-inline"><input type="checkbox" name="department[]" value="2" <?php if (in_array("2", $dept)){ echo "checked"; } ?>>Journal</label>
    <label class="checkbox-inline"><input type="checkbox" name="department[]" value="3" <?php if (in_array("3", $dept)){ echo "checked"; } ?>>Bloomsbury</label>
    -->
   <select name="department" class="form-control" required='required'>
        <option value="">--Select--</option>
        <?php foreach ($department as $dept) { ?>
        <option value="<?php echo $dept->dept_id; ?>" <?php if($department_Id!='') {  if ($dept->dept_id == $department_Id->department) { echo "selected"; } } ?>><?php echo $dept->dept_name ?></option>
        <?php } ?>
    </select>


    

    @if ($errors->has('department')) <p class="help-block">{{ $errors->first('department') }}</p> @endif
</div>





<div class="form-group @if ($errors->has('department')) has-error @endif">
    {!! Form::label('emp_intercomeno', 'Employee Intercome Number') !!}<br>

    
 
   <select name="emp_intercomeno" class="form-control">
        <option value="">--Select--</option>
        <?php foreach ($emp_intercom as $emp_inter) { ?>
        <option value="<?php echo $emp_inter->id; ?>" <?php  if($emp_intercom_Id!='') {  if ($emp_inter->id == $emp_intercom_Id->emp_intercomeno) { echo "selected"; } } ?> ><?php echo $emp_inter->emp_intercomeno; ?></option>
        <?php } ?>
    </select>

  

    

    @if ($errors->has('emp_floor')) <p class="help-block">{{ $errors->first('emp_floor') }}</p> @endif
</div>



<?php  
$job = explode(",", $val['job']); 
$jobs_new = (!empty($jobs))?explode(",",$jobs->job):array(); 
?>


<div class="form-group @if ($errors->has('group_email')) has-error @endif">
    {!! Form::label('group_email', 'Managers Email Id') !!}
    <!-- @if ($errors->has('group_email')) <p class="help-block">{{ $errors->first('group_email') }}</p> @endif
   {!! Form::text('group_email', null, ['class' => 'form-control', 'placeholder' => 'Manager Email Id', 'required' => 'required']) !!}

   -->



   <select name="group_email" class="form-control">
        <option value="">--Select--</option>
        <?php foreach ($managers as $managers_value) { ?>
        <option value="<?php echo $managers_value->email; ?>"  <?php   if($managers_Id!='') {  if ($managers_value->email == $managers_Id->email) { echo "selected"; } } ?>  ><?php echo $managers_value->email; ?></option>
        <?php } ?>
    </select>




 </div>
 
 
 <div class="form-group @if ($errors->has('Manager Name')) has-error @endif">
    {!! Form::label('managername', 'Managers Name') !!}
     @if ($errors->has('managername')) <p class="help-block">{{ $errors->first('managername') }}</p> @endif
   {!! Form::text('managername', null, ['class' => 'form-control', 'placeholder' => 'Manager Name']) !!}
 </div>


<!-- <div class="form-row">
                        <div class="form-group col-md-12 @if ($errors->has('file')) has-error @endif">
                            {!! Form::label('file', 'Files Upload') !!}
                            <input type="file" id="file" class="form-control" name="file" required="required">
                            @if ($errors->has('file')) <p class="help-block">{{ $errors->first('file') }}</p> @endif
                        </div>
                    </div> -->









<div class="form-group @if ($errors->has('login_access')) has-error @endif">
    {!! Form::label('login_access', 'Login Access') !!}<br>
    {{ Form::radio('login_access', '1') }} {!! Form::label('yes', 'Yes') !!}
    {{ Form::radio('login_access', '0') }} {!! Form::label('blocked', 'Blocked') !!}<br>
    
    @if ($errors->has('login_access')) <p class="help-block">{{ $errors->first('login_access') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('gender')) has-error @endif">
    {!! Form::label('gender', 'Gender') !!} <br/>
   <!--  {{ Form::radio('gender', '1') }} {!! Form::label('male', 'Male') !!}
    {{ Form::radio('gender', '0') }} {!! Form::label('female', 'Female') !!}<br> -->
    
    <select name='gender' id='gender' class="form-control" required='required'>
    <option value=''>Choose Gender</option>
    <option value='1' <?php if(!empty($user)){ echo ($user['gender']=='1')?"selected='selected'":""; } ?>>Male</option>
    <option value='0' <?php if(!empty($user)){ echo ($user['gender']=='0')?"selected":""; } ?>>Female</option>
    </select>

    @if ($errors->has('gender')) <p class="help-block">{{ $errors->first('gender') }}</p> @endif
</div>


<!-- Roles Form Input -->

<?php // echo '<pre>'; print_r($roles); ?>
<div class="form-group @if ($errors->has('roles')) has-error @endif">
    {!! Form::label('roles', 'Roles') !!}
    {!! Form::select('roles', $roles, isset($user) ? $user->roles->pluck('id')->toArray() : null, ['class' => 'form-control', 'required' => 'required']) !!}
    
    
    
    
    
    @if ($errors->has('roles')) <p class="help-block">{{ $errors->first('roles') }}</p> @endif
</div>



<!-- Permissions -->
@if(isset($user))
    @include('shared._permissions', ['closed' => 'true', 'model' => $user ])
@endif