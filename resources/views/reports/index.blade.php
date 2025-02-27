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

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        searching: false,
        "pageLength": 31,
        buttons: [
            'copyHtml5',
            'excelHtml5',            
            
        ]

        
    } );



});
// Code that uses other library's $ can follow here.
</script>




@extends('layouts.app')

@section('title', 'Reports')

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
            <h3 class="modal-title">{{ Str::plural('Reports', count($tracking_hours_list)) }} </h3>
        </div>
    </div>

    <div class="col-md-12" style="margin-top: 10px; margin-bottom: 20px; padding: 0;">
        <form method="post" action="{{ asset('reports') }}">
            <div class="form-group col-md-5 @if ($errors->has('user_list')) has-error @endif" style="padding-left: 0;">
                {!! Form::label('user', 'Emp Name') !!}
                
                <?php if(Auth::user()->designation==1) { ?>
                <select name="emp_name" class="form-control" required='required' id="emp_name">
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
                <input type="text" id="from_date" class="form-control" name="from_date" autocomplete='Off' />
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('to_date', 'To Date') !!}
                <input type="text" id="to_date" class="form-control" name="to_date" autocomplete='Off'/>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
            <div class="form-group col-md-1" style="margin-top: 24px;">
                {!! Form::submit('Submit', ['class' => 'btn btn-success pull-right']) !!}
            </div>
        </form>
    </div>

    <hr />
    
    <div class="result-set">
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr style='font-size:10px !important;'>
                <th>S.No</th>
                <th>Emp Id
                <th>Emp Name</th>
                <th>Work Type</th>
                <th>Holiday</th>
                <th>Date</th>
                
                <th>In Time</th>
                <th>Out Time </th> 
                <th>Login Hours</th>
                <th>Break Time</th>
                <th>Working Hours<br />
                
                </th>               
               
            </tr>
        </thead>
        <tbody>


        
        <?php 

$sum_hours = 0;
$diff_in_hrs1 =0;
$row_color ='';

$time_value = array();

/*  echo '<pre>'; print_r($tracking_hours_list);
 exit; */




if(!empty($tracking_hours_list)) { 

$i=1; 

foreach($tracking_hours_list as $list) { 
$row_color = (empty($list->loged_out_at))?"#fff":"";


$row_color = Role::get_firstlogintimebyid($list->loged_in_at,$list->user_id);
foreach($row_color as $key =>$value) {
     $last_time = $value->loged_out_at;
}
$row_change = (empty($last_time))?"#fff":"";

?>

<tr style='background-color:<?php echo $row_change; ?>'>
<td><?php echo $i; ?></td>

<td>
<?php
 $user_Details = Role::get_Usersid($list->user_id);
 echo $user_Details->emp_id;

  ?></td>

<td>
<?php
 $user_Details = Role::get_Usersid($list->user_id);
 echo $user_Details->name;

  ?></td>

  <td>
<?php
        $work_date = date('Y-m-d',strtotime($list->loged_in_at)); 
        $work_Type = Role::get_WorkType1($work_date,$list->user_id);
       // echo '<pre>'; print_r( $work_Type);
        
       echo ucfirst((!empty($work_Type))?$work_Type->work_type:"");
      
  ?></td>

    <td>
<?php
        $work_date = date('d-m-Y',strtotime($list->loged_out_at)); 
        $hoiday_type = Role::get_Officeholiday($work_date);
        
        echo ucfirst((!empty($hoiday_type))?$hoiday_type->holiday_type:"-");
      

  ?></td>


<td><?php echo date('d-m-Y',strtotime($list->loged_in_at)); ?></td>
<td><?php 

echo date('G:i',strtotime($list->loged_in_at));

//echo date('h:i A',strtotime($list->loged_in_at));
$in_time = date('h:i',strtotime($list->loged_in_at));
?></td>
<td>
<?php 
$last_time='';
$last_Logout = Role::get_firstlogintimebyid($list->loged_in_at,$list->user_id);
foreach($last_Logout as $key =>$value) {
     $last_time = $value->loged_out_at;
}

echo (!empty($last_time))?date('G:i',strtotime($last_time)):"";
//$last_out = date('h:i',strtotime($last_time));

 ?></td>
 
 
  <td>
   

           
                <?php 


            



                $total_time ='';
                if(!empty($last_time)) {
                    $date1 = $list->loged_in_at;
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
                
                $total_break = Role::get_sumof_breaktime($list->user_id,$list->loged_in_at);
               /*  echo '<pre>'; print_r($total_break[0]->totalduration);
                echo '<br>'; */
                
                $init = $total_break[0]->totalduration;
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
                
                
                
                ?>
                
                </td>
                
                
                <td style='color:green;'>
                <?php 

                if(!empty($last_time)) {

               
                /* echo 'Total Time :'.$total_time;
               echo '<br>';  */
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


   /*  echo '<pre>Time1 : '; print_r($time1); 

    echo '<pre>Time2 : '; print_r($time2); exit; */



  
   // echo 'Arr'.$array1[0];

    if($array1[0]=='12') {
        $array1[0] = 0;
    }


    $check = explode(':',$total_time);
    /* print_r($check);
    echo '<br>'; */

   
    


   /*  if($check[0] >= 13) {
       // echo 'true';
     
        $minutes1 = ($check[0] * 60.0 + $array1[1]);

    } else {
       
       
        $time_in_12_hour_format  = date("g:i", strtotime($time1));
      
        $minutes1  = date("g:i", strtotime($time1));

       
       
    } */


   /*  echo '<pre>Time1'; print_r($time1);
    echo '<br>';
    echo '<pre>Time2'; print_r($time2);
    echo '<br>';



    $minutes1  =strtotime($time1);
    $minutes2 =strtotime($time2);
    $diff = $minutes1 - $minutes2; */


   

   

   
    /* echo '<pre>TB'; print_r($total_break_hrs);
    echo '<br>'; */

    if(strcmp($total_break_hrs,"0:0:0")==0) {
        //echo 'No breadk hr';
        echo $total_time;
        
    } else {
        $time1 = new DateTime($time1);
        $time2 = new DateTime($time2);
        $interval = $time1->diff($time2);
        echo $interval->format('%h').":".$interval->format('%i');
    }



   // exit;







    /* echo '<pre>Time2444 : '; print_r($minutes1); exit; 

 
    if($time2 == '0:0:0' || $time2 == '00:00:00') {
       

        $minutes2 =0;
    }  else {
       

        $minutes2 = ($array2[0] * 60.0 + $array2[1]);

    } 
  
    
    
   
   
  
    
  

  


    if( $minutes2!=0){ $diff = $minutes1 - $minutes2; } else { $diff = $minutes1;  }

    
    
    $minutes = $diff;


$minutes = strtotime($minutes);   

$hours = floor($minutes / 60);
$min = $minutes - ($hours * 60);



//echo 'Break Time : '.$total_break_hrs;
if($total_break_hrs=='0:0:0') {
    //echo 'No breadk hr';
    echo $total_time;
    
} else {
    echo $hours.":".$min;
   //echo 'Break hr';
}

//echo '<pre>Time1 : '; print_r($hours); exit; */

$time_value[$i] =  date('H.i',$time_reduce);
              


            } else {
                echo "-";
            }

            
                ?>

                
                
                </td>
 </tr>

 <?php $i++; 

 
 }

}  else {
  echo "<span style='color:red;font-weight:bold;'>No Records Found</span>";
}
// empty check if End

?>

           
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

  $( "#from_date" ).datepicker({

        autoclose: true
    });
 
    $( "#to_date" ).datepicker({

autoclose: true
});




  } );
  </script>
<!-- Jquery date picker Code End -->
 

@endsection