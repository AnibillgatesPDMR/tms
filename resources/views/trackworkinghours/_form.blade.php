<!-- Name Form Input -->
<div class="form-group @if ($errors->has('holiday_type')) has-error @endif">
    {!! Form::label('emailid', 'Email Id') !!}
    <?php  // echo '<pre>'; print_r($mgr_Emailid->group_emailids); exit('Testing'); ?>
   <input type="email" name="group_emails" id="group_emails" required style='width:100%;height:40px;' value="<?php if(!empty($mgr_Emailid)) { echo (!empty($mgr_Emailid->group_emailids))?$mgr_Emailid->group_emailids:"";   } ?>" />
   <span style='color:red;'>Valid email id format : xxx@xxx.xxx</span>
   <input type='hidden' name='id' value="<?php if(!empty($mgr_Emailid)) { echo (!empty($mgr_Emailid->gemail_id))?$mgr_Emailid->gemail_id:"";   } ?>" />

    @if ($errors->has('emailid')) <p class="help-block">{{ $errors->first('emailid') }}</p> @endif
</div>






<!-- Permissions -->
