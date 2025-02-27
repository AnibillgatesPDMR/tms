@extends('layouts.app')

@section('title', 'Files')

@section('content')
    <div class="row">
        <div class="col-md-11">
            <h3 class="modal-title"><i class="fa fa-folder"></i> Files</h3>
        </div>
        <?php $url = request()->segments(); ?>
        <div class="col-md-1 page-action text-right">
        	<a href="{{ asset('copy/stage/list') }}/{{$url[3]}}" style="margin-right: 10px;" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
    
    <div class="result-set">
        <table class="table">
            <thead class="tablehead">
            <tr>
                <th>Id</th>
                <th>File Name</th>
                <th>Created Date</th>
                <th>Action</th>
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
                    
                    <td><a href="#" class="btn btn-xs btn-success" data-toggle="modal" data-target="#roleModal"> Update Status</a>&nbsp;&nbsp;
                    <!-- <a href="#" class="btn btn-xs btn-success">File Open</a> <a href="#" class="btn btn-xs btn-success">File Upload</a> --></td>
                    
                    
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


<!-- modal popup section -->
<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['route' => ['users.store'] ]) !!}

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="roleModalLabel">Work Status Update </h4>
                </div>
                <div class="modal-body">
                   <table style='width:100%;align:center;'>
                   <tr class="spaceUnder">
                   <td>Work Status :</td>
                   <td>
                    <select id="worktype" name="worktype" style="width:50%;" required>
                    <option value="">--Select--</option>
                            @foreach($worktype as $work)
                            <option value="{{$work->id}}" style="color:{{$work->color_code}};">{{$work->work_type}}</option>
                            @endforeach
                    </select>
                    
                    </td>
                   </tr>

<tr class="spaceUnder">
                   <td>Upload Files :</td>
                   <td>
                    <input type="file" name="content_file" id="content_file" required />
                    
                    </td>
                   </tr>



                   </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                    <!-- Submit Form Button -->
                    {!! Form::submit('Update', ['class' => 'btn btn-success userform']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
<!-- modal popup section end -->



@endsection


<style>
tr.spaceUnder>td {
  padding-bottom: 1em;
}

</style>