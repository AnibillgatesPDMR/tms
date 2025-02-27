<script src="https://code.jquery.com/jquery-1.12.4.js"></script> 
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        searching: false,
        buttons: [
           
        ]
  
        
    } );


    



});
// Code that uses other library's $ can follow here.

/*

 'copyHtml5',
            'excelHtml5',            
            'pdfHtml5'
*/
</script>

<style>

.boxeven {

  /*  width:200px !important; */
    
}
</style>


@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<?php 
use \App\Http\Controllers\UserController;
use App\Role;
use Illuminate\Support\Str;

 // echo '<pre>'; print_r(Auth::user());
?>




    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
        {!! Form::open(['method' => 'post', 'url' => 'mgremailid/insertmgremailid']) !!}

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="roleModalLabel">Add Manager Email Id</h4>
                </div>
                <div class="modal-body">
                    @include('manageremail._form')
                    <input type="hidden" name="created_by" value="{{Auth::user()->id}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                    <!-- Submit Form Button -->
                    {!! Form::submit('Create', ['class' => 'btn btn-success userform']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <h3 class="modal-title">{{ Str::plural('Attentance Details', count($tracking_hours_list)) }} <span style='color:red;'></h3>
        </div>
    </div>

    <div class="col-md-12" style="margin-top: 10px; margin-bottom: 20px; padding: 0;">
        <form method="post" action="{{ asset('attentance') }}">
        <div class="form-group col-md-5 @if ($errors->has('user_list')) has-error @endif" style="padding-left: 0;">
                {!! Form::label('user', 'Emp Name') !!}
                
                <?php if(Auth::user()->designation==1) { ?>
                <select name="emp_name" class="form-control" required='required' id="emp_name" >
                    <option value="">--Select--</option>
                    @foreach($user_list as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>

                <?php } else if(Auth::user()->role==17) { ?>    
                    <select name="emp_name" class="form-control" required='required' id="emp_name">
                    <option value="">--Select--</option>
                    @foreach($user_listbymanager as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
                <?php } else { ?>    
                    <select name="emp_name" class="form-control" required='required' id="emp_name">
                    <option value="">--Select--</option>
                    <option value='<?php echo Auth::user()->id; ?>'><?php echo Auth::user()->name; ?></option>
                </select>
                <?php }?>   

                
                @if ($errors->has('user_list')) <p class="help-block">{{ $errors->first('user_list') }}</p> @endif
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('from_date', 'From Date') !!}
                <input type="text" id="from_date" class="form-control" name="from_date" autocomplete='off' />
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('to_date', 'To Date') !!}
                <input type="text" id="to_date" class="form-control" name="to_date" autocomplete='off' />
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
            <div class="form-group col-md-1" style="margin-top: 24px;">
                {!! Form::submit('Submit', ['class' => 'btn btn-success pull-right']) !!}
            </div>
        </form>
    </div>

    <hr />

    <div style="float:left;margin-bottom:30px;">
    <labe style="font-weight:bold;">Info : &nbsp; &nbsp;&nbsp;
    <i class="fa fa-square" aria-hidden="true" style='color:green;'></i>&nbsp;&nbsp;<span style="color:green;">Weekend</span>&nbsp;&nbsp; &nbsp;
    <i class="fa fa-square" aria-hidden="true" style='color:blue;'></i>&nbsp;&nbsp; <span style='color:blue;'>Login Not Captured</span>&nbsp;&nbsp; &nbsp;
    <i class="fa fa-square" aria-hidden="true" style='color:purple;'></i>&nbsp;&nbsp; &nbsp;<span style='color:purple;'>Forget Login Applied</span>
    </div>
    <br />
    <div class="result-set">
    
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr style='font-size:12px !important;'>
                <th>S.No</th>
                <th>Emp Id
                <th>Emp Name</th>
                <th>Work Type</th>
                <th>Remarks</th>
                <th>Date</th>
                <th>Day</th>
                
                <th>In Time</th>
                <th>Out Time </th> 
                <th>Login hours</th>
                <th>Break Time</th>
                <th>Working Hours<br />
                
                </th>               
               
            </tr>
        </thead>
        <tbody>


        
        <?php 








/* echo '<pre>'; print_r($tracking_hours_list);

echo '<pre>'; print_r($tracking_hours_list[0]->id);
echo '<br>'; */



$sum_hours = 0;
$diff_in_hrs1 =0;
$row_color ='';

$i = 0;
$k = 1;

$time_value = array();

//echo '<pre>'; print_r($tracking_hours_list);exit('Testing');

$date = '';
$end_date = '';
$week_end_class = '';
$weekday = '';


if(!empty($serach_from_date)) {

    //echo "From Date".$serach_from_date;

    $date = date('Y-m-d',strtotime($serach_from_date));

} else {
    $date = date('Y-m-').'01';

}

if(!empty($serach_end_date)) {

   // echo "End Date".$serach_end_date;

    $end_date = date('Y-m-d',strtotime($serach_end_date));

} else {
    $end_date = date('Y-m-d'); //'2020-08-31';
}






$day_list = array();

while (strtotime($date) <= strtotime($end_date)) {
//    echo "$date\n";
    $day_list[] = $date;
    //use +1 month to loop through months between start and end dates
    $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
}


for($j=1;$j<=count($day_list);$j++) {  
    
    $timestamp = strtotime($day_list[$i]);
    $weekday = date("l", $timestamp );
    if ($weekday =="Saturday" OR $weekday =="Sunday") { $week_end_class ='color:green'; } 
    else { $week_end_class ='';}


    
    $last_time11='';
    $last_Logout11 = Role::get_firstlogintimebyid_new($day_list[$i],$tracking_hours_list[0]->user_id);

    

    if(!empty($last_Logout11)){
      

       
    foreach($last_Logout11 as $key =>$value) {

        
         $last_time11 = $value->loged_in_at; 
         
    }
    
    if(empty($last_time11)) {
        

        
        if ($weekday =="Saturday" OR $weekday =="Sunday") { $week_end_class ='color:green'; } else {  $week_end_class ='color:blue'; }

        
    }
} 


    $forget_login_applied = Role::get_forget_applied_check($day_list[$i],$tracking_hours_list[0]->user_id);

  


    if(!empty($forget_login_applied)) {
        
        if ($weekday =="Saturday" OR $weekday =="Sunday") { $week_end_class ='color:green'; } else {  $week_end_class ='color:purple'; }

        
    }
  //  echo '<pre>'; print_r($day_list); exit;

    ?>

  
  

<tr style='<?php echo  $week_end_class; ?>'><td><?php echo $k; ?></td>
<td>
<?php

 $user_Details = Role::get_Usersid($tracking_hours_list[0]->user_id);
 echo $user_Details->emp_id;


  ?></td>

<td>
<?php
 $user_Details = Role::get_Usersid($tracking_hours_list[0]->user_id);
 echo $user_Details->name;

  ?></td>

  
<td>
<?php
        $work_date = date('Y-m-d',strtotime($day_list[$i])); 
        $work_Type = Role::get_WorkType1($work_date,$tracking_hours_list[0]->user_id);
       // echo '<pre>'; print_r( $work_Type);
        
         echo ucfirst((!empty($work_Type))?$work_Type->work_type:"-");      
  ?></td>


<td>
<?php
        $work_date = date('d-m-Y',strtotime($day_list[$i])); 
        /* $hoiday_type = Role::get_Officeholiday($work_date);        
        echo ucfirst((!empty($hoiday_type))?$hoiday_type->holiday_type:"-"); */


        $user_leave = Role::get_AllEmpLeaveReportbyAll($tracking_hours_list[0]->user_id,$work_date,'');
        echo ((!empty($user_leave))?'Leave':"-");
      

  ?></td>

<td><?php echo date('d-m-Y',strtotime($day_list[$i])); ?></td>
<td><?php echo date('D',strtotime($day_list[$i])); ?></td>

<td><?php 
$last_time1='';
$last_Logout1 = Role::get_firstlogintimebyid_new($day_list[$i],$tracking_hours_list[0]->user_id);
foreach($last_Logout1 as $key =>$value) {
     $last_time1 = $value->loged_in_at;
}

//echo (!empty($last_time1))?date('h:i A',strtotime($last_time1)):"-";

echo (!empty($last_time1))?date('h:i',strtotime($last_time1)):"-";


 ?></td>

<td>
<?php 
$last_time='';
$last_Logout = Role::get_firstlogintimebyid($day_list[$i],$tracking_hours_list[0]->user_id);
foreach($last_Logout as $key =>$value) {
     $last_time = $value->loged_out_at;
}

//echo (!empty($last_time))?date('h:i A',strtotime($last_time)):"-";
echo (!empty($last_time))?date('G:i',strtotime($last_time)):"-";
$last_out = date('h:i',strtotime($last_time));

 ?></td>

<td>
   

           
                <?php 


            



                $total_time ='';
                if(!empty($last_time)) {
                     $date1 = $last_time1;
                  //  echo '<br>';
                     $date2 = $last_time;
                    $datetime1 = new DateTime($date1);
                    $datetime2 = new DateTime($date2);
                    $interval = $datetime1->diff($datetime2);
                   echo $total_time = $interval->format('%h').":".$interval->format('%i');
                } else {
                    echo "00:00";
                }
                
                
                ?></td>
                


                <td>
                <?php 
                
                $total_break = Role::get_sumof_breaktime($tracking_hours_list[0]->user_id,$day_list[$i]);
                // echo '<pre>'; print_r($total_break[0]->totalduration);
                
                $init = $total_break[0]->totalduration;
                //echo '<br>';
                 $hours = floor($init / 3600);
                 $minutes = floor(($init / 60) % 60);
                 $seconds = $init % 60;
                 $total_break_hrs = "$hours:$minutes:$seconds";
                 //echo "$hours:$minutes:$seconds";

                 if(strpos($total_break_hrs, '-') !== false){
                    echo $total_break_hrs = "0:0:0";
                  } else{
                    echo $total_break_hrs = "$hours:$minutes:$seconds";
                  }



                /* $init = $total_break[0]->totalduration;
                $hours = floor($init / 3600);
                $minutes = floor(($init / 60) % 60);
                $seconds = $init % 60;
                $total_break_hrs = "$hours:$minutes:$seconds";
                
                echo "$hours:$minutes:$seconds";
                 */
                
                
                
                ?>
                
                </td>

                <td style='color:green;'>
                <?php 

                if(!empty($last_time)) {

               
             /*   echo 'Total Time :'.$total_time;
               echo '<br>'; */
               $time_reduce = strtotime($total_time);
                
                $time_check_fourhrs = strtotime("6:00");
                
              //  echo date('h:i',$time_reduce);
              //  echo '<br>';
                //$total_wrkhr = date('h:i:s',$time_reduce);

               $total_wrkhr = date('g:i',$time_reduce);
               // echo '<br>';
                $total_break_hrs;
                
              //  echo 'Total Working Hours'.$t_whr = strtotime($total_wrkhr);
              //  echo 'Break Hours'.$t_bhr = strtotime($total_break_hrs);
              //  echo '<br>';
               // $f_whr = $t_whr - $t_bhr;
             //   echo 'Final Hrs'.date('h:i:s',$f_whr);
              //  echo 'Final Time'.date('h:i',strtotime($duration));
             //   echo '<br>';


  
    $time1 = $total_wrkhr;
  //  echo '<br>';
    $time2 = $total_break_hrs;
  //  echo '<br>';
    $array1 = explode(':', $time1);
    $array2 = explode(':', $time2);

   // echo 'Arr'.$array1[0];

    if($array1[0]=='12') {
        $array1[0] = 0;
    }


    $check = explode(':',$total_time);
    


if(strcmp($total_break_hrs,"0:0:0")==0) {
    //echo 'No breadk hr';
    echo $total_time;
    
} else {
    /* echo $total_time;
    echo '<br>';
    echo $time2;
    echo '<br>'; */
    $time1 = new DateTime($total_time);
    $time2 = new DateTime($time2);
    $interval = $time1->diff($time2);
    echo $interval->format('%h').":".$interval->format('%i');
}

    $time_value[$i] =  date('H.i',$time_reduce);
     } else {
      echo "-";
   }

            
                ?>

                
                
                </td>   








</tr>
<?php  $i++; $k++; }  ?>

           
        </tbody>
    </table>
    <span style='text-align:centre;color:green;font-weight:bold;margin-left:500px;font-size:20px;display:none;'>
    Total Hours :  <?php // echo date('H:i',$sum_hours); 

             //   echo '<pre>'; print_r($time_value);

                print_r(array_sum($time_value));
    ?></span>
    </div>
    
    <!-- Jquery date picker Code Start -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {

    $("#from_date").datepicker({ format: "dd-mm-yyyy" }).val();
    $("#to_date").datepicker({ format: "dd-mm-yyyy" }).val();

  /* $( "#from_date" ).datepicker({

      
        //format: 'dd/mm/yyyy'

    }); */
 
   /*  $( "#to_date" ).datepicker({
       
}); */




  } );
  </script>
<!-- Jquery date picker Code End -->
 

@endsection