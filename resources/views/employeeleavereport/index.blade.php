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
        buttons: [
            'copyHtml5',
            'excelHtml5',            
            'pdfHtml5'
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


 
    <div style='padding:30px;border:1px solid #000;margin-bottom:20px;'>
    <h5 style='font-weight:bold;'>Search Filter</h5>
    <form method="post" action="{{ asset('emplleavereports') }}">
    Emp Name :
    <select id="emp_name" name='emp_name' style='width:20%;height:25px;'>
    <option value="">ALL</option>
    <?php foreach($user_list as $users) { ?>
    <option value="<?php echo $users->id; ?>"><?php echo ucfirst($users->name); ?></option>
    <?php } ?>
    </select>
   &nbsp; &nbsp; &nbsp; &nbsp; From Date :
    <input type="text" id="from_date" name="from_date" />
    &nbsp; &nbsp; &nbsp; &nbsp; To Date : 
    <input type="text" id="to_date" name="to_date" />
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="submit" value="Search" />
    </form>
    </div>
  



    <div class="row">
        <div class="col-md-5">
            <h3 class="modal-title">{{ Str::plural('Users Working Hour', count($leave_list)) }} </h3>
        </div>
        
    </div>
    <hr />
    
    <div class="result-set">
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr style='font-size:15px !important;'>
                <th>S.No</th>
                <th>Emp Id</th>
                <th>Employee Name</th>                
                <th>Leave From</th>
                <th>Leave To</th>
                <th>No of Days</th>
                <th>Reason</th>
                <th>Status</th>               
               
            </tr>
        </thead>
        <tbody>
        
        <?php $i=1; foreach($leave_list as $list) { ?>

         <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $list->emp_id; ?></td>
                <td><?php echo $list->name; ?></td>                
                <td><?php echo $list->from_date; ?></td>
                <td><?php echo $list->to_date; ?></td>
                <td><?php echo $list->no_ofdays; ?></td>
                <td><?php echo $list->remarks; ?></td>
                <td><?php echo $list->leave_status; ?></td>               
               
            </tr>
       
        <?php $i++; } ?>   
           
        </tbody>
        <tfoot>
        <tr style='font-size:15px !important;'>
                <th>S.No</th>
                <th>Employee Name</th>                
                <th>Leave From</th>
                <th>Leave To</th>
                <th>No of Days</th>
                <th>Reason</th>
                <th>Status</th>               
               
            </tr>

        </tfoot>
    </table>
    
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