<!-- Name Form Input -->
<div class="form-group @if ($errors->has('holiday_type')) has-error @endif">
    {!! Form::label('holiday_type', 'Holiday Type') !!}
    <?php  //echo '<pre>'; print_r($holidays_edit[0]->holiday_type); ?>
    <select id="holiday_type" name="holiday_type" style='width:100%;height:40px;'>
    <option value=''>Choose Holiday Type</option>
    <?php foreach($holidays_types as $htype) { ?>
    <option value='<?php echo $htype->name ; ?>' <?php if(!empty($holidays_edit)) { echo ($holidays_edit[0]->holiday_type == $htype->name)?"selected='selected'":""; }  ?> ><?php echo $htype->name ; ?></option>
    <?php } ?>
    
    </select>

    @if ($errors->has('holiday_type')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>


<div class="form-group @if ($errors->has('holidaydate')) has-error @endif">
    {!! Form::label('holidaydate', 'Holiday Date') !!}
    <br />
    <input type="text" id="holidaydate" name="date" style='width:100%;height:40px;' value="<?php if(!empty($holidays_edit)) { echo (!empty($holidays_edit[0]->date))?date('m/d/Y',strtotime($holidays_edit[0]->date)):"";   } ?>" />

    <input type='hidden' name='id' value="<?php if(!empty($holidays_edit)) { echo (!empty($holidays_edit[0]->id))?$holidays_edit[0]->id:"";   } ?>" />


    @if ($errors->has('holidaydate')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('holiday_remarks')) has-error @endif">
    {!! Form::label('holiday_remarks', 'Holiday Remark') !!}
    <br />
    <textarea name='holiday_remarks' style='width:100%;'><?php if(!empty($holidays_edit)) { echo (!empty($holidays_edit[0]->holiday_remarks))?$holidays_edit[0]->holiday_remarks:"";   } ?></textarea>

    @if ($errors->has('holiday_remarks')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>

<!-- Jquery date picker Code Start -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>

 $('#holidaydate').datepicker({dateFormat: 'dd-mm-yy'});

  
  </script>
<!-- Jquery date picker Code End -->

<!-- Permissions -->
