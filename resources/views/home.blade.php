

<?php  use App\Role;
use App\Client; 
use App\User;


$users_Count = User::all();
$client = Client::getClient();
$book_count = Client::getAllBookCount();
$file_upload = Client::getAllClientCount();
//print_r($book_count);
?> 
 
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" /> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  
  
  

  <script>

  $(document).ready(function() {

    var url = window.location.href;
    var projet_path = url.split('/');
    var url_path = window.location.origin + '/' + projet_path[3];

     $.ajax({
      url: "{{ asset('leavelistdeatils_ajax') }}",
       type:"GET",
       data:{},
       success:function(res_data)  {

       // alert(res_data);
        
        var fetch_record = res_data;
        jsondata = JSON.parse(res_data);

        /* Calendar function */


        var calendar = $('#calendar').fullCalendar({

         editable:false,
         header:{
          left:'prev, today',
        
          center:'title',
         right:'next'
          
         },

         editable: true, 

         dayClick: function() { tooltip.hide() },
         eventResizeStart: function() { tooltip.hide() },
         eventDragStart: function() { tooltip.hide() },
         viewDisplay: function() { tooltip.hide() },
         events: jsondata,
         selectable:false,
         selectHelper:true,
         overlap: false,
        
         eventMouseover: function(calEvent, jsEvent) {
         var tooltip = '<div class="tooltipevent" style="width:auto;height:auto;background:#ccc;position:absolute;z-index:10001;padding:10px;border:1px #000 solid;border-radious:20px;">' + calEvent.reason + '<br> No of Days : ' + calEvent.noofdays + '<br>' + calEvent.status + '</div>';
         var $tooltip = $(tooltip).appendTo('body');
     
         $(this).mouseover(function(e) {
             $(this).css('z-index', 10000);
             $tooltip.fadeIn('500');
             $tooltip.fadeTo('10', 1.9);
         }).mousemove(function(e) {
             $tooltip.css('top', e.pageY + 10);
             $tooltip.css('left', e.pageX + 20);
         });

       


     },
     
     eventMouseout: function(calEvent, jsEvent) {
         $(this).css('z-index', 8);
         $('.tooltipevent').remove();
     },
     
        
     
        });  



      $('.fc-prev-button').click(function(){
        var tglCurrent = $('#calendar').fullCalendar('getDate');
                var date = new Date(tglCurrent);
                var year = date.getFullYear();
                var month = date.getMonth();
                var month1 = month + 1;
              //  alert('Year is '+year+' Month is '+month);

               // alert(month1);
              

                var months = [ "January", "February", "March", "April", "May", "June", 
           "July", "August", "September", "October", "November", "December" ];

                    var formValues = {id:month1,year:year}

                    $.ajax({
                    type: "GET",
                    //url: "<?php //echo 'https://ise70.compuscript.ie/tms/public/get_Leaves_bymonth_ajax'; ?>",
                    url: url_path+"<?php echo '/public/get_Leaves_bymonth_ajax'; ?>",
                    

                    data: formValues,
                    cache: false,
                    success: function(data){
                    $('#month_leave_table').empty();
                    $('#calendar_month').html('');


                  // alert(data);
                    document.getElementById('month_leave_table').innerHTML =data;
                    document.getElementById('calendar_month').innerHTML = months[month] +' Leave';



                    }
                    }); 





                
      });

      $('.fc-next-button').click(function(){
        var tglCurrent = $('#calendar').fullCalendar('getDate');


        
                var date = new Date(tglCurrent);
                var year = date.getFullYear();
               // var year = 2023;
                var month = date.getMonth();
                var month1 = month + 1;
               // alert('Year is '+year+' Month is '+month);

              // alert(month1);

                var months = [ "January", "February", "March", "April", "May", "June", 
           "July", "August", "September", "October", "November", "December" ];


           var formValues = {id:month1,year:year}

            $.ajax({
            type: "GET",
           // url: "<?php //echo 'https://ise70.compuscript.ie/tms/public/get_Leaves_bymonth_ajax'; ?>",
            url: url_path+"<?php echo '/public/get_Leaves_bymonth_ajax'; ?>",
            data: formValues,
            cache: false,
            success: function(data){
            $('#month_leave_table').empty();
            $('#calendar_month').html('');

             // alert(data);
             document.getElementById('month_leave_table').innerHTML =data;
             document.getElementById('calendar_month').innerHTML = months[month] +' Leave';   
    
    
            }
            }); 


           
         


             //   document.getElementById('month_leave_table').innerHTML = months[month] +' Leave';

               
      });

      var months = [ "January", "February", "March", "April", "May", "June", 
           "July", "August", "September", "October", "November", "December" ];
          
          var tglCurrent = $('#calendar').fullCalendar('getDate');
               var date = new Date(tglCurrent);
                var year = date.getFullYear();
                var month = date.getMonth();
                var month1 = month+1;
               // alert(month1)
                

          //var formValues = {id:03}
           var formValues = {id:month1,year:year}
            $.ajax({
            type: "GET",
            //url: "<?php //echo 'https://ise70.compuscript.ie/tms/public/get_Leaves_bymonth_ajax'; ?>",
            url: url_path+"<?php echo '/public/get_Leaves_bymonth_ajax'; ?>",
            data: formValues,
            cache: false,
            success: function(data){
            $('#month_leave_table').empty();
            $('#calendar_month').html('');

             //alert(data);
             document.getElementById('month_leave_table').innerHTML =data;
             document.getElementById('calendar_month').innerHTML = months[month] +' Leave';   
    
    
            }
            }); 




       $('.fc-today-button').click(function(){
         location.reload();
       });

        /* Calendar function end */



       }
    });


   
  });




 
 
 
  </script>

<style>
  .fc-time {
	  display:none !important;
  }
  .fc-title{
	  color:#000 !important;
	  
  }

  .ui-datepicker-inline ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all {
    display:none !important;
  }
  .navbar-custom-menu {
    margin-top:-55px !important;
    margin-left:930px !important;
  }
  .fc-scroller {
    height:340px !important;
  }
  </style>



@extends('layouts.app')

@section('content')



 
    <section>
      
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active" style='display:none;'><i class="fa fa-dashboard"></i>Dashboard</li>
      </ol>
    </section>


    <div class="container" style='width:40% !important;float:left;height:320px !important;'>
   <div id="calendar" style='background-color:darkseagreen !important;'></div>
   <div id="calendar1" style='background-color:darkseagreen !important;'></div>
   
  <br>
   <h4><a href="{{ asset('leave/add/leave')}}"  style='cursor:hand;' ><b>Leave Requests</b></a></h4>
   
  </div>

 
   
   <h3 id='calendar_month'><?php echo date('F').' Leave'; ?></h3>
 <div class="row" >

 

 <table class="table table-bordered" style='width:95% !important;margin-left:10px;margin-top:30px;border-top:1px solid grey;'>
    <thead>
      <tr>
       <!-- <th>S.No </th> -->
        <th>Emp Name</th>
        <th>Type</th>
        <th>Days</th>
        <th>Date</th>
       <!-- <th>Created</th> -->
        <th>Status</th>
      </tr>
    </thead>
    <tbody id='month_leave_table'>
<?php /*
    <?php $k=1;  foreach($leave_details as $item) { ?>
      <tr>
       <!-- <td align="center"><?php echo $k; $k++; ?></td> -->
        <td><?php echo $item->name; ?></td>
        <td><?php echo $item->leave_type; ?></td>
        <td><?php echo $item->no_ofdays; ?></td>
        <td><?php echo $item->from_date; ?>&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo$item->to_date; ?></td>
        <!-- <td><?php echo $item->created_date; ?></td> -->
       
       
        <td>


        <?php 
        
        
       // echo $item->leave_status."_";
        if($item->leave_status=='Pending') { ?>

        <a href="{{ asset('leave/add/leave')}}" target='_blank' ><?php echo $item->leave_status; ?></a>

        <?php } else { ?>
          <?php echo $item->leave_status; ?>
        <?php } ?>
        
        
        </td>
      </tr>

    <?php } ?> */?>
     
    </tbody>
  </table>

   



    </div>
    <!-- Small boxes (Stat box) -->
      <div class="row" style='display:none;'>
        @can('view_users')
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{count($users_Count)}}</h3>

              <p>Total Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="users" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        @endcan
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6" style='display:none;'>
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{count($client)}}</h3>

              <p>Total Clients</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="clients/home/dashboard" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6" style='display:none;'>
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$book_count}}</h3>

              <p>Total Books</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-book"></i>
            </div>
            <a href="login/home/dashboard" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6" style='display:none;'>
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{count($file_upload)}}</h3>

              <p>File Uploads</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-compose"></i>
            </div>
            <a href="copy/home/dashboard" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
     
@endsection
