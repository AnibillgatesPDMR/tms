@extends('layouts.app')

@section('content')
    <section>
      <h1>
        Tickets Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tickets</li>
      </ol>
    </section>
    <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo count($result); ?></h3>
              <p>Ticket List</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ asset('tickets/add/ticket') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
      </div>

 


@endsection
