@extends('layouts.app')

@section('title', 'Forget Login')

@section('content')
<?php 
use \App\Http\Controllers\UserController;
use App\Role;
use Illuminate\Support\Str;
?>




    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
        {!! Form::open(['method' => 'post', 'url' => 'forgetlogin/insertforgetlogin']) !!}

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="roleModalLabel">Add Time</h4>
                </div>
                <div class="modal-body">
                    @include('forgetlogin._form')
                    <input type="hidden" name="created_by" value="{{Auth::user()->id}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

                    <!-- Submit Form Button -->
                    {!! Form::submit('Submit', ['class' => 'btn btn-success userform']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


 





    <div class="row">
        <div class="col-md-5">
            <h3 class="modal-title">{{ count($forget_login_list) }} {{ Str::plural('Forgot Login (this month)', count($forget_login_list)) }}</h3> <span style='color:red;font-weight:bold;'>At least choose one</span>
        </div>
        <div class="col-md-7 page-action text-right">
            
            @can('add_forget_login')
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#roleModal"> <i class="glyphicon glyphicon-plus-sign"></i> Add Time</a>
            @endcan

            <?php if($role=='17') { ?>
            <a href="javascript:void(0);" onclick='forget_login_accept();' class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i>Accept</a>     
            <?php } ?>        

        </div>
    </div>

    <div class="result-set">
        <table class="table">
            <thead class="tablehead">
            <tr>
                <th></th>
                <th>S.No</th>
                <th>Emp Id</th>
                <th>Emp Name</th>
                <th>From Time</th>
                <th>To Time</th>
                <th>Date</th>
                <th>Reason <?php echo $role; ?></th>
                <th>Status</th>
  

            </tr>
            </thead>
            <tbody>
            <?php $i=1; $j=0; ?>
            @foreach($forget_login_list as $item)
                <tr>
                    <td><input type='checkbox' name='accpet_list[]' id='<?php echo $item->fid; ?>' value='<?php echo $item->fid; ?>' /></td>
                    <td>{{ $i++ }}</td>
                    <td>{{ $item->emp_id}}</td>
                    <td>{{ $item->name}}</td>
                    <!--<td>{{ date('g:i A', strtotime($item->from_time)) }}</td>
                    <td>{{ date('g:i A', strtotime($item->to_time)) }}</td> 
                     <td>{{ date('H:i A', strtotime($item->from_time)) }}</td>
                    <td>{{ date('H:i A', strtotime($item->to_time)) }}</td>
                    
                    -->
                    <td>{{ date('G:i', strtotime($item->from_time)) }}</td>
                    <td>{{ date('G:i', strtotime($item->to_time)) }}</td>
                    <td>{{ $item->forget_date}}</td>
                    <td>{{ $item->forget_reason}}</td>
                    <td>
                    <?php if($item->forget_login_status=='Approved') { ?>

                    <span style='color:green;'>{{ $item->forget_login_status}}</span>
                    <?php } else if($item->forget_login_status=='Rejected') { ?>
                    <span style='color:red;'>{{ $item->forget_login_status}}</span>
                    <?php } else { ?>
                        <span style='color:red;'>Pending</span>   
                    <?php } ?>
                    
                    </td>
                  
                  
                   
                  
                 
                </tr>
               
            @endforeach
            </tbody>
        </table>
     
    </div>
    
 

@endsection

<script>

function forget_login_accept() {

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
        url: "{{ asset('forgetlogin_accept/{id}') }}",
        data: formValues,
        cache: false,
        success: function(data){

           // alert(data);

           if(data==1) {
           
            swal({title: "Applied", text: "Forget Login Applied Successfully.", type: "success"},
                function(){ 
                    location.reload();
                }
                );
            
           }else {

            swal({title: "Try Again!", text: "Forget Login Cancelled.", type: "info"},
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