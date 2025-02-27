@extends('layouts.app')

@section('title', 'Journals')

@section('content')
<?php 
use Illuminate\Support\Str;
?>
    <div class="row">
        <div class="col-md-11">
            <h3 class="modal-title"><i class="fa fa-folder"></i> {{ Str::plural('Stages', $articleStage->count()) }} </h3>
        </div>
        <?php $url = request()->segments(); ?>
        <div class="col-md-1 page-action text-right">
        	<a href="{{ asset('file/myjobs/list') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
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
                    <td><a class="btn btn-xs btn-success" href="{{ asset('file/file/list') }}/{{ last(request()->segments()) }}/{{$item->id}}">View</a></td>
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