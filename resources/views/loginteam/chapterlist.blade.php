@extends('layouts.app')

@section('title', 'Journals')

@section('content')
<?php 
use Illuminate\Support\Str;
?>
        <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['method' => 'post', 'url' => 'chapter/upload', 'enctype' => 'multipart/form-data']) !!}

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="roleModalLabel">Clients</h4>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6 @if ($errors->has('client')) has-error @endif">
                            {!! Form::label('client', 'Client') !!}
                            <select name="client" class="form-control" required='required' id="client">
                            	<option value="">--Select--</option>
                            	@foreach($clients as $client)
                            	<option value="{{$client->id}}">{{$client->client_name}}</option>
                            	@endforeach
                            </select>
                            @if ($errors->has('client')) <p class="help-block">{{ $errors->first('client') }}</p> @endif
                        </div>
                        <div class="form-group col-md-6 @if ($errors->has('journal')) has-error @endif">
                            {!! Form::label('journal', 'Journal') !!}
                            <select name="journal" class="form-control" required='required' id="journal">
                                <option value="">--Select--</option>
                            </select>
                            @if ($errors->has('journal')) <p class="help-block">{{ $errors->first('journal') }}</p> @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12 @if ($errors->has('chapter')) has-error @endif">
                            {!! Form::label('chapter', 'Chapter') !!}
                            <select name="chapter" class="form-control" required='required' id="chapter">
                                <option value="">--Select--</option>
                            </select>
                            @if ($errors->has('chapter')) <p class="help-block">{{ $errors->first('chapter') }}</p> @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 @if ($errors->has('chapter')) has-error @endif">
                            {!! Form::label('redatepicker', 'Customer Received Date') !!}
                            <div class="input-group col-md-12 date">
                                <input type="text" class="form-control pull-right" name="custrev" id="redatepicker" required="required">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6 @if ($errors->has('custacc')) has-error @endif">
                            {!! Form::label('accdatepicker', 'Accepted Date') !!}
                            <div class="input-group col-md-12 date">
                                <input type="text" name="custacc" class="form-control pull-right" id="accdatepicker" required="required">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            @if ($errors->has('custacc')) <p class="help-block">{{ $errors->first('custacc') }}</p> @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 @if ($errors->has('msword')) has-error @endif">
                            {!! Form::label('msword', 'MS Word Page') !!}
                            {!! Form::text('msword', null, ['class' => 'form-control', 'placeholder' => 'MS Word Page', 'required' => 'required']) !!}
                            @if ($errors->has('msword')) <p class="help-block">{{ $errors->first('msword') }}</p> @endif
                        </div>
                        <div class="form-group col-md-6 @if ($errors->has('noofta')) has-error @endif">
                            {!! Form::label('noofta', 'No of Table') !!}
                            {!! Form::text('noofta', null, ['class' => 'form-control', 'placeholder' => 'No of Table', 'required' => 'required']) !!}
                            @if ($errors->has('noofta')) <p class="help-block">{{ $errors->first('noofta') }}</p> @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 @if ($errors->has('nooffig')) has-error @endif">
                            {!! Form::label('nooffig', 'No of Figure') !!}
                            {!! Form::text('nooffig', null, ['class' => 'form-control', 'placeholder' => 'No of Figure', 'required' => 'required']) !!}
                            @if ($errors->has('nooffig')) <p class="help-block">{{ $errors->first('nooffig') }}</p> @endif
                        </div>
                        <div class="form-group col-md-6 @if ($errors->has('doi')) has-error @endif">
                            {!! Form::label('doi', 'DOI') !!}
                            {!! Form::text('doi', null, ['class' => 'form-control', 'placeholder' => 'Client Name', 'required' => 'required']) !!}
                            @if ($errors->has('doi')) <p class="help-block">{{ $errors->first('doi') }}</p> @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12 @if ($errors->has('query')) has-error @endif">
                            {!! Form::label('query', 'Query') !!}
                            <textarea name="query" placeholder="Query" class="form-control"></textarea>
                            @if ($errors->has('query')) <p class="help-block">{{ $errors->first('query') }}</p> @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 @if ($errors->has('articlestage')) has-error @endif">
                            {!! Form::label('articlestage', 'Article Stage') !!}
                            <select name="articlestage" class="form-control" required='required' id="articlestage">
                                <option value="">--Select--</option>
                                @foreach($stages as $stage)
                                <option value="{{$stage->id}}">{{$stage->stage}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('articlestage')) <p class="help-block">{{ $errors->first('articlestage') }}</p> @endif
                        </div>
                        <div class="form-group col-md-6 @if ($errors->has('articlesubstage')) has-error @endif">
                            {!! Form::label('articlesubstage', 'Article Sub Stage') !!}
                            <select name="articlesubstage" class="form-control" required='required' id="articlesubstage">
                                <option value="">--Select--</option>
                            </select>
                            @if ($errors->has('articlesubstage')) <p class="help-block">{{ $errors->first('articlesubstage') }}</p> @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12 @if ($errors->has('file')) has-error @endif">
                            {!! Form::label('file', 'Files Upload') !!}
                            <input type="file" id="file" class="form-control" name="file">
                            @if ($errors->has('file')) <p class="help-block">{{ $errors->first('file') }}</p> @endif
                        </div>
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
        <div class="col-md-11">
            <h3 class="modal-title"><i class="fa fa-folder"></i> {{$clientData->client_name}} / {{$journalData->journal_name}} / {{$bookData->book_name}} / {{ Str::plural('Chapters', $clients->count()) }} </h3>
        </div>
        <?php $url = request()->segments(); ?>
        <div class="col-md-1 page-action text-right">
        	<a href="{{ asset('login/book/list') }}/{{$url[3]}}/{{$url[4]}}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
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
                            <input type="text" name="duedate" class="form-control pull-right" id="duedate" required="required">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                        @if ($errors->has('duedate')) <p class="help-block">{{ $errors->first('duedate') }}</p> @endif
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
        <table class="table">
            <thead class="tablehead">
            <tr>
                <th>Id</th>
                <th>Type</th>
                <th>Chapter Name</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Action</th>
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
                    <td><a href="{{ asset('login/stage/list') }}/{{$url[3]}}/{{$url[4]}}/{{ last(request()->segments()) }}/{{$item->id}}" class="btn btn-xs btn-success">View </a> <?php if ($item->is_assigned) { ?> <a href="#" class="btn btn-xs btn-danger">Assigned</a><?php } else { ?><!-- | <a href="#" data-journal = "{{$item->id}}" data-toggle="modal" data-target="#roleModal{{$item->id}}"> Assign to</a> --><?php } ?></td>
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