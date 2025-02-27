@extends('layouts.app')

@section('title', 'Department')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<?php 
use \App\Http\Controllers\UserController;
use App\Role;
use Illuminate\Support\Str;
?>





    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
        {!! Form::open(['method' => 'post', 'url' => 'department/insertdepartment']) !!}

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="roleModalLabel">Add Department</h4>
                </div>
                <div class="modal-body">
                    @include('department._form')
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
            <h3 class="modal-title"> {{ Str::plural('Department', count($department_List)) }} </h3>
            <?php //{{ count($department_List) }} ?>
        </div>
        <div class="col-md-7 page-action text-right">
            <a href="{{ asset('departmentlist') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
            @can('add_users')
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#roleModal"> <i class="glyphicon glyphicon-plus-sign"></i> Add Department</a>
            @endcan
        </div>
    </div>

    <div class="result-set">
        <table class="table">
            <thead class="tablehead">
            <tr>
                <th>S.No</th>
                <th>Email Id</th>
                <th>Status</th>
                <th>Created Date</th>
                @can('edit_departments', 'delete_departments')
                <th class="text-center">Actions</th>
                @endcan
            </tr>
            </thead>
            <tbody>
            <?php $i=1; $j=0; ?>
            @foreach($department_List as $item)
                <tr>
                    <td>{{ $i++ }}</td>
                    
                    <td>{{ $item->dept_name}}</td>
                    <td>{{ $item->dept_status}}</td>
                    <td><?php echo date('Y-m-d',strtotime($item->created_date)); ?></td>
                    @can('edit_departments', 'delete_departments')
                    <td>
                   <?php  $url = "department/".$item->dept_id."/edit";  ?>
                    <a href="{{ asset($url) }}" title='Edit' class="btn btn-xs btn-info"><i class="fa fa-pencil"></i>Edit</a>&nbsp;&nbsp;&nbsp;
                    <a  title='Delete' onclick="delete_leave('<?php echo $item->dept_id; ?>');"><button class="btn-delete btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></button></a>
                    </td>
                    @endcan
                </tr>
               
            @endforeach
            </tbody>
        </table>
     
    </div>
    
    
    <script>
 function delete_leave(id) {
    

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

    var formValues = {id:id}

   $.ajax({
        type: "GET",
        url: "{{ asset('deletedepartment/{id}') }}",
        data: formValues,
        cache: false,
        success: function(data){

           if(data==1) {
           
            swal({title: "Deleted", text: "Department has been deleted.", type: "success"},
                function(){ 
                    location.reload();
                }
                );
            
           }else {

            swal({title: "Try Again!", text: "Department has not been deleted.", type: "info"},
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