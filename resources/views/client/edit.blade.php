@extends('layouts.app')

@section('title', 'Edit Journal ' . $journal->journal_name)

@section('content')

    <div class="row">
        <div class="col-md-5">
            <h3>Edit {{ $journal->journal_name }}</h3>
        </div>
        <div class="col-md-7 page-action text-right">
            <a href="clients/journal" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
    <?php //echo getcwd(); ?>
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        {!! Form::open(['method' => 'post', 'url' => 'journal/update']) !!}
                            <div class="form-group @if ($errors->has('name')) has-error @endif">
                                {!! Form::label('client', 'Client') !!}
                                <select name="client" class="form-control">
                                    <option value="">--Select--</option>
                                    @foreach($clients as $client)
                                    <option value="{{$client->id}}" <?php if ($client->id == $journal->client_id) { echo "selected"; } ?>>{{$client->client_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('client')) <p class="help-block">{{ $errors->first('client') }}</p> @endif
                            </div>
                            <div class="form-group @if ($errors->has('name')) has-error @endif">
                                {!! Form::label('name', 'Journal Name') !!}
                                <input type="text" name="name" class="form-control" value="{{$journal->journal_name}}" placeholder="Journal Name">
                                <input type="hidden" name="journalId" value="{{$journal->id}}"> 
                                @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                            </div>
                            <!-- Submit Form Button -->
                            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection