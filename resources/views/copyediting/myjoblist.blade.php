@extends('layouts.app')

@section('title', 'Journals')

@section('content')
<?php 
use Illuminate\Support\Str;
?>
    <div class="row">
        <div class="col-md-11">
            <h3 class="modal-title"><i class="fa fa-folder"></i> {{ Str::plural('My Jobs', $myjobs->count()) }} </h3>
        </div>
        <?php $url = request()->segments(); ?>
        <div class="col-md-1 page-action text-right">
        	<a href="{{ asset('copy/home/dashboard') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
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
                <th>Book Name</th>
                <th>Chapter Name</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Due Date</th>
                <th>Job Type</th>
                <th>Queries</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1; ?>
            @foreach($myjobs as $item)
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->client_name }}</td>
                    <td>{{ $item->journal_name }}</td>
                    <td>{{ $item->book_name }}</td>
                    <td>{{ $item->chapter_name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->due_date }}</td>
                    <td style='color:{{$item->color_code}};'>{{ $item->job_type }}</td>
                    <td title="{{$item->queries}}" style="cursor:pointer;">{{ str_limit ($item->queries, $limit = 15, $end = '...') }} </td>
                    <td><a class="btn btn-xs btn-success" href="{{ asset('copy/stage/list') }}/{{$item->id}}">View</a></td>
                </tr>
            <?php $i++; ?>
            @endforeach
            </tbody>
        </table>

        <div class="text-center">
            {{ $myjobs->links() }}
        </div>
    </div>
@endsection