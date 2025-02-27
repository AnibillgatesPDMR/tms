@extends('layouts.app')

@section('title', 'Edit Holidays ')

@section('content')

    <div class="row">
        <div class="col-md-5">
            <h3>Edit</h3>
        </div>
        <div class="col-md-7 page-action text-right">
            <a href="{{ asset('department/add/department') }} " class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                    {!! Form::open(['method' => 'post', 'url' => 'department/insertdepartment']) !!}
                            @include('department._form')
                            <!-- Submit Form Button -->
                            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection