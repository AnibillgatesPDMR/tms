@extends('layouts.app')

@section('title', 'Holidays')

@section('content')
<?php 
use \App\Http\Controllers\UserController;
use App\Role;
use App\User;
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

.Pending {
    color:red;
    font-weight:bold;
}
.Reject {
    color:purple;
    font-weight:bold;
}
.Approved {
    color:green;
    font-weight:bold;
}
hr.new1 {
  border-top: 1px solid red;
}
h3 {
    font-size:15px !important;
    font-weight:bold !important;
}

</style>



    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
        <form>

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="roleModalLabel">Apply Leave</h4>
                </div>
                <div class="modal-body">
                    @include('leave._form')
                    <input type="hidden" name="created_by" value="{{Auth::user()->id}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                    <!-- Submit Form Button -->
                    <input type="button" value="Submit" class="btn btn-success userform" onclick="form_validation();" />
                    
                </div>
                </form>
            </div>
        </div>
    </div>


 

<?php
$al=1;

$psl=1;

$ul=1;

$sl=1;

$ml=1;

$uul=1;

$cl=1;

// echo '<pre>'; print_r($leave_list); exit; ?>



    <div class="row">
        <div class="col-md-5">
            <h3 class="modal-title">{{ Str::plural('Leave Details', count($leave_list)) }} </h3>
        </div>
        <div class="col-md-7 page-action text-right">
            <a href="{{ asset('leavebalance') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
            @can('add_request_time_off')
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#roleModal"> <i class="glyphicon glyphicon-plus-sign"></i> Apply Leave</a>
            @endcan
            @can('edit_request_time_off')
                <a style='display:none;' href="{{ url('leave/approve') }}" class="btn btn-primary btn-sm"> <i class="glyphicon glyphicon-plus-sign"></i> Aprove Leave</a>
            @endcan
        </div>
    </div>

    <div class="result-set">
        
    <h3>Annual Leave</h3>

    <table class="table">
            <thead class="tablehead">
            <tr>
                <th>S.No</th>
                <th>From Date </th>
                <th>To Date</th>
                <th>No Of Days</th>
                <th>Remarks</th>
                <th>Status</th>
                <th>Action</th>
               

            </tr>
            </thead>
            <tbody>
            <?php 
            $today_date = date('d-m-Y');
            foreach($leave_list as $item) {
                if($item->leave_type=='Annual Leave') {
                  
                ?>

            
            

                <tr>
                    <td>{{$al++ }}</td>                    
                    <td> 
                    <?php echo date('d-m-Y',strtotime($item->from_date)); ?>
                     </td>  
                    <td>  <?php echo date('d-m-Y',strtotime($item->to_date)); ?>  </td>
                    <td> {{ $item->no_ofdays }}  </td>
                    <td> {{ $item->remarks }}  </td>
                    <td class="<?php echo $item->leave_status; ?>"> <?php echo ($item->leave_status=='Withdraw')?"Withdrawn":$item->leave_status; ?>  </td>   

                    <?php if(strtotime($item->from_date) > strtotime($today_date) && $item->leave_status!='Withdraw') { ?>
                    <td class="<?php echo $item->leave_status; ?>"> <a href='javascript:void(0);' onclick='withdraw_leave("<?php echo $item->leave_id; ?>","<?php echo date('d-m-Y',strtotime($item->from_date)); ?>","<?php echo date('d-m-Y',strtotime($item->to_date)); ?>");'><i class="glyphicon glyphicon-edit"></a></i>  </td>   
                    <?php }  else {  ?>  
                        <td class="<?php echo $item->leave_status; ?>"><?php echo "-"; ?>  </td> 
                    <?php  }  ?>   
                    
                </tr>
             
           <?php } } ?>




            </tbody>
            </table>


    <hr class="new1">

            <h3>Paid Sick Leave</h3>

    <table class="table">
        <thead class="tablehead">
        <tr>
            <th>S.No</th>
            <th>From Date </th>
            <th>To Date</th>
            <th>No Of Days</th>
            <th>Remarks</th>
            <th>Status</th>
            <th>Action</th>
           

        </tr>
        </thead>
        <tbody>
        <?php 
        $today_date = date('d-m-Y');
        foreach($leave_list as $item) {
            if($item->leave_type=='Paid sick leave') {
              
            ?>
            <tr>
                <td>{{$psl++ }}</td>                    
                <td> 
                <?php echo date('d-m-Y',strtotime($item->from_date)); ?>
                 </td>  
                <td>  <?php echo date('d-m-Y',strtotime($item->to_date)); ?>  </td>
                <td> {{ $item->no_ofdays }}  </td>
                <td> {{ $item->remarks }}  </td>
                <td class="<?php echo $item->leave_status; ?>"> <?php echo ($item->leave_status=='Withdraw')?"Withdrawn":$item->leave_status; ?>  </td>   

                <?php if(strtotime($item->from_date) > strtotime($today_date) && $item->leave_status!='Withdraw') { ?>
                <td class="<?php echo $item->leave_status; ?>"> <a href='javascript:void(0);' onclick='withdraw_leave("<?php echo $item->leave_id; ?>","<?php echo date('d-m-Y',strtotime($item->from_date)); ?>","<?php echo date('d-m-Y',strtotime($item->to_date)); ?>");'><i class="glyphicon glyphicon-edit"></a></i>  </td>   
                <?php }  else {  ?>  
                    <td class="<?php echo $item->leave_status; ?>"><?php echo "-"; ?>  </td> 
                <?php  }  ?>   
                
            </tr>
         
       <?php } } ?>

        </tbody>
        </table>            

            

  
            <h3 style='display:none;'>Unpaid sick Leave</h3>

<table class="table" style='display:none;'>
        <thead class="tablehead">
        <tr>
            <th>S.No</th>
            <th>From Date </th>
            <th>To Date</th>
            <th>No Of Days</th>
            <th>Remarks</th>
            <th>Status</th>
            <th>Action</th>

        </tr>
        </thead>
        <tbody>
        <?php 
        $today_date = date('d-m-Y');
        foreach($leave_list as $item) {
            if($item->leave_type=='Unpaid sick Leave') {
            
            ?>

        
        

            <tr>
                <td>{{ $ul++ }}</td>                    
                <td> <?php echo date('d-m-Y',strtotime($item->from_date)); ?> </td>  
                <td> <?php echo date('d-m-Y',strtotime($item->to_date)); ?>  </td>
                <td> {{ $item->no_ofdays }}  </td>
                <td> {{ $item->remarks }}  </td>
                <td class="<?php echo $item->leave_status; ?>"> <?php echo ($item->leave_status=='Withdraw')?"Withdrawn":$item->leave_status; ?>  </td>      
                <?php if(strtotime($item->from_date) > strtotime($today_date) && $item->leave_status!='Withdraw') { ?>
                    <td class="<?php echo $item->leave_status; ?>"> <a href='javascript:void(0);' onclick='withdraw_leave("<?php echo $item->leave_id; ?>","<?php echo date('d-m-Y',strtotime($item->from_date)); ?>","<?php echo date('d-m-Y',strtotime($item->to_date)); ?>");'><i class="glyphicon glyphicon-edit"></a></i>  </td>   
                    <?php }  else {  ?>  
                        <td class="<?php echo $item->leave_status; ?>"><?php echo "-"; ?>  </td> 
                    <?php  }  ?>   
                                  
                
            </tr>
         
       <?php } } ?>




        </tbody>
        </table>               

        <hr class="new1">

        <h3>Sick leave/annual holiday</h3>

<table class="table">
        <thead class="tablehead">
        <tr>
            <th>S.No</th>
            <th>From Date </th>
            <th>To Date</th>
            <th>No Of Days</th>
            <th>Remarks</th>
            <th>Status</th>
           
 <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php 
        foreach($leave_list as $item) {
            if($item->leave_type=='Sick leave/annual holiday"') {
            
            ?>

        
        

            <tr>
                <td>{{ $sl++ }}</td>                    
                <td> <?php echo date('d-m-Y',strtotime($item->from_date)); ?>  </td>  
                <td> <?php echo date('d-m-Y',strtotime($item->to_date)); ?>    </td>
                <td> {{ $item->no_ofdays }}  </td>
                <td> {{ $item->remarks }}  </td>
                <td class="<?php echo $item->leave_status; ?>"> <?php echo ($item->leave_status=='Withdraw')?"Withdrawn":$item->leave_status; ?>  </td>   
                <?php if(strtotime($item->from_date) > strtotime($today_date) && $item->leave_status!='Withdraw') { ?>
                    <td class="<?php echo $item->leave_status; ?>"> <a href='javascript:void(0);' onclick='withdraw_leave("<?php echo $item->leave_id; ?>","<?php echo date('d-m-Y',strtotime($item->from_date)); ?>","<?php echo date('d-m-Y',strtotime($item->to_date)); ?>");'><i class="glyphicon glyphicon-edit"></a></i>  </td>   
                    <?php }  else {  ?>  
                        <td class="<?php echo $item->leave_status; ?>"><?php echo "-"; ?>  </td> 
                    <?php  }  ?>   
                                     
                
            </tr>
         
       <?php } } ?>




        </tbody>
        </table>   
        <hr class="new1">
        <h3>Maternity leave</h3>

<table class="table">
        <thead class="tablehead">
        <tr>
            <th>S.No</th>
            <th>From Date </th>
            <th>To Date</th>
            <th>No Of Days</th>
            <th>Remarks</th>
            <th>Status</th>
            <th>Action</th>

        </tr>
        </thead>
        <tbody>
        <?php 
        $today_date = date('d-m-Y');
        foreach($leave_list as $item) {
            if($item->leave_type=='Maternity leave') {
            
            ?>

        
        

            <tr>
                <td>{{ $ml++ }}</td>                    
                <td> <?php echo date('d-m-Y',strtotime($item->from_date)); ?>  </td>  
                <td> <?php echo date('d-m-Y',strtotime($item->to_date)); ?>  </td>
                <td> {{ $item->no_ofdays }}  </td>
                <td> {{ $item->remarks }}  </td>
                <td class="<?php echo $item->leave_status; ?>"> <?php echo ($item->leave_status=='Withdraw')?"Withdrawn":$item->leave_status; ?> </td>  
                <?php if(strtotime($item->from_date) > strtotime($today_date) && $item->leave_status!='Withdraw') { ?>
                    <td class="<?php echo $item->leave_status; ?>"> <a href='javascript:void(0);' onclick='withdraw_leave("<?php echo $item->leave_id; ?>","<?php echo date('d-m-Y',strtotime($item->from_date)); ?>","<?php echo date('d-m-Y',strtotime($item->to_date)); ?>");'><i class="glyphicon glyphicon-edit"></a></i>  </td>   
                    <?php }  else {  ?>  
                        <td class="<?php echo $item->leave_status; ?>"><?php echo "-"; ?>  </td> 
                    <?php  }  ?>   
                                      
                
            </tr>
         
       <?php } } ?>




        </tbody>
        </table>

        <hr class="new1">
        <h3>Unpaid Leave</h3>

<table class="table">
        <thead class="tablehead">
        <tr>
            <th>S.No</th>
            <th>From Date </th>
            <th>To Date</th>
            <th>No Of Days</th>
            <th>Remarks</th>
            <th>Status</th>
            <th>Action</th>

        </tr>
        </thead>
        <tbody>
        <?php 
        $today_date = date('d-m-Y');
        foreach($leave_list as $item) {
            if($item->leave_type=='Unpaid Leave') {
            
            ?>

        
        

            <tr>
                <td>{{ $uul++ }}</td>                    
                <td> <?php echo date('d-m-Y',strtotime($item->from_date)); ?>  </td>  
                <td> <?php echo date('d-m-Y',strtotime($item->to_date)); ?>   </td>
                <td> {{ $item->no_ofdays }}  </td>
                <td> {{ $item->remarks }}  </td>
                <td class="<?php echo $item->leave_status; ?>"> <?php echo ($item->leave_status=='Withdraw')?"Withdrawn":$item->leave_status; ?>  </td>     
                <?php if(strtotime($item->from_date) > strtotime($today_date) && $item->leave_status!='Withdraw') { ?>
                    <td class="<?php echo $item->leave_status; ?>"> <a href='javascript:void(0);' onclick='withdraw_leave("<?php echo $item->leave_id; ?>","<?php echo date('d-m-Y',strtotime($item->from_date)); ?>","<?php echo date('d-m-Y',strtotime($item->to_date)); ?>");'><i class="glyphicon glyphicon-edit"></a></i>  </td>   
                    <?php }  else {  ?>  
                        <td class="<?php echo $item->leave_status; ?>"><?php echo "-"; ?>  </td> 
                    <?php  }  ?>   
                                   
                
            </tr>
         
       <?php } } ?>




        </tbody>
        </table>        
        <hr class="new1">
        <h3>Compassionate Leave (Paid)</h3>

<table class="table">
        <thead class="tablehead">
        <tr>
            <th>S.No</th>
            <th>From Date </th>
            <th>To Date</th>
            <th>No Of Days</th>
            <th>Remarks</th>
            <th>Status</th>
           <th>Action</th>

        </tr>
        </thead>
        <tbody>
        <?php 
        $today_date = date('d-m-Y');
        foreach($leave_list as $item) {
            if($item->leave_type=='Compassionate Leave (Paid)') {
            
            ?>

        
        

            <tr>
                <td>{{ $cl++ }}</td>                    
                <td> <?php echo date('d-m-Y',strtotime($item->from_date)); ?>  </td>  
                <td> <?php echo date('d-m-Y',strtotime($item->to_date)); ?>  </td>
                <td> {{ $item->no_ofdays }}  </td>
                <td> {{ $item->remarks }}  </td>
                <td class="<?php echo $item->leave_status; ?>"> <?php echo ($item->leave_status=='Withdraw')?"Withdrawn":$item->leave_status; ?>  </td>  
                <?php if(strtotime($item->from_date) > strtotime($today_date) && $item->leave_status!='Withdraw') { ?>
                    <td class="<?php echo $item->leave_status; ?>"> <a href='javascript:void(0);' onclick='withdraw_leave("<?php echo $item->leave_id; ?>","<?php echo date('d-m-Y',strtotime($item->from_date)); ?>","<?php echo date('d-m-Y',strtotime($item->to_date)); ?>");'><i class="glyphicon glyphicon-edit"></a></i>  </td>   
                    <?php }  else {  ?>  
                        <td class="<?php echo $item->leave_status; ?>"><?php echo "-"; ?>  </td> 
                    <?php  }  ?>   
                                      
                
            </tr>
         
       <?php } } ?>




        </tbody>
        </table> 


        <?php // echo '<pre>'; print_r($employee_name); ?>
       @if(count($result)==20)                     
        <div class="text-center">
            {{ $result->links() }}
        </div>
        @endif
    </div>
    
    



    <script>
 function delete_leave(id,user_id) {
    

swal({
  title: "Are you sure?",
  text: "Are You Sure to Want To Delete This",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-danger",
  confirmButtonText: "Yes, delete it!",
  closeOnConfirm: false
},
function(){

    var formValues = {id:id,user_id:user_id}

   $.ajax({
        type: "GET",
        url: "{{ asset('deleteuserleave/{id}/{userid}') }}",
        data: formValues,
        cache: false,
        success: function(data){

           if(data==1) {
           
            swal({title: "Deleted", text: "Your Leave has been deleted.", type: "success"},
                function(){ 
                    location.reload();
                }
                );
            
           }else {

            swal({title: "Try Again!", text: "Your Leave has not been deleted.", type: "info"},
                function(){ 
                    location.reload();
                }
                );
           }


        }
        });  



  
});


 }



 /* Accept Leave */


 function accept_leave(id,user_id) {
    

    swal({
      title: "Are you sure?",
      text: "Are You Sure to Want To Accept This",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, Accept it!",
      closeOnConfirm: false
    },
    function(){
    
        var formValues = {id:id,user_id:user_id}
    
       $.ajax({
            type: "GET",
            url: "{{ asset('acceptuserleave/{id}/{userid}') }}",
            data: formValues,
            cache: false,
            success: function(data){
    
               if(data==1) {
               
                swal({title: "Accepted", text: "Leave has been Accepted.", type: "success"},
                    function(){ 
                        location.reload();
                    }
                    );
                
               }else {
    
                swal({title: "Try Again!", text: "Your Leave has not been deleted.", type: "info"},
                    function(){ 
                        location.reload();
                    }
                    );
               }
    
    
            }
            });  
    
    
    
      
    });
    
    
     }






/* withdraw leave feature */

var url = window.location.href;
var projet_path = url.split('/');
var url_path = window.location.origin + '/' + projet_path[3];

function withdraw_leave(id,s_date,e_date) {
    

    swal({
      title: "Are you sure you want to withdraw this leave?",
      text: "Date :  " +s_date+' and '+e_date,
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, withdraw it!",
      closeOnConfirm: false
    },
    function(){
    
        var formValues = {id:id}
    
       $.ajax({
            type: "GET",
            //url: "<?php //echo 'https://ise70.compuscript.ie/tms/public/withdrawleave'; ?>",
            url: url_path+"<?php echo '/public/withdrawleave'; ?>",
            data: formValues,
            cache: false,
            success: function(data){

               // alert(data);

               /*  alert(data);
                exit; */
    
               if(data==1) {
               
                swal({title: "Success", text: "Your Leave has been withdrawn.", type: "success"},
                    function(){ 
                        location.reload();
                    }
                    );
                
               }else {
    
                swal({title: "Try Again!", text: "Your Leave has not been withdrawn.", type: "info"},
                    function(){ 
                        location.reload();
                    }
                    );
               }
    
    
            }
            });  
    
    
    
      
    });
    
    
     }
    





 
 </script>

@endsection