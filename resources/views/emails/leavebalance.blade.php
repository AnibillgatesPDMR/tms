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
                    <input type="button" value="Create" class="btn btn-success userform" onclick="form_validation();" />
                    
                </div>
                </form>
            </div>
        </div>
    </div>


 

<?php // echo '<pre>'; print_r($leave_list); exit; ?>



    <div class="row">
        <div class="col-md-5">
            <h3 class="modal-title">{{ Str::plural('Your Leave', count($leave_list)) }} </h3>
        </div>
        <div class="col-md-7 page-action text-right">
            <a href="{{ asset('leavedashboard') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
            @can('add_request_time_off')
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#roleModal"> <i class="glyphicon glyphicon-plus-sign"></i> Apply Leave</a>
            @endcan
            @can('edit_request_time_off')
                <a style='display:none;' href="{{ url('leave/approve') }}" class="btn btn-primary btn-sm"> <i class="glyphicon glyphicon-plus-sign"></i> Aprove Leave</a>
            @endcan
        </div>
    </div>

    <div class="result-set">
        <table class="table">
            <thead class="tablehead">
            <tr>
                <th>S.No</th>
                <th>Employee Name</th>
                <th>Annual Leave</th>
                <th>Unpaid sick Leave</th>
                <th>Sick leave/annual holiday</th>
                <th>Maternity leave</th>
                <th>Unpaid Leave</th>
                <th>Compassionate Leave (Paid)</th>
               

            </tr>
            </thead>
            <tbody>
            <?php $i=1; $j=0;

            
            
             
            
            ?>
            @foreach($leave_list as $item)

            
            

                <tr>
                    <td>{{ $i++ }}</td>
                    <td>
                    {{ $item->name }}
                    
 
 
 </td>
                    <td> <?php $leave_count = Role::leavebalance_count($item->id,'Annual Leave'); print_r( count($leave_count)); ?> / 20   &nbsp; <span style='color:green;font-weight:bold;'>Bal : <?php echo 20-count($leave_count); ?> </span> </td>
                    <td><?php $leave_count = Role::leavebalance_count($item->id,'Unpaid sick Leave'); print_r( count($leave_count)); ?> / 10 &nbsp; <span style='color:green;font-weight:bold;'>Bal : <?php echo 10-count($leave_count); ?> </span></td>
                    <td><?php $leave_count = Role::leavebalance_count($item->id,'Sick leave/annual holiday'); print_r( count($leave_count)); ?> / 15 &nbsp; <span style='color:green;font-weight:bold;'>Bal : <?php echo 15-count($leave_count); ?> </span></td>
                    <td><?php $leave_count = Role::leavebalance_count($item->id,'Maternity leave'); print_r( count($leave_count)); ?> / 6 &nbsp; <span style='color:green;font-weight:bold;'>Bal : <?php echo 6-count($leave_count); ?> </span></td>
                    
                    <td><?php $leave_count = Role::leavebalance_count($item->id,'Unpaid Leave'); print_r( count($leave_count)); ?> / 12 &nbsp; <span style='color:green;font-weight:bold;'>Bal : <?php echo 12-count($leave_count); ?> </span></td>
                
                    <td><?php $leave_count = Role::leavebalance_count($item->id,'Compassionate Leave (Paid)'); print_r( count($leave_count)); ?> / 15&nbsp; <span style='color:green;font-weight:bold;'>Bal : <?php echo 15-count($leave_count); ?> </span></td>
                    
                    
                </tr>
             
            @endforeach
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
  text: "Are You Sure You Want To Delete This",
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
      text: "Are You Sure You Want To Accept This",
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


 
 </script>

@endsection