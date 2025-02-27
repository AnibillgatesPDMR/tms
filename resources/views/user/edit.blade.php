@extends('layouts.app')

@section('title', 'Edit User ' . $user->first_name)

@section('content')

<style>

 .circle {
          border-radius: 1000px !important;
          overflow: hidden;
          width: 128px;
          height: 128px;
          border: 8px solid rgba(255, 255, 255, 0.7);
          position: absolute;
          left: 440px !important;
          top : -60px;
          
      }
</style>

    <div class="row">
        <div class="col-md-5">
            <h3>Edit {{ $user->first_name }}</h3>
        </div>
        <div class="col-md-7 page-action text-right">
            <a href="{{ asset('users/add/user') }}" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        {!! Form::model($user, ['method' => 'PUT','route' => ['users.update',  $user->id ] , 'enctype' => 'multipart/form-data']) !!}
                            @include('user._form')
                            <!-- Submit Form Button -->
                            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection