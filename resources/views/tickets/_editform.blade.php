<!-- Name Form Input -->

<?php // echo '<pre>'; print_r($ticket_Details[0]->ticket_id); ?>
<style>
label {

  margin-left:20px !important;

}
</style>

<div class="form-group @if ($errors->has('holiday_remarks')) has-error @endif">
    {!! Form::label('holiday_remarks', 'Ticket Id : ') !!}
    <label><?php if(!empty($ticket_Details)) { echo $ticket_Details[0]->ticket_id; } ?></label>
    

    @if ($errors->has('holiday_remarks')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>


<div class="form-group @if ($errors->has('holidaydate')) has-error @endif">
    {!! Form::label('holidaydate', 'Request Type : ') !!}
    
    <label>
    
    <?php if(!empty($ticket_Details)) { if($ticket_Details[0]->request_type=='TS') { echo 'Time Sheet'; } elseif($ticket_Details[0]->request_type=='H') { echo "Holidays"; }elseif($ticket_Details[0]->request_type=='Tech') { echo "Technical Suport"; } elseif($ticket_Details[0]->request_type=='SI') { echo "Server Issue"; } elseif($ticket_Details[0]->request_type=='PI') { echo "Personal Information"; } } ?>
    
    </label>

    @if ($errors->has('holidaydate')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('holiday_remarks')) has-error @endif">
    {!! Form::label('holiday_remarks', 'Remarks : ') !!}
  
    
    <label><?php if(!empty($ticket_Details)) { echo $ticket_Details[0]->ticket_remarks; }  ?></label>

    @if ($errors->has('ticket_remarks')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('holiday_remarks')) has-error @endif">
    {!! Form::label('holiday_remarks', 'CC Emails : ') !!}
    
    
    <label><?php if(!empty($ticket_Details)) { echo $ticket_Details[0]->cc_email;  } ?></label>
    @if ($errors->has('holiday_remarks')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('holiday_remarks')) has-error @endif">
    {!! Form::label('Attachment', 'Attachment : ') !!}
    <?php if(!empty($ticket_Details)) { if($ticket_Details[0]->file_attached) { ?>
    <label><a href='<?php  if(!empty($ticket_Details)) { echo $ticket_Details[0]->file_attached; } ?>'><i class="fa fa-file-archive-o" aria-hidden="true"></i></a></label>
    <?php } } ?>
    @if ($errors->has('holiday_remarks')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>



<div class="form-group @if ($errors->has('holiday_remarks')) has-error @endif">
    {!! Form::label('holiday_remarks', 'Response Comment') !!}
    <br />
    <textarea name='response_comment' style='width:100%;height:150px;'><?php  if(!empty($ticket_Details)) { echo $ticket_Details[0]->response_comment; } ?></textarea>
    <input type='hidden' name='id' value='<?php echo  $ticket_Details[0]->id; ?>' />
    @if ($errors->has('ticket_remarks')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('holiday_remarks')) has-error @endif">
    {!! Form::label('holiday_remarks', 'Response Status') !!}
    <br />
    <select name="ticket_status" class="form-control" required='required' id="holidayyear">
    <option value="">--Select--</option>
    <option value='In Process' <?php if(!empty($ticket_Details)) { if($ticket_Details[0]->ticket_status=='In Process') { echo 'selected'; }  } ?>>In Process</option>
    <option value='Completed' <?php if(!empty($ticket_Details)) { if($ticket_Details[0]->ticket_status=='Completed') { echo 'selected'; }  } ?>>Completed</option>
    <option value='Hold' <?php if(!empty($ticket_Details)) { if($ticket_Details[0]->ticket_status=='Hold') { echo 'selected'; }  } ?>>Hold</option>
    <option value='Waiting for reply' <?php if(!empty($ticket_Details)) { if($ticket_Details[0]->ticket_status=='Waiting for reply') { echo 'selected'; }  } ?>>Waiting for reply</option>
    
                                      
    </select>
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
