@extends('layouts.app')

@section('title', 'Tickets')

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

        
        {!! Form::open(['method' => 'post', 'url' => 'tickets/inserttickets','enctype' => 'multipart/form-data']) !!}

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="roleModalLabel">Create Tickets</h4>
                </div>
                <div class="modal-body">
                    @include('tickets._form')
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
            <h3 class="modal-title">{{ count($holidays_list) }} {{ Str::plural('Tickets', count($holidays_list)) }} </h3>
        </div>
        <div class="col-md-7 page-action text-right">
            <a href="{{ asset('holidays') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
           
                <a href="#"  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#roleModal"> <i class="glyphicon glyphicon-plus-sign"></i> Create Ticket</a>
            
        </div>
    </div>


    <div class="col-md-12" style="margin-top: 10px; margin-bottom: 20px; padding: 0;">
    {!! Form::open(['method' => 'post', 'url' => 'tickets/add/ticket']) !!}
            <div class="form-group col-md-5 @if ($errors->has('user_list')) has-error @endif" style="padding-left: 0;">
            {!! Form::label('Request Type', 'Request Type') !!}
                <select name="holidayyear" class="form-control" required='required' id="holidayyear">
                    <option value="">--Select--</option>
                    <option value='TS'>Time Sheet</option>
                    <option value='H'>Holidays</option>
                    <option value='Tech'>Technical Support</option>
                    <option value='SI'>System Issue</option>
                    <option value='PI'>Personal Information</option>
                                      
                </select>
                </div>
            <div class="form-group col-md-1" style="margin-top: 24px;">
                {!! Form::submit('Submit', ['class' => 'btn btn-success pull-right']) !!}
            </div>
                
        </form>
    </div>





    <div class="result-set">
        <table class="table">
            <thead class="tablehead">
            <tr>
                <th>S.No</th>
                <th>Ticket Number</th>
                <th>Emp Id</th>
                <th>Ticket Type</th>
                <th>Remarks</th>
                <th>Req.Date</th>                
                <th>Status</th>
                
               
                <?php  if($user_id==1 || $user_id==60 || $user_id==84) { ?>
                <th class="text-center">Actions</th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php $i=1; $j=0; ?>
            <?php
           // echo '<pre>'; print_r($tickets_list);
            foreach($tickets_list as $item) { ?>
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $item->ticket_id}}</td>
                    <td>
                    
                    <?php $user_details = Role::getticket_userdetail($item->request_user);
                          print_r($user_details[0]->emp_id);

                                           ?>
                   
                    
                    
                    </td>
                    <td>                   
                    <?php if($item->request_type=='TS') { echo 'Time Sheet'; } elseif($item->request_type=='H') { echo "Holidays"; }elseif($item->request_type=='Tech') { echo "Technical Suport"; } elseif($item->request_type=='SI') { echo "Server Issue"; } elseif($item->request_type=='PI') { echo "Personal Information"; } ?>
                    
                    </td>
                    <td><label title='<?php echo $item->ticket_remarks; ?>'><?php echo substr($item->ticket_remarks, 0, 25); ?></label></td>
                    <td>{{ date('d - m - Y',strtotime($item->created_date)) }}</td>
                    <td>
                    
                    <?php //echo $item->ticket_status;
                    $txtcolor ='';
                    if($item->ticket_status=='Completed') {
                        $txtcolor ='green';
                    }elseif($item->ticket_status=='Waiting for reply'){
                        $txtcolor = 'red';
                    }elseif($item->ticket_status=='In Process'){
                        $txtcolor ='purple';
                    }elseif($item->ticket_status=='Hold'){
                        $txtcolor ='blue';
                    } else {
                        $txtcolor ='';
                    }
                    ?>

                    <span style='color:<?php echo $txtcolor; ?>'><?php echo $item->ticket_status; ?></span>

                    </td>
                   
                       <?php  if($user_id==1 || $user_id==60 || $user_id==84) { ?>
                    <td>
                   
                    <select id='assign_depart' name='assign_depart' onchange="compus_assign_department('<?php echo $item->id; ?>',this.value);">
                    <option>Choose</option>
                    <option value='Compuscript' <?php if($item->assign_to=='Compuscript') { echo 'selected'; } ?>>Compuscript</option>
                    <option value='Backend Support' <?php if($item->assign_to=='Backend Support') { echo 'selected'; } ?>>Backend Support</option>
                    </select> &nbsp;&nbsp;&nbsp;
                    <?php  $url = "tickets/".$item->id."/edit";  ?>
                    <a href="{{ asset($url) }}" title='Edit' class="btn btn-xs btn-info" title='Edit Ticket'><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;

                    <a href="javascript:void(0);" style='display:none;' onclick="delete_holiday('<?php echo $item->id; ?>');" title='Delete Ticket'><button class="btn-delete btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></button></a>

                    <?php if(!empty($item->file_attached)) { ?>
                    <a href="<?php echo $item->file_attached; ?>"><i class="fa fa-file-archive-o" aria-hidden="true"></i></a>
                    <?php } ?>

</td>
                    <?php } ?>
                </tr>
               
                        <?php } ?>
            </tbody>
        </table>
       @if(count($result)==20)                     
        <div class="text-center">
            {{ $result->links() }}
        </div>
        @endif
    </div>
    
 <script>





 
 function compus_assign_department(id,department) {
    
   // alert(id+department);

swal({
  title: "Are you sure?",
  text: "Are you sure want assign this department ?",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-danger",
  confirmButtonText: "Yes, Assign it!",
  closeOnConfirm: false
},
function(){

    var formValues = {id:id,department:department}

   $.ajax({
        type: "GET",
        url: "{{ asset('ticket_assign_department/{id}/{department}') }}",
        data: formValues,
        cache: false,
        success: function(data){

           if(data==1) {
           
            swal({title: "Deleted", text: "Assign Department has been Completed.", type: "success"},
                function(){ 
                    location.reload();
                }
                );
            
           }else {

            swal({title: "Try Again!", text: "Assign Department has not been Completed.", type: "info"},
                function(){ 
                    location.reload();
                }
                );
           }


        }
        });  



  
});





 }


/*------------------------------*/

function compus_assign_status(id,status) {
    
    // alert(id+department);
 
 swal({
   title: "Are you sure?",
   text: "Are you sure want Update the status ?",
   type: "warning",
   showCancelButton: true,
   confirmButtonClass: "btn-danger",
   confirmButtonText: "Yes, Assign it!",
   closeOnConfirm: false
 },
 function(){
 
     var formValues = {id:id,status:status}
 
    $.ajax({
         type: "GET",
         url: "{{ asset('compus_assign_status/{id}/{department}') }}",
         data: formValues,
         cache: false,
         success: function(data){
 
            if(data==1) {
            
             swal({title: "Deleted", text: "Status has been Updated.", type: "success"},
                 function(){ 
                     location.reload();
                 }
                 );
             
            }else {
 
             swal({title: "Try Again!", text: "Status has not been Updated.", type: "info"},
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