<!-- Name Form Input -->




<div class="form-group @if ($errors->has('holiday_remarks')) has-error @endif">
    {!! Form::label('holiday_remarks', 'Ticket Id') !!}
    <br />
    <input type='text' readonly name='ticket_id' style='width:100%;' value='<?php echo "2020".rand(10,1); ?>' />

    @if ($errors->has('holiday_remarks')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>


<div class="form-group @if ($errors->has('holidaydate')) has-error @endif">
    {!! Form::label('holidaydate', 'Request Type') !!}
    <br />
    <select name="request_type" class="form-control" required='required' id="holidayyear">
    <option value="">--Select--</option>
    <option value='TS'>Time Sheet</option>
    <option value='H'>Holidays</option>
    <option value='Tech'>Technical/System Support</option>
    <!-- <option value='SI'>System Issue</option> -->
    <option value='PI'>Personal Information</option>
                                      
    </select>


    @if ($errors->has('holidaydate')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('holiday_remarks')) has-error @endif">
    {!! Form::label('holiday_remarks', 'Remarks') !!}
    <br />
    <textarea name='ticket_remarks' style='width:100%;'></textarea>

    @if ($errors->has('ticket_remarks')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('holiday_remarks')) has-error @endif">
    {!! Form::label('holiday_remarks', 'CC Emails') !!}
    <br />
    <input type='text' name='cc_email' style='width:100%;' />

    @if ($errors->has('holiday_remarks')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('holiday_remarks')) has-error @endif">
    {!! Form::label('Attachment', 'Attachment') !!}
    <br />
    <input type='file'  name='file_attached' style='width:100%;' />

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
