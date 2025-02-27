@extends('layouts.app')

@section('title', 'Edit Holidays ')

@section('content')

    <div class="row">
        <div class="col-md-5">
            <h3>Change Password</h3>
        </div>
        <div class="col-md-7 page-action text-right">
            <a href="{{ asset('holidays/add/holiday') }} " class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
           

             {!! Form::open(['method' => 'post', 'url' => 'update_password','onsubmit' => 'return password_validation()']) !!}


                <div class="form-group @if ($errors->has('holidaydate')) has-error @endif">
                    {!! Form::label('holidaydate', 'Change Password') !!}
                    <br />
                    <input type="text" id="password" name="password" style='width:100%;height:40px;'  />

                   


                   
                </div>



                 <div class="form-group @if ($errors->has('holidaydate')) has-error @endif">
                    {!! Form::label('holidaydate', 'Confirm Password') !!}
                    <br />
                    <input type="text" id="confirmpassword" name="confirmpassword" style='width:100%;height:40px;' />

                   


                   
                </div>


            <input class="btn btn-success userform" value="Update" type="submit">



{!! Form::close() !!}













            </div>
        </div>
    </div>

    <script>
    
    function password_validation() {
        var pwd = $('#password').val();
        var cpwd =$('#confirmpassword').val();
        
      
        if(pwd=='' || cpwd=='') {
            alert('Password and Confirm Password cannot be empty');
            return false;
        } 

        if(pwd!=cpwd) {
            alert('Password Does not Match');
            return false;
        } else{
            return true;
        }

    }

    </script>

@endsection