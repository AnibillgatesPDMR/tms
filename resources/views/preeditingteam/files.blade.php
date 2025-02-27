@extends('layouts.app')

@section('title', 'Files')

@section('content')
    <div class="row">
        <div class="col-md-11">
            <h3 class="modal-title"><i class="fa fa-folder"></i> Files</h3>
        </div>
        <?php $url = request()->segments(); ?>
        <div class="col-md-1 page-action text-right">
        	<a href="{{ asset('pre/stage/list') }}/{{$url[3]}}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
    
    <div class="result-set">
        <table class="table">
            <thead class="tablehead">
            <tr>
                <th>Id</th>
                <th>File Name</th>
                <th>Created At</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1; ?>
            @foreach($articleStage as $item)
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>{{ $item->file_name }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td><a href="#" class="btn btn-xs btn-success">File Open</a> <a href="#" class="btn btn-xs btn-success">File Download</a></td>
                    @can('edit_clients')
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