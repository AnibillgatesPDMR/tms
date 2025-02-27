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
    <div class="row">
        <div class="col-md-5">
            <h3 class="modal-title">{{ Str::plural('Leave Approve', count($leave_list)) }} </h3>
        </div>
        <div class="col-md-7 page-action text-right">
            <a href="{{ url('leave/add/leave') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>

    <div class="result-set">
        <table class="table">
            <thead class="tablehead">
            <tr>
                <th>S.No</th>
                <th>Employee Name</th>
                <th>Leave Type</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>No Of Days</th>
                <th>Status</th>
                <th>Remarks</th>
               
                @can('edit_request_time_off', 'delete_request_time_off')
                <th class="text-center">Actions</th>
                @endcan
            </tr>
            </thead>
            <tbody>
            <?php $i=1; $j=0; ?>
            @foreach($leave_list as $item)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td><?php $user = User::getUser($item->user_id); echo $user->name; ?></td>
                    <td>{{ $item->leave_type }}</td>
                    <td>{{ date('Y - M - d',strtotime($item->from_date)) }}</td>
                    <td>{{ date('Y - M - d',strtotime($item->to_date)) }}</td>
                    <td>{{ $item->no_ofdays }} &nbsp;Days</td>
                    <td>
                        <?php if($item->leave_status=='Pending') 
                        { $color='red'; } else if($item->leave_status=='Approved') { $color='green'; } else { $color='purple'; }?>
                    
                    <span style='color:<?php echo $color; ?>'>{{ $item->leave_status }}</span>
                </td>
                    <td>{{ $item->remarks }}</td>
                    @can('edit_request_time_off', 'delete_request_time_off')
                    <td>
                    <?php if($item->leave_status=='Pending') { ?>
                    <a href="{{ asset('leave-approve/1') }}/{{$item->leave_id}}/{{$item->user_id}}" class="btn btn-xs btn-info"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Approve</a>
                    <a href="{{ asset('leave-approve/0') }}/{{$item->leave_id}}/{{$item->user_id}}" class="btn btn-xs btn-danger"><i class="fa fa-ban" aria-hidden="true"></i>&nbsp;Reject</a>
                    <?php } else { echo "-"; } ?>
                    </td>
                    @endcan
                </tr>
               
            @endforeach
            </tbody>
        </table>                   
        <div class="text-center">
            {{ $leave_list->links() }}
        </div>
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
 
 </script>

@endsection