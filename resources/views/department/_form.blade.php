<!-- Name Form Input -->
<div class="form-group @if ($errors->has('holiday_type')) has-error @endif">
    {!! Form::label('department', 'Department Name') !!}
    
   <input type="text" name="dept_name" id="dept_name" required style='width:100%;height:40px;' value="<?php if(!empty($dept_Details)) { echo (!empty($dept_Details->dept_name))?$dept_Details->dept_name:"";   } ?>" />
   
   <input type='hidden' name='id' value="<?php if(!empty($dept_Details)) { echo (!empty($dept_Details->dept_id))?$dept_Details->dept_id:"";   } ?>" />

    @if ($errors->has('emailid')) <p class="help-block">{{ $errors->first('emailid') }}</p> @endif
</div>






<!-- Permissions -->
