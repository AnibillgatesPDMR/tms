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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    <!-- Submit Form Button -->
                    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-11">
            <h3 class="modal-title"><i class="fa fa-folder"></i> {{$clientData->client_name}} / {{$journalData->journal_name}} / {{$bookData->book_name}} / {{$chapterData->chapter_name}} / {{ Str::plural('Stages', $clients->count()) }} </h3>
        </div>
        <?php $url = request()->segments(); ?>
        <div class="col-md-1 page-action text-right">
        	<a href="{{ asset('login/chapter/list') }}/{{$url[3]}}/{{$url[4]}}/{{$url[5]}}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
            @can('add_clients')
<!--                 <a href="#" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#roleModal"> <i class="glyphicon glyphicon-plus"></i> New</a> -->
            @endcan
        </div>
    </div>
    
    <div class="result-set">
        <table class="table">
            <thead class="tablehead">
            <tr>
                <th>Id</th>
                <th>Stage</th>
                <th>Sub Stage</th>
                <th>Created At</th>
                <th>Action</th>
                @can('edit_clients', 'delete_clients')
                <!-- <th class="text-center">Actions</th> -->
                @endcan
            </tr>
            </thead>
            <tbody>
            <?php $i = 1; ?>
            @foreach($articleStage as $item)
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><i class="fa fa-folder"></i> {{ $item->stage }}</td>
                    <td><i class="fa fa-folder"></i> {{ $item->sub_stage }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td><a href="{{ asset('login/file/list') }}/{{$url[3]}}/{{$url[4]}}/{{$url[5]}}/{{ last(request()->segments()) }}/{{$item->id}}" class="btn btn-xs btn-success">View</a></td>
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
            {{ $articleStage->links() }}
        </div>
    </div>
@endsection