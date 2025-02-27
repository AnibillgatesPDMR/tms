@extends('layouts.app')

@section('title', 'Books')

@section('content')
<?php 
use Illuminate\Support\Str;
?>
    <div class="row">
        <div class="col-md-5">
            <h3 class="modal-title"><i class="fa fa-folder"></i> {{$clientData->client_name}} / {{$journalData->journal_name}} / {{ Str::plural('Books', $clients->count()) }} </h3>
        </div>
        <?php $url = request()->segments(); ?>
        <div class="col-md-7 page-action text-right">
        	<a href="{{ asset('login/journal/list') }}/{{$url[3]}}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
    @foreach($book as $item)
    <div class="modal fade" id="roleModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['method' => 'post', 'url' => 'book/assign']) !!}

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
                            @foreach($teamStages as $teamStage)
                            <option value="{{$teamStage->id}}">{{$teamStage->stage}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('assignto')) <p class="help-block">{{ $errors->first('assignto') }}</p> @endif
                        <input type="hidden" name="bookid" value="{{$item->id}}">
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
    @endforeach
    <div class="result-set">
        <table class="table">
            <thead class="tablehead">
            <tr>
                <th>Id</th>
                <th>Type</th>
                <th>Book Name</th>
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
            @foreach($book as $item)
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>{{ $item->type }}</td>
                    <td><i class="fa fa-folder"></i> {{ $item->book_name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td><a href="{{ asset('login/chapter/list') }}/{{ $url[3] }}/{{ last(request()->segments()) }}/{{$item->id}}" class="btn btn-xs btn-success">View </a> <?php if ($item->assign_to == 0) { ?> <a href="#" data-journal = "{{$item->id}}" data-toggle="modal" data-target="#roleModal{{$item->id}}"> Assign to</a><?php } else { ?><a href="#" class="btn btn-xs btn-danger">Assigned</a><?php } ?></td>
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
            {{ $book->links() }}
        </div>
    </div>
@endsection