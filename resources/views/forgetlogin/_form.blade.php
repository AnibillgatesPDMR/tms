<!-- Name Form Input -->
<div class="form-group @if ($errors->has('holiday_type')) has-error @endif">
    {!! Form::label('from_time', 'From Time') !!}
    <?php  //echo '<pre>'; print_r($holidays_edit[0]->holiday_type); ?>
   <input type="text" name="from_time" autocomplete='Off' id="from_time" required style='width:100%;height:40px;' value="<?php if(!empty($forget_login_edit)) { echo (!empty($forget_login_edit[0]->from_time))?$forget_login_edit[0]->from_time:"";   } ?>" />
   <span style='color:red;'>Valid Time format : HH:MM:SS</span>
  

    @if ($errors->has('holiday_type')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>


<div class="form-group @if ($errors->has('holiday_type')) has-error @endif">
    {!! Form::label('holiday_type', 'To Time') !!}
    <?php  //echo '<pre>'; print_r($holidays_edit[0]->holiday_type); ?>
   <input type="text" name="to_time" autocomplete='Off' required style='width:100%;height:40px;' value="<?php if(!empty($forget_login_edit)) { echo (!empty($forget_login_edit[0]->to_time))?$forget_login_edit[0]->to_time:"";   } ?>" />
   <span style='color:red;'>Valid Time format : HH:MM:SS </span>

    @if ($errors->has('holiday_type')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>


<div class="form-group @if ($errors->has('holidaydate')) has-error @endif">
    {!! Form::label('forget_date', 'Date') !!}
    <br />
    <input type="text" id="forget_date" autocomplete='Off' name="forget_date" required style='width:100%;height:40px;' value="<?php if(!empty($forget_login_edit)) { echo (!empty($forget_login_edit[0]->forget_date))?date('d-m-Y',strtotime($forget_login_edit[0]->forget_date)):"";   } ?>" />

    <input type='hidden' name='id' value="<?php if(!empty($forget_login_edit)) { echo (!empty($forget_login_edit[0]->id))?$forget_login_edit[0]->id:"";   } ?>" />


    @if ($errors->has('holidaydate')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('holiday_remarks')) has-error @endif">
    {!! Form::label('forget_reason', 'Remark') !!}
    <br />
    <textarea name='forget_reason' required style='width:100%;'><?php if(!empty($forget_login_edit)) { echo (!empty($forget_login_edit[0]->forget_reason))?$forget_login_edit[0]->forget_reason:"";   } ?></textarea>

    @if ($errors->has('forget_reason')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>

   <!-- Jquery date picker Code Start -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>

   $('#forget_date').datepicker({dateFormat: 'dd-mm-yy'});
  

  
  </script>
<!-- Jquery date picker Code End -->

<!-- Permissions -->
