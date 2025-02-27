@extends('layouts.app')

@section('title', 'Journals')

@section('content')
<?php 
use Illuminate\Support\Str;
?>
<div class="row">
    <div class="col-md-5">
        <h3 class="modal-title"><i class="fa fa-folder"></i> {{$clientData->client_name}} / {{ Str::plural('Journals', $clients->count()) }} </h3>
    </div>

    <div class="col-md-7 page-action text-right">
    	<a href="{{ asset('login/client/list') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
    </div>
</div>

@foreach($journal as $item)
<div class="modal fade" id="roleModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
    <div class="modal-dialog" role="document">
        {!! Form::open(['method' => 'post', 'url' => 'journal/create']) !!}

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="roleModalLabel">Assign to</h4>
            </div>
            <div class="modal-body">
                <div class="form-group @if ($errors->has('assignto')) has-error @endif">
                    {!! Form::label('assignto', 'Assign to') !!}
                    <select name="assignto" class="form-control" id="assignto" required='required'>
                        <option value="">--Select--</option>
                    </select>
                    @if ($errors->has('assignto')) <p class="help-block">{{ $errors->first('assignto') }}</p> @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                <!-- Submit Form Button -->
                {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endforeach

<div class="result-set">
    <table class="table" id="data-table">
        <thead class="tablehead">
        <tr>
            <th>Id</th>
            <th>Type</th>
            <th>Journal Name</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Action</th>
            @can('edit_clients', 'delete_clients')
            <!-- <th class="text-center">Actions</th> -->
            @endcan
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        @foreach($journal as $item)
            <tr>
                <td><?php echo $i; ?></td>
                <td>{{ $item->type }}</td>
                <td><i class="fa fa-folder"></i> {{ $item->journal_name }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->created_at }}</td>
                <td><a href="{{ asset('login/book/list') }}/{{ last(request()->segments()) }}/{{$item->id}}" class="btn btn-xs btn-success">View</a></td>
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
        {{ $journal->links() }}
    </div>
</div>
@endsection