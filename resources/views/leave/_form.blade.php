<!-- Name Form Input -->

<div class="form-group @if ($errors->has('holiday_type')) has-error @endif">
    {!! Form::label('holiday_type', 'Leave Type') !!} <span style='color:red;'>*</span>
    <?php  //echo '<pre>'; print_r($holidays_edit[0]->holiday_type); ?>
    <select id="leave_type" name="leave_type" style='width:100%;height:40px;'>
    <option value=''>Choose Leave Type</option>
    <?php foreach($leave_types as $htype) { ?>
    <option value='<?php echo $htype->name ; ?>' <?php if(!empty($leave_edit)) { echo ($leave_edit->leave_type == $htype->name)?"selected='selected'":""; }  ?> ><?php echo $htype->name ; ?></option>
    <?php } ?>
    
    </select>

    @if ($errors->has('leave_type')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('holiday_type')) has-error @endif">
   
   <div id='information-main'>
      <div id='information-sub'>
      
          <p class='request_title'>Request for Half Day’s Leave</p>
          <p><b><i>To request a morning off</i></b></p>
          <ul>
          <li>Select the <b>From Date</b> & select <b>‘Morning’</b>.</li> 
          <li>Select the same <b>To Date</b> & select <b>‘Morning’</b></li>
          </ul>
          <p><b><i>To request an afternoon off</i></b></p>
          </ul>
          <ul>
          <li>Select the <b>From Date</b> & select <b>‘Afternoon’</b>.</li>
          <li>Select the same <b>To Date</b> & select <b>‘Afternoon’</b>.</li>
          </ul>  
          <p class='request_title'>Request for One Day’s Leave</p>
          <ul>
          <li>Select the <b>From Date</b> & select <b>‘Morning’</b></li>
          <li>Select the same <b>To Date</b> & select <b>‘Afternoon’</b></li>
          </ul>

          <p class='request_title'>Request for More than One Day’s Leave</p>
          <ul>
          <li>Select the <b>From Date</b> & select <b>‘Morning’</b> </li>
          <li>Select the <b>To Date (last day of leave) </b>& select <b>‘Afternoon’</b></li>
          </ul>
          </div>     
   </div>
    
</div>





<div class="form-group @if ($errors->has('holidaydate')) has-error @endif">
    {!! Form::label('holidaydate', 'From Date (DD-MM-YYYY)') !!}<span style='color:red;'>*</span>
    <br />
    <input type="text" autocomplete="off" id="session1date" name="session1date"   style='width:50%;height:40px;'  value="<?php if(!empty($leave_edit)) { echo (!empty($leave_edit->from_date))?date('d-m-Y',strtotime($leave_edit->from_date)):"";   } ?>" />

    <input type='hidden' name='id' value="<?php if(!empty($leave_edit)) { echo (!empty($leave_edit->leave_id))?$leave_edit->leave_id:"";   } ?>" />


    @if ($errors->has('from_date ')) <p class="help-block">{{ $errors->first('name') }}</p> @endif

<select id="session1" onchange='getLeave();' style='height:40px;'>
<option value="">Please Select</option>
  <option value="fromsession1">Morning</option>
  <option value="fromsession1">Afternoon</option>
</select> 


</div>

<div class="form-group @if ($errors->has('holidaydate')) has-error @endif">
    {!! Form::label('holidaydate', 'To Date (DD-MM-YYYY)') !!}<span style='color:red;'>*</span>
    <br />
    <input type="text" autocomplete="off" id="session2date" name="session2date"   style='width:50%;height:40px;' value="<?php if(!empty($leave_edit)) { echo (!empty($leave_edit->to_date))?date('d-m-Y',strtotime($leave_edit->to_date)):"";   } ?>" />

    @if ($errors->has('todate ')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
    <select id="session2" onchange='getLeave();' style='height:40px;'>
    <option value="">Please Select</option>
  <option value="fromsession2">Morning</option>
  <option value="fromsession2">Afternoon</option>
</select>
    
</div>

<div class="form-group @if ($errors->has('holidaydate')) has-error @endif" id='balance_leave_area' style='color:red;font-weight:bold;'>
<span>Days</span>: <span id="value">0</span>
</div>

<div style="display:none;" id="display_file_upload" class="form-group @if ($errors->has('file_upload')) has-error @endif">
    {!! Form::label('file_upload', 'File upload') !!}<span style='color:red;'>* (The file format should be <b>.pdf or.jpg or .png</b> )</span>
    <br />

    <input type="file" autocomplete="off" id="file_upload" name="file_upload"   style='width:50%;height:40px;' value="" />
    <input type="hidden" autocomplete="off" id="previous_file_upload" name="previous_file_upload"   style='width:50%;height:40px;' value="<?php if(!empty($leave_edit)) { echo (!empty($leave_edit->leave_image))?$leave_edit->leave_image:"";   } ?>" />
</div>


<div class="form-group @if ($errors->has('holiday_remarks')) has-error @endif">
    {!! Form::label('remarks', 'Comment') !!}<span style='color:red;'>*</span>
    <br />
    <textarea name='remarks' id="remarks" style='width:100%;'><?php if(!empty($leave_edit)) { echo (!empty($leave_edit->remarks))?$leave_edit->remarks:"";   } ?></textarea>

    @if ($errors->has('remarks')) <p class="help-block">{{ $errors->first('name') }}</p> @endif

    <input type='hidden' id='no_of_days' />
</div>


<!-- Jquery date picker Code Start -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://momentjs.com/downloads/moment.js"></script>
  <script>



    $('#session1date').datepicker({dateFormat: 'dd-mm-yy'});

    $('#session2date').datepicker({dateFormat: 'dd-mm-yy'});
  
    $(document).ready(function(){
        $("#leave_type").change(function () {
          if(this.value=="Paid sick leave")
          {
            $("#display_file_upload").show();
          }
          else
          {
            $("#display_file_upload").hide();
          }

        });
    });

  function form_validation() {


      var val = $("#file_upload").val();
   // var imgbytes = document.getElementById('file_upload').size;
        //   var imgkbytes = Math.round(parseInt(imgbytes)/1024);
      var file_size='';
      if(val != "")
      {
        var file_size = $('#file_upload')[0].files[0].size;
      }


      
      if($("#leave_type").val()=='') {
        swal("Required", "Leave Type Is Required", "error");
        
      } 
      else if($("#session1date").val()=='') {
        swal("Required", "From Date Is Required", "error");
        
      }  else if($("#session2date").val()=='') {
        swal("Required", "To Date Is Required", "error");
      } else if($("#session1").val()=='') {
        swal("Required", "Session Type is required", "error");
      } 
      else if($("#file_upload").val()=='' && $("#leave_type").val()=='Paid sick leave') {
        swal("Required", "File upload is required", "error");
      }
      else if (!val.match(/(?:jpg|JPG|png|PNG|jpeg|JPEG|pdf|PDF)$/) && $("#leave_type").val()=='Paid sick leave') {

        swal("Required", "The file format should be PDF or JPG or png", "error");
      }    

      else if (file_size > "2097152" && $("#leave_type").val()=='Paid sick leave') {
        swal("Required", "File size is greater than 2MB", "error");
      }      
      else if($("#remarks").val()=='') {
        swal("Required", "Remarks Is Required", "error");
      }
      else if($("#session2").val()=='') {
        swal("Required", "From Session Is Required", "error");
      } else {

        

      var total_leave =$("#no_of_days").val();

  
      if(total_leave!=0) {
      // if($("#leave_type").val()=="Paid sick leave")
      // {
      // var formValues = {leavetype:$("#leave_type").val(),fromdate:$("#session1date").val(),todate:$("#session2date").val(),remarks:$("#remarks").val(),total_leave:total_leave,file_upload:$("#file_upload")[0].files[0]}  
      // } else {
      //   var formValues = {leavetype:$("#leave_type").val(),fromdate:$("#session1date").val(),todate:$("#session2date").val(),remarks:$("#remarks").val(),total_leave:total_leave}  
      // }   
      
      var _token = $('input[name="_token"]').val();
     var leave_data = new FormData();
    leave_data.append('leavetype',$("#leave_type").val());
    leave_data.append('fromdate',$("#session1date").val());
    leave_data.append('todate',$("#session2date").val());
    leave_data.append('remarks',$("#remarks").val());
    leave_data.append('total_leave',total_leave);
    leave_data.append('_token',_token);
    leave_data.append('previous_file_upload',$("#previous_file_upload").val())
    if($("#leave_type").val()=="Paid sick leave")
    {
      leave_data.append('file_upload',$("#file_upload")[0].files[0]);
    }

       $.ajax({
        type: "POST",
        url: "{{ asset('leave/insertleave') }}",
        data : leave_data,
        cache: false,
        processData: false,
        contentType: false,
        success: function(data){

          if(data=='1') {

                    swal({title: "Message", text: "Leave Applied Successfully", type: "success"},
                function(){ 
                    location.reload();
                }
                );



            } else {

            

                swal({title: "Message", text: data, type: "success"},
                function(){ 
                  //  location.reload();
                }
                );
            }

        }
        });








      }
      else {

      swal('Please check from and to date');

      }


      } 
    

  }



  function leave_calculation(){



  //  alert('Testing');


    if($("#leave_type").val()=='') {
        swal("Required", "Leave Type Is Required", "error");
        
      } 
      else if($("#fromdate").val()=='') {
        swal("Required", "From Date Is Required", "error");
        
      }  else if($("#todate").val()=='') {
        swal("Required", "To Date Is Required", "error");
      }  else if($("#from_session").val()=='') {
        swal("Required", "From Session Is Required", "error");
      }else {

        

        
       
          var from_dateString = $("#fromdate").val(); // "08-03-2021";
          from_dateString =from_dateString.substr(3, 2)+"/"+from_dateString.substr(0, 2)+"/"+from_dateString.substr(6, 4);

          from_dateString = new Date(from_dateString);

          var to_dateString = $("#todate").val() // "08-03-2021";
          to_dateString =to_dateString.substr(3, 2)+"/"+to_dateString.substr(0, 2)+"/"+to_dateString.substr(6, 4);

          to_dateString = new Date(to_dateString);

          var from_session = $("#from_session").val();
          var to_session = $("#to_session").val();
          var reduce_half_day = 0;


         let differentTime = to_dateString.getTime() -  from_dateString.getTime();
         let msInDay = 1000 * 3600 * 24;

         var no_of_days = differentTime/msInDay;

         if(no_of_days==0){
          no_of_days = 1;
        } else  {

          no_of_days = no_of_days +1;
        }


        if(from_session == 'S1' && to_session =='S1' && no_of_days ==1) {

          reduce_half_day = 0.5;


        } else if(from_session == 'S1' && to_session =='S2' && no_of_days ==1) {

            reduce_half_day = 0;

        } else if(from_session == 'S1' && to_session =='S1' && no_of_days > 1) {

            reduce_half_day = 0.5;

        } else if(from_session == 'S2' && to_session =='S2' && no_of_days > 1) {

        reduce_half_day = 0.5;

        } 
        
        
            


        /*  if(from_session == to_session && no_of_days ==1) {

              alert('1');

              reduce_half_day = 0.5;
          } 
         else if(from_session != to_session && no_of_days ==1) {

              alert('1');

              reduce_half_day = 0;
          }else if(from_session == to_session && no_of_days > 1) {
           
             alert('2');

             reduce_half_day = 0.5;

         }            
          
          else if(from_session != to_session && no_of_days > 1) {
            
             alert('3');
             if(from_session =="Morning") {
              reduce_half_day = 0.5;
             } else if(from_session != to_session && no_of_days > 1) {
              reduce_half_day = 0;
             }else if(from_session == to_session && no_of_days > 1) {
              reduce_half_day = 0.5;
             }
            
            

          }  */ 
       
          alert('No of Days: '+no_of_days +'__________________'+ reduce_half_day);
      
      // alert('No of Days: '+no_of_days + reduce_half_day);

      document.getElementById('balance_leave_area').innerHTML = "Apply Leave Days : "+(no_of_days - reduce_half_day);


        }




  }




  


  </script>

<script type="text/javascript">
	function getLeave() {


   

    
   

    
		Date.prototype.addDays = function(days) {
		    var date = new Date(this.valueOf());
		    date.setDate(date.getDate() + days);
		    return date;
		}
		var getDates = function(startDate, stopDate) {
		    var dateArray = new Array();
		    var currentDate = startDate;
		    while (currentDate <= stopDate) {
		    	var d = new Date (currentDate).toString().split(' ')[0]
		        if (!leaveDays.includes(d)) dateArray.push(new Date (currentDate));
		        currentDate = currentDate.addDays(1);
		    }
		    return dateArray;
		},
		leaveDays = ['Sat','Sun'],T_D = 0,se = {
			'Morning':1,'Afternoon':0.5
		},
    s1A = document.querySelector('[name="session1date"]').value.split('-').reverse(),
    s2A = document.querySelector('[name="session2date"]').value.split('-').reverse(),
	  s1D = new Date(s1A.join('-')),
	  s2D = new Date(s2A.join('-'))
    
    if (s1D.getTime()!=s2D.getTime() && s1D.getTime() > s2D.getTime()) return swal('Please check from and to date')

	  s1S = document.getElementById("session1"),
		s1S = s1S.options[s1S.selectedIndex].text,
		s2S = document.getElementById("session2"),
		s2S = s2S.options[s2S.selectedIndex].text,
	    AllDays = getDates(s1D,s2D),ni = Array.from(new Set([s1S,s2S])).length,
	    session = (ni==1) ? 0.5:1,
	    d = AllDays.length
	    if (se[s1S]==0.5) d = d-0.5
	    if (se[s2S]!=0.5) d = d-0.5
	    document.getElementById('value').innerHTML = d+' days';
      document.getElementById('no_of_days').value = d;

     /* Bank holidays count part */

     var formValues = {fromdate:$("#session1date").val(),todate:$("#session2date").val()}     
      

      // alert($("#session1date").val()+$("#session2date").val());
  
  
  
  
          $.ajax({
          type: "GET",
          url: "{{ asset('leave/getbankholidays') }}",
          data: formValues,
          cache: false,
          processData: true,
          success: function(data){
             
           // alert('Count Valud'+data);

            if(data!=0){

              var final_value = document.getElementById('no_of_days').value - data;
              document.getElementById('no_of_days').value = final_value;
              document.getElementById('value').innerHTML = final_value+' days';
            }
  
          }
          });
  
  
  
  
      /* Bank holidays count end part */


	}


  $('#session1date').change(function(){
   
    $('#session1').val('');
   // $('#session2').val('');
});

$('#session2date').change(function(){
   
//   $('#session1').val('');
   $('#session2').val('');
});


</script>




<!-- Jquery date picker Code End -->

<!-- Permissions -->
