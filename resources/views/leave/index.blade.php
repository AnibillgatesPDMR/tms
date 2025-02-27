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

#information-main {
    margin-left:5px;
}
#information-sub {
    padding: 16px;
    background-color: lightgoldenrodyellow;
}

.request_title{
    font-weight:bold !important;
    color:blue;
}


</style>



    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
        <form>

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="roleModalLabel">Request leave</h4>
                </div>
                <div class="modal-body">
                    @include('leave._form')
                    <input type="hidden" name="created_by" value="{{Auth::user()->id}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

                    <!-- Submit Form Button -->
                    <input type="button" value="Submit" class="btn btn-success userform" onclick="form_validation();" />
                    
                </div>
                </form>
            </div>
        </div>
    </div>


 

<?php // echo '<pre>'; print_r($leave_list); exit; ?>



    <div class="row">
        <div class="col-md-5">
            <h3 class="modal-title">{{ Str::plural('Leave List', count($leave_list)) }} </h3>
        </div>
        <div class="col-md-7 page-action text-right">
        <a href="{{ asset('leavedashboard') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
            <a href="{{ asset('leavebalance') }}" style="margin-right: 10px;" class="btn btn-primary btn-sm"> <i class="glyphicon glyphicon-plus-sign"></i> Leave Balance</a>
            @can('add_request_time_off')
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#roleModal" > <i class="glyphicon glyphicon-plus-sign"></i> Request leave</a>
                
           
            @endcan
            
            @can('edit_request_time_off')
                <a style='display:none;' href="{{ url('leave/approve') }}" class="btn btn-primary btn-sm"> <i class="glyphicon glyphicon-plus-sign"></i> Approve Leave</a>
            @endcan

            <?php if($role=='17') { ?>
            <a  href="javascript:void(0);" onclick='accept_leave_bulk();' class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i>Approve Leave</a>     
            <a  href="javascript:void(0);" onclick='reject_leave_bulk();' class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i>Reject Leave</a>     
            <?php } ?>  
            <a style='display:none;' href="{{ url('leavebalance') }}"  class="btn btn-primary btn-sm"> <i class="glyphicon glyphicon-plus-sign"></i> Leave Balance</a>

        </div>
    </div>

    <div class="result-set">
        <table class="table">
            <thead class="tablehead">
            <tr>
                <th><input type='checkbox' id="checkAll" onclick="chk_all_leave();"></th>
                <th>S.No</th>
                <th>Emp Id</th>
                <th>Employee Name</th>
                <th>Leave Type</th>
                <th>From&nbsp; Date</th>
                <th>To Date</th>
                <th>No Of Days</th>
                <th>Status</th>
                <th>Remarks <?php // echo $role; ?></th>
               
               
                <th class="text-center" style='display:block;' >Actions</th>
               
            </tr>
            </thead>
            <tbody>
            <?php $i=1; $j=0;
            
           // echo '<pre>'; print_r($leave_list);

            ?>
            <?php 
            $today_date = date('d-m-Y');
            //print_r($leave_list);
            foreach($leave_list as $item) { 
                $leave_year = date('Y',strtotime($item->created_date));
                $leave_year1 = date('Y',strtotime($item->to_date));
                $leave_year2 = date('Y',strtotime($item->from_date));
                if($leave_year==date('Y') || $leave_year1==date('Y') || $leave_year2==date('Y')) {
                   if($item->leave_status=='Pending') {
                ?>
                <tr>
                <td><input type='checkbox' name='leave_list[]' id='<?php echo $item->leave_id; ?>' value='<?php echo $item->leave_id; ?>' /></td>
                    <td>{{ $i++ }}</td>
                    <td>{{ $item->emp_id }} </td>
                    <td>
                    {{ $item->name }}
                    <?php 
                  //  $user = User::getUser($item->user_id);
                  
                  
                  //  echo $user->name; ?></td>
                    <td>{{ $item->leave_type }}</td>
                    <td>{{ date('d-m-Y',strtotime($item->from_date)) }}</td>
                    <td>{{ date('d-m-Y',strtotime($item->to_date)) }}</td>
                    <td>{{ $item->no_ofdays }} &nbsp;Days</td>
                    <td>
                        <?php if($item->leave_status=='Pending') 
                        { $color='red'; } else if($item->leave_status=='Approved') { $color='green'; } else { $color='purple'; }?>
                    
                    <span style='color:<?php echo $color; ?>'>{{ $item->leave_status }}</span>
                </td>
                    <td>{{ $item->remarks }}</td>

                      <?php 
                    
                    if(strtotime($item->from_date) > strtotime($today_date) && $item->leave_status!='Withdraw') { ?>
                    <td> <a href='javascript:void(0);' onclick='withdraw_leave("<?php echo $item->leave_id; ?>","<?php echo date('d-m-Y',strtotime($item->from_date)); ?>","<?php echo date('d-m-Y',strtotime($item->to_date)); ?>");'><i class="glyphicon glyphicon-edit"></a></i>  </td>   
                    <?php }  else {  ?>  
                        <td><?php echo "-"; ?>  </td> 
                    <?php  }  ?>   




                    <?php if($role==17) { ?>




                    <td style='display:none;'>
                   
                    
                   
                   <a href="javascript:void(0);" onclick="accept_leave('<?php echo $item->leave_id; ?>','<?php echo $item->user_id; ?>');" ><button class="btn-delete btn btn-xs btn-danger"><i class="glyphicon glyphicon-pencil"></i></button></a>    
                   <br />
                   <a href="javascript:void(0);" onclick="delete_leave('<?php echo $item->leave_id; ?>','<?php echo $item->user_id; ?>');" ><button class="btn-delete btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></button></a>

                   
                    </td>

                    
                    <?php }  ?>
                </tr>
               
<?php } } } ?>
            </tbody>
        </table>
       @if(count($result)==20)                     
        <div class="text-center">
            {{ $result->links() }}
        </div>
        @endif
    </div>
    
    



    <script>


function chk_all_leave() {

   // alert('Checked All');
    $("input[type='checkbox']").prop("checked", true);


}




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

<script>

function accept_leave_bulk() {

  //  alert('Testing');

  var forget_login_ids ='';

    $("input[type=checkbox]:checked").each ( function() {
    
     forget_login_ids +=  $(this).val() + ','; 

    // alert ( $(this).val() );
});


    // alert('Ids'+forget_login_ids);


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

    var formValues = {id:forget_login_ids}

   $.ajax({
        type: "GET",
        url: "{{ asset('leave_acceptbulk/{id}') }}",
        data: formValues,
        cache: false,
        success: function(data){

           // alert(data);

           if(data==1) {
           
            swal({title: "Applied", text: "Leave Approved Successfully.", type: "success"},
                function(){ 
                    location.reload();
                }
                );
            
           }else {

            swal({title: "Try Again!", text: "Leave Approved Cancelled.", type: "info"},
                function(){ 
                    location.reload();
                }
                );
           }


        }
        });  



  
}); 


}



function reject_leave_bulk() {

//  alert('Testing');

var forget_login_ids ='';

  $("input[type=checkbox]:checked").each ( function() {
  
   forget_login_ids +=  $(this).val() + ','; 

  // alert ( $(this).val() );
});


  // alert('Ids'+forget_login_ids);


swal({
title: "Are you sure?",
text: "Are you sure want to reject This",
type: "warning",
showCancelButton: true,
confirmButtonClass: "btn-danger",
confirmButtonText: "Yes, Reject it!",
closeOnConfirm: false
},
function(){

  var formValues = {id:forget_login_ids}

 $.ajax({
      type: "GET",
      url: "{{ asset('leave_rejectbulk/{id}') }}",
      data: formValues,
      cache: false,
      success: function(data){

         // alert(data);

         if(data==1) {
         
          swal({title: "Applied", text: "Leave Reject Successfully.", type: "success"},
              function(){ 
                  location.reload();
              }
              );
          
         }else {

          swal({title: "Try Again!", text: "Leave Reject Cancelled.", type: "info"},
              function(){ 
                  location.reload();
              }
              );
         }


      }
      });  




}); 


}


var url = window.location.href;
var projet_path = url.split('/');
var url_path = window.location.origin + '/' + projet_path[3];

/* withdraw leave feature */

function withdraw_leave(id,s_date,e_date) {
    

    swal({
      title: "Are you sure to withdraw this leave?",
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
           // url: "<?php //echo 'https://ise70.compuscript.ie/tms/public/withdrawleave'; ?>",
            url: url_path+"<?php echo '/public/withdrawleave'; ?>",
            data: formValues,
            cache: false,
            success: function(data){

               // alert(data);

               /*  alert(data);
                exit; */
    
               if(data==1) {
               
                swal({title: "success", text: "Your leave has been withdrawn.", type: "success"},
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