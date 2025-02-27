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


 
    <div style='padding:30px;border:1px solid #000;margin-bottom:15px;'>
    <h5 style='font-weight:bold;'>Search Filter</h5>
    <form method="post" action="{{ asset('trackingsearch') }}">
    
    From Date :
    <input type="text"  id="from_date" name="from_date" autocomplete='Off' />
    To Date : 
    <input type="text"  id="to_date" name="to_date" autocomplete='Off' />
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="submit" class="btn btn-success" value="Search" />
    </form>
    </div>
  



    <div class="row">
        <div class="col-md-5">
            <h3 class="modal-title">{{ count($tracking_hours_list) }} {{ Str::plural('Tracking Hour', count($tracking_hours_list)) }}  </h3>
        </div>
        
    </div>

    <div class="result-set">
        <table class="table">
            <thead class="tablehead">
            <tr>
                <th>S.No</th>
                
                <th>Emp Id</th>
                <th>Employee Name</th>
                <th>Date</th>
                <th>In Time</th>
                <th>Out Time</th>
              
                
            </tr>
            </thead>
            <tbody>
            <?php 
             
            $i=1; $j=0; ?>
            @foreach($tracking_hours_list as $item)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $item->emp_id }}</td>
                    <td>{{ $item->name }}</td>   
                    <td>{{ date('d-m-Y',strtotime($item->loged_in_at)) }}</td>                 
                    <td>{{ date('G:i',strtotime($item->loged_in_at)) }}</td>
                    <td>{{ date('G:i',strtotime($item->loged_out_at)) }}</td>



                   
                  
                    
                    <?php 


                  /* 
                   <td>{{ date('h:i A',strtotime($item->loged_in_at)) }}</td>
                    <td>{{ date('h:i A',strtotime($item->loged_out_at)) }}</td>
                  
                  $seconds = strtotime($item->loged_out_at) - strtotime($item->loged_in_at);

                    $days    = floor($seconds / 86400);
                    $hours   = floor(($seconds - ($days * 86400)) / 3600);
                    $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
                    $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));

                    echo $hours.":".$minutes.":".$seconds; */
                    ?>
                    

                    
                </tr>
               
            @endforeach
            </tbody>
        </table>
     
    </div>
    
    <!-- Jquery date picker Code Start -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {

  $( "#from_date" ).datepicker({

        autoclose: true,
        format: 'dd/mm/yyyy'
    });
 
    $( "#to_date" ).datepicker({
        
        format: 'dd/mm/yyyy',
        autoclose: true
});




  } );
  </script>
<!-- Jquery date picker Code End -->
 

@endsection