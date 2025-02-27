@extends('layouts.app')

@section('title', 'Users')

@section('content')
<?php 
use \App\Http\Controllers\UserController;
use App\Role;
use Illuminate\Support\Str;
?>
<style>
.tooltip1 {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
}

.tooltip1 .tooltiptext1 {
    visibility: hidden;
    width: 300px;
    height:200px;
    background-color: green;
    color: #fff;
    text-align: left;
    border-radius: 6px;
    padding:15px;
    font-size:14px;
    font-weight:bold;
    
    /* Position the tooltip */
    position: absolute; 
    z-index: 1; 
    top: -5px;
    right: 105%;
}

.tooltip1:hover .tooltiptext1 {
    visibility: visible;
}

.tooltip2 {
    position: relative;
    display: inline-block;
   /* border-bottom: 1px dotted black;*/
}

.tooltip2 .tooltiptext2 {
    visibility: hidden;
    width: 300px;
    height:200px;
    background-color: green;
    color: #fff;
    text-align: left;
    border-radius: 6px;
    padding:15px;
    font-size:14px;
    font-weight:bold;
    
    /* Position the tooltip */
    position: absolute; 
    z-index: 1; 
    top: -5px;
    left: 105%;
}

.tooltip2:hover .tooltiptext2 {
    visibility: visible;
}



</style>

    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['route' => ['users.store'], 'enctype' => 'multipart/form-data']) !!}

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="roleModalLabel">Create User</h4>
                </div>
                <div class="modal-body">
                    @include('user._form')
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


 <!-- Add shift time popup -->

   <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


    <!-- Add shift time end Popup -->





    <div class="row">
        <div class="col-md-5">
            <h3 class="modal-title">{{ $result->total() }} {{ Str::plural('User', $result->count()) }} </h3>
        </div>
        <div class="col-md-7 page-action text-right">
            <a href="{{ asset('users') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
            @can('add_users')
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#roleModal"> <i class="glyphicon glyphicon-plus-sign"></i> Create User</a>
            @endcan
        </div>
    </div>

    <div class="result-set">
        <table class="table">
            <thead class="tablehead">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created By</th>
                <!-- <th>Created At</th> -->
                <th>Today In / Out</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
             //echo '<pre> Resultvalue: '; print_r($result);
             //exit();
             if($result!='') { ?>
            <?php $i=1; $j=0; ?>
            @foreach($result as $item)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>
                   
                    <?php 


                        

                       $break_time_user =  UserController::get_break_time_user($item->id); 

                       if($break_time_user==1) {
                           //echo 'Break';
                       } else {
                          // echo 'Not Break';
                       }
                      

                    ?>

                    <?php 
                    $color ='';

                    if($item->is_logged=="1") {

                        $color ='color:green';


                    } else { 

                        $color ='color:red';

                    }


                    if($break_time_user==1) {   $color ='color:yellow';  }  
                   



                     /* if($item->is_logged=="1") {
                        $color = 'color: green !important;'
                        } else {
                            $color = 'color: red !important;'
                        } 
                            if($break_time_user==1) {
                            $color ='color:yellow';
                        }  else {
                        $color ='color:green';
                        }
                        
                        */
                         ?>


                    <i class="fa fa-circle text-success" style="<?php echo $color; ?>"></i>&nbsp;&nbsp;&nbsp; 
                    
                    <img src="{{ ($item->profile_path!=NULL)?asset($item->profile_path):asset('images/avartar.png')}} " class="img-circle" alt="User Image" style="widht:25px;height:25px;">
                    
                    &nbsp;&nbsp;
                    <a class="tooltip2">
                    {{ $item->name }}

                    <?php
                    $empDetails='';
                    $empDetails.= 'Employee Details';
                    $empDetails.= '<br />';  
                    $empDetails.= '-------------------------------------------'; 
                    $empDetails.= '<br />';
                    $empDetails.="EmpId :".$item->emp_id;
                    $empDetails.= '<br />';
                    $empDetails.="Emaild Id :" .$item->email;
                    $empDetails.= '<br />';

                   
                   
                    ?>
                    
                    <span class="tooltiptext2"><?php echo $empDetails; ?></span>
                    </a>
                    
                    </td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->roles->implode('name', ', ') }}</td>
                    <td><?php $user = UserController::getUser($item->created_by); 
                  
                    compact('user'); 
                    $user = json_decode($user, true); echo $user['name']; 

                    
                    
                    
                    ?>
                    
                    
                    </td>
                   <!-- <td>{{ $item->created_at->toFormattedDateString() }}</td> -->
                   <td style='color:red;font-weight:bold;'>
                   <?php 
                   // date_default_timezone_set('Asia/Calcutta');
                    $hrs = '' ;
                    $login_details = UserController::getLogindetailById($item->id);
                    $data_values = array();
                    $in_date = '';
                    $array_logindetails = (array)$login_details;
                    foreach ($array_logindetails as $key=> $data) {
                     $data_values[] = $data;
                    }                  
                   for($k=0;$k<count($data_values);$k++){
                    if($k==0) {
                         $in_date = $data_values[0];                       
                    }                      
                   }         
 
                    if(!empty($in_date)) { 
                        if($item->emp_id=='123'){
                            $hrs = (date('D')=='Sat')?3.5:5;
                        }   
                        else{
                            $hrs = (date('D')=='Sat')?3.5:8;
                        }          
                        echo date('H:i',strtotime($in_date))." / ".date('H:i',strtotime($in_date)+ 60*60*$hrs);
                        echo '<br /> Work At : '.ucfirst($data_values[3]);
                    }
                    
                    
                   ?>
                
                   </td>
                    
                    <td class="text-center">
                        @can('view_users')
                        <?php
                        $sheet_value='';
                        $weekTimeSheet = UserController::getWeekTimeSheet($item->id);
                        if(!empty($weekTimeSheet)) {
                        
                        $sheet_value.= 'This Week Shift TIme';
                        $sheet_value.= '<br />';  
                        $sheet_value.= '-------------------------------------------'; 
                        $sheet_value.= '<br />';
                        foreach($weekTimeSheet as $sheet) {
                            
                            
                            $sheet_value.=$sheet->shift_start_date."--".$sheet->shift_start." / ".$sheet->shift_end;
                            $sheet_value.= '<br />';

                        }
                    } else {
                        $sheet_value='';
                    }

                       ?>
                        <a class="btn btn-xs btn-success" href="{{ asset('users/view') }}/{{$item->id}}">View</a>
                       
                       
                       
                       <!-- <a  title="<?php  print_r($sheet_value); ?>" class="btn btn-xs btn-warning" href="{{ asset('users/shift') }}/{{$item->id}}">Shift Time</a> -->
                    <a style='display:none;' class="btn btn-xs btn-warning tooltip1" href="{{ asset('users/shift') }}/{{$item->id}}">Shift Time
                    <span class="tooltiptext1"><?php   echo ($sheet_value!='')?$sheet_value:"No Records"; ?></span>
                    </a>
                  
                        @endcan
                        @can('edit_users')
                        @include('shared._actions', [
                            'entity' => 'users',
                            'id' => $item->id
                        ])
                        @endcan
                    </td>
                </tr>
              
            @endforeach
            </tbody>
             <?php } ?>
        </table>

        <div class="text-center">
            {{ $result->links() }}
        </div>
    </div>
    
 

@endsection