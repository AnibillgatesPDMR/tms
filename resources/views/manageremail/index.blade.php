@extends('layouts.app')

@section('title', 'Forget Login')

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


 





    <div class="row">
        <div class="col-md-5">
            <h3 class="modal-title">{{ count($mgr_emaillist) }} {{ Str::plural('Managers Email id', count($mgr_emaillist)) }} </h3>
        </div>
        <div class="col-md-7 page-action text-right">
            <a href="{{ asset('manageremail') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
            @can('add_users')
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#roleModal"> <i class="glyphicon glyphicon-plus-sign"></i> Add Time</a>
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
                @can('edit_users', 'delete_holidays')
                <th class="text-center">Actions</th>
                @endcan
            </tr>
            </thead>
            <tbody>
            <?php $i=1; $j=0; ?>
            @foreach($mgr_emaillist as $item)
                <tr>
                    <td>{{ $i++ }}</td>
                    
                    <td>{{ $item->group_emailids}}</td>
                    <td>{{ $item->emailid_status}}</td>
                  
                    <td>
                   <?php  $url = "manageremailid/".$item->gemail_id."/edit";  ?>
                    <a href="{{ asset($url) }}" title='Edit'><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                    <a  title='Delete' onclick="delete_mgremailid('<?php echo $item->gemail_id; ?>');"><i class="fa fa-times"></i></a>
                    </td>

                </tr>
               
            @endforeach
            </tbody>
        </table>
     
    </div>
    
    
 <script>
 
 function delete_mgremailid(mgr_emailid) {

     
    alert('In Process');



 }

 </script>

@endsection