@extends('layouts.app')

@section('title', 'Book')

@section('content')
<?php 
use Illuminate\Support\Str;
?>
    <div class="row">
        <div class="col-md-5">
            <h3 class="modal-title"><i class="fa fa-folder"></i> {{ Str::plural('Books', $jobs->count()) }} </h3>
        </div>

        <div class="col-md-7 page-action text-right">
        	<a href="{{ asset('epub/home/dashboard') }}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
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
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1; ?>
            @foreach($jobs as $item)
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->client_name }}</td>
                    <td>{{ $item->journal_name }}</td>
                    <td>{{ $item->book_name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td><a class="btn btn-xs btn-success" href="{{ asset('epub/jobs/chapter') }}/{{$item->id}}">View</a></td>
                </tr>
            <?php $i++; ?>
            @endforeach
            </tbody>
        </table>

        <div class="text-center">
            {{ $jobs->links() }}
        </div>
    </div>

@endsection