@extends('layouts.app')

@section('title', 'Clients')

@section('content')
<?php 
use Illuminate\Support\Str;
?>
        <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['method' => 'post', 'url' => 'journal/create']) !!}

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="roleModalLabel">Journal</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group @if ($errors->has('type')) has-error @endif">
                        {!! Form::label('type', 'Type') !!}
                        <select name="type" class="form-control" id="type" required='required'>
                            <option value="">--Select--</option>
                            @foreach($types as $type)
                            <option value="{{$type->id}}">{{$type->type}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('type')) <p class="help-block">{{ $errors->first('type') }}</p> @endif
                    </div>
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        {!! Form::label('client', 'Client') !!}
                        <select name="client" id="client" class="form-control" required='required'>
                        	<option value="">--Select--</option>
                        </select>
                        @if ($errors->has('client')) <p class="help-block">{{ $errors->first('client') }}</p> @endif
                    </div>
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        {!! Form::label('name', 'Journal Name') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Journal Name', 'required' => 'required', 'id' => 'journalname']) !!}
                        @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                        <p id="error" class="help-block" style="display: none;color: red;">Journal name already exist.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                    <!-- Submit Form Button -->
                    {!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <h3 class="modal-title">{{ count($result) }} {{ Str::plural('Journal', $result->count()) }} </h3>
        </div>

        <div class="col-md-7 page-action text-right">
        	<a href="{{ asset('clients/home/dashboard') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
            @can('add_clients')
                <a href="#" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#roleModal"> <i class="glyphicon glyphicon-plus"></i> Add Journal</a>
            @endcan
        </div>
    </div>

    <div class="result-set">
        <table class="table">
            <thead class="tablehead">
            <tr>
                <th>Id</th>
                <th>Type</th>
                <th>Client Name</th>
                <th>Journal Name</th>
                <th>Created By</th>
                <th>Created At</th>
                @can('edit_clients', 'delete_clients')
                <!-- <th class="text-center">Actions</th> -->
                @endcan
            </tr>
            </thead>
            <tbody>
            <?php $i = 1; ?>
            @foreach($result as $item)
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->client_name }}</td>
                    <td>{{ $item->journal_name }}</td>
                    <td>{{ $item->name}}</td>
                    <td>{{ $item->created_at }}</td>
					@can('edit_clients')
                    <!-- <td class="text-center">
                        <a href="journal/edit/{{$item->id}}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
        				<a href="journal/delete/{{$item->id}}">
					        <button type="submit" class="btn-delete btn btn-xs btn-danger">
					            <i class="glyphicon glyphicon-trash"></i>
					        </button>
					    </a>
                    </td> -->
                    @endcan
                </tr>
            <?php $i++; ?>
            @endforeach
            </tbody>
        </table>

        <div class="text-center">
            {{ $result->links() }}
        </div>
    </div>

@endsection