@extends('layouts.app')

@section('title', 'Book')

@section('content')
<?php 
use Illuminate\Support\Str;
?>
        <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['method' => 'post', 'url' => 'book/create']) !!}

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="roleModalLabel">Book</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group @if ($errors->has('type')) has-error @endif">
                        {{ csrf_field() }}
                        {!! Form::label('type', 'Type') !!}
                        <select name="type" class="form-control" required='required' id="type">
                            <option value="">--Select--</option>
                            @foreach($types as $type)
                            <option value="{{$type->id}}">{{$type->type}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('type')) <p class="help-block">{{ $errors->first('type') }}</p> @endif
                    </div>
                    <div class="form-group @if ($errors->has('client')) has-error @endif">
                        {!! Form::label('client', 'Client') !!}
                        <select name="client" class="form-control" required='required' id="client">
                        	<option value="">--Select--</option>
                        </select>
                        @if ($errors->has('client')) <p class="help-block">{{ $errors->first('client') }}</p> @endif
                    </div>
                    <div class="form-group @if ($errors->has('journal')) has-error @endif">
                        {!! Form::label('journal', 'Journal') !!}
                        <select name="journal" class="form-control" required='required' id="journal">
                            <option value="">--Select--</option>
                        </select>
                        @if ($errors->has('journal')) <p class="help-block">{{ $errors->first('journal') }}</p> @endif
                    </div>
                    <div class="form-group @if ($errors->has('book')) has-error @endif">
                        {!! Form::label('book', 'Book Name/ISBN Number') !!}
                        {!! Form::text('book', null, ['class' => 'form-control', 'placeholder' => 'Book Name/ISBN Number', 'required' => 'required', 'id' => 'bookname']) !!}
                        @if ($errors->has('book')) <p class="help-block">{{ $errors->first('book') }}</p> @endif
                        <p id="error" class="help-block" style="display: none;color: red;">Book name already exist.</p>
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
            <h3 class="modal-title">{{ Str::plural('Books', $result->count()) }} </h3>
        </div>

        <div class="col-md-7 page-action text-right">
        	<a href="{{ asset('login/home/dashboard') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
            @can('add_clients')
                <a href="#" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#roleModal"> <i class="glyphicon glyphicon-plus"></i> Add Book Name</a>
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
                <th>Book Name/ISBN Number</th>
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
                    <td>{{ $item->book_name }}</td>
                    <td>{{ $item->name }}</td>
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