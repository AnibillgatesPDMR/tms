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
                    <h4 class="modal-title" id="roleModalLabel">Apply Break</h4>
                </div>
                <div class="modal-body">
                    @include('breaktime._form')
                    <input type="hidden" name="created_by" value="{{Auth::user()->id}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                    <!-- Submit Form Button -->
                    <input type="button" value="Add" class="btn btn-success userform" onclick="break_form_validation();" />
                    
                </div>
                </form>
            </div>
        </div>
    </div>


 

<?php // echo '<pre>'; print_r($leave_list); exit; ?>



    <div class="row">
        <div class="col-md-5">
            <h3 class="modal-title">{{ Str::plural('Your Break Hours', count($leave_list)) }} </h3>
        </div>
        <div class="col-md-7 page-action text-right">
            <a href="{{ asset('leavedashboard') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
            @can('add_request_time_off')
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#roleModal"> <i class="glyphicon glyphicon-plus-sign"></i> Apply Break</a>
            @endcan
            
        </div>
    </div>

    <div class="result-set">
        <table class="table">
            <thead class="tablehead">
            <tr>
                <th>S.No</th>
                <th>Emp Id</th>
                <th>Employee Name</th>
                
                <th>Break time out</th>
                <th>Break time in </th> 
                <th>Date</th>             
                <th>Duration</th>
                <th>Remarks</th>
               
                
            </tr>
            </thead>
            <tbody>
            <?php $i=1; $j=0; 

           
            
            ?>
            @foreach($break_time_hours as $break_h)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $break_h->emp_id }} </td>
                    <td>
                    {{ $break_h->name }}
                    <?php 
                  //  $user = User::getUser($item->user_id);
                  
                  
                  //  echo $user->name; ?></td>
                    <td><?php echo date('G:i',strtotime($break_h->break_out)); ?></td>
                    <td><?php echo date('G:i',strtotime($break_h->break_in)); ?></td>
                    <td>{{ date('d - m - Y',strtotime($break_h->break_date)) }}</td>
                    <td>
                    <?php

                if($break_h->duration > 0) {

                $init = $break_h->duration;

                $hours = floor($init / 3600);
                $minutes = floor(($init / 60) % 60);
                $seconds = $init % 60;
                
                echo "$hours:$minutes:$seconds";

                } else {


                    $time1 = date('g:i',strtotime($break_h->break_out));
                   
                    $time2 = date('g:i',strtotime($break_h->break_in));

                    $time1 = new DateTime($time1);
                    $time2 = new DateTime($time2);
                    $interval = $time1->diff($time2);
                    echo $interval->format('%h').":".$interval->format('%i');


                    //echo 'Negative';
                }
               
                
                
                    ?>
                    
                    </td>                   
                    
                    <td>{{ $break_h->break_reason }}</td>
                    
                </tr>
               
            @endforeach
            </tbody>
        </table>
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