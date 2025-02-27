@extends('layouts.app')

@section('title', 'Holidays')

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
        {!! Form::open(['method' => 'post', 'url' => 'holiday/insertholiday']) !!}

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="roleModalLabel">Create Holiday</h4>
                </div>
                <div class="modal-body">
                    @include('holidays._form')
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
            <h3 class="modal-title">{{ count($holidays_list) }} {{ Str::plural('Holidays', count($holidays_list)) }} </h3>
        </div>
        <div class="col-md-7 page-action text-right">
            <a href="{{ asset('holidays') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
            @can('add_users')
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#roleModal"> <i class="glyphicon glyphicon-plus-sign"></i> Create Holiday</a>
            @endcan
        </div>
    </div>


    <div class="col-md-12" style="margin-top: 10px; margin-bottom: 20px; padding: 0;">
    {!! Form::open(['method' => 'post', 'url' => 'holidays/add/holiday']) !!}
            <div class="form-group col-md-5 @if ($errors->has('user_list')) has-error @endif" style="padding-left: 0;">
            {!! Form::label('holidayyear', 'Holiday Year') !!}
                <select name="holidayyear" class="form-control" required='required' id="holidayyear">
                    <option value="">--Select--</option>
                   <!--  <option value='2018'>2018</option>
                    <option value='2019'>2019</option> -->
                    <option value='2020'>2020</option>
                    <option value='2021'>2021</option>
                    <option value='2022'>2022</option>
                    <option value='2023'>2023</option>
                    <option value='2024'>2024</option>
                    <option value='2025'>2025</option>
                   
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
                <th>Holiday Name</th>
                <th>Date</th>
                <th>Remarks</th>
               
                @can('edit_holidays', 'delete_holidays')
                <th class="text-center">Actions</th>
                @endcan
            </tr>
            </thead>
            <tbody>
            <?php $i=1; $j=0; ?>
            @foreach($holidays_list as $item)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $item->holiday_type}}</td>
                    <td>{{ date('d - m - Y',strtotime($item->date)) }}</td>
                    <td>{{ $item->holiday_remarks }}</td>
                   <!--  <td class="text-center">
                        @can('edit_users')
                        @include('shared._actions', [
                            'entity' => 'users',
                            'id' => $item->id
                        ])
                        @endcan
                    </td> -->
                    @can('edit_holidays', 'delete_holidays')
                    <td>
                   <?php $url = "holidays/".$item->id."/edit"; ?>
                    <a href="{{ asset($url) }}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i>Edit</a>
                    <a href="javascript:void(0);" onclick="delete_holiday('<?php echo $item->id; ?>');" ><button class="btn-delete btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></button></a>
                    </td>
                    @endcan
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
 function delete_holiday(id) {
    

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
        url: "{{ asset('deleteholidays/{id}') }}",
        data: formValues,
        cache: false,
        success: function(data){

           if(data==1) {
           
            swal({title: "Deleted", text: "Your Holiday has been deleted.", type: "success"},
                function(){ 
                    location.reload();
                }
                );
            
           }else {

            swal({title: "Try Again!", text: "Your Holiday has not been deleted.", type: "info"},
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