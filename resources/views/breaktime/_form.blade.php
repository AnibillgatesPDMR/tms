<!-- Name Form Input -->




<div class="form-group @if ($errors->has('holidaydate')) has-error @endif">
    {!! Form::label('Break Out', 'Break Out') !!}
    <br />
    <input type="text" id="break_out" name="break_out"  style='width:100%;height:40px;' disabled value="<?php echo date('G:i'); ?>"  />


   <!--  <input type="text" id="break_out" name="break_out"  style='width:100%;height:40px;' disabled value="<?php //echo date('h:i:A'); ?>"  /> -->

    


    @if ($errors->has('break_out ')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>





<div class="form-group @if ($errors->has('holiday_remarks')) has-error @endif">
    {!! Form::label('break_reason', 'Break Remark') !!}
    <br />
    <textarea name='break_reason' id="break_reason" style='width:100%;'></textarea>

    @if ($errors->has('remarks')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
</div>


<div class="pull-right">
                            <a onclick="logout_func()" class="btn btn-default btn-flat" style="display:none;">Sign out</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>

<!-- Jquery date picker Code Start -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>



    
  


  function break_form_validation() {     
      
      //alert('Testing');

         var formValues = {break_out:$("#break_out").val(),break_reason:$("#break_reason").val()} 

        $.ajax({
        type: "GET",
        url: "{{ asset('breaktimeinsert') }}",
        data: formValues,
        cache: false,
        processData: true,
        success: function(data){



            if(data=='1') {

                    swal({title: "Message", text: "Break Applied Successfully", type: "success"},
                function(){ 
                    //location.reload();
                    logout_func();
                }
                );



            } else {

            

                swal({title: "Message", text: data, type: "success"},
                function(){ 
                  //  location.reload();
                }
                );
            }

        }
        });

  }


function logout_func() {


       // alert('Logout'); 
        
    var login_time = $('#logged_intime').val();
    var logged_outtime = $('#logged_outtime').val();
      if(login_time==logged_outtime) {
      document.getElementById('logout-form').submit();
    } else {

      confirm("Are you sure you want to logout?");
      document.getElementById('logout-form').submit();

     /* var answer = confirm("Are you sure your early exits?");
        if(answer){
          document.getElementById('logout-form').submit();
        } */
     
     }
     
    }




  </script>
<!-- Jquery date picker Code End -->

<!-- Permissions -->
