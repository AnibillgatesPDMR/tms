@extends('layouts.app')

@section('title', 'Journals')

@section('content')
<?php 
use Illuminate\Support\Str;
?>
    <div class="row">
        <div class="col-md-11">
            <h3 class="modal-title"><i class="fa fa-folder"></i> {{ Str::plural('Chapters', $chapter->count()) }} </h3>
        </div>
        <?php $url = request()->segments(); ?>
        <div class="col-md-1 page-action text-right">
        	<a href="{{ asset('graphice/jobs/list') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>

    @foreach($chapter as $item)
    <div class="modal fade" id="roleModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['method' => 'post', 'url' => 'user/assign']) !!}

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
                            @foreach($ceusers as $ceuser)
                            <option value="{{$ceuser->id}}">{{$ceuser->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('assignto')) <p class="help-block">{{ $errors->first('assignto') }}</p> @endif
                        <input type="hidden" name="chapterid" value="{{$item->id}}">
                    </div>
                    <div class="form-group @if ($errors->has('duedate')) has-error @endif">
                        {!! Form::label('duedate', 'Due Date') !!}
                        <div class="input-group col-md-12 date">
                            <input type="text" name="duedate" class="form-control pull-right" id="graphiceduedate" required="required">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                        @if ($errors->has('duedate')) <p class="help-block">{{ $errors->first('duedate') }}</p> @endif
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
                <th>Chapter Name</th>
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
            @foreach($chapter as $item)
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>{{ $item->type }}</td>
                    <td><i class="fa fa-folder"></i> {{ $item->chapter_name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td><!-- <a href="{{ asset('login/stage/list') }}/{{ last(request()->segments()) }}/{{$item->id}}">View</a> | --> <?php if ($item->is_assigned == '0') { ?> <a href="#" data-journal = "{{$item->id}}" data-toggle="modal" data-target="#roleModal{{$item->id}}"> Assign to</a> <?php } else { echo "<a href='#' class='btn btn-danger btn-xs'>Assigned"; }?></td>
                </tr>
            <?php $i++; ?>
            @endforeach
            </tbody>
        </table>

        <div class="text-center">
            {{ $chapter->links() }}
        </div>
    </div>
@endsection