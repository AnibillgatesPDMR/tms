<?php  use App\Role; 
use Carbon\Carbon;
  ?> 
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') {{ config('app.name', 'WMS') }}</title>
    <link rel="icon" href="{{asset('images/fav.jpg')}}" type="image/gif" sizes="16x16"> 
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <style type="text/css">
      .tablehead {
        background-color: #99b3ff;
      }
      .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        border: 1px solid #bfbfbf;
      }
      .pagination {
        border: 1px solid #bfbfbf;
      }
      .modal-header {
        background-color: #727272;
        color: #fff;
      }
      .close {
        color: #fff;
      }


      .profile-pic {
          max-width: 200px;
          max-height: 200px;
          display: block;
          height: 115px;
      }

      .file-upload {
          display: none !important;
      }
      .circle {
          border-radius: 1000px !important;
          overflow: hidden;
          width: 128px;
          height: 128px;
          border: 8px solid rgba(255, 255, 255, 0.7);
          position: absolute;
          left: 240px;
          
      }
      img {
          max-width: 100%;
          height: auto;
      }
      .p-image {
        position: absolute;
        top: 70px;
        right: 285px;
        color: #666666;
        transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
      }
      .p-image:hover {
        transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
      }
      .upload-button {
        font-size: 1.2em;
      }

      .upload-button:hover {
        transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
        color: #999;
      }

      .user-panel > .image > img {
        height: 45px;
      }
      .sidebar-menu > li > a > .fa, .sidebar-menu > li > a > .glyphicon, .sidebar-menu > li > a > .ion, .sidebar-menu > li > a > span {
        color: #fff;
      }
    </style>
    


<!-- Sweet alert reference script / css -->
<link rel="stylesheet" href="{{ asset('sweet/sweetalert.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">



</head>

<body class="hold-transition skin-blue sidebar-mini">
    @if (Auth::check())
    <div class="wrapper">

          <header class="main-header">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="logo">
              <!-- mini logo for sidebar mini 50x50 pixels -->
              <span class="logo-mini"><b>W</b>MS</span>
              <!-- logo for regular state and mobile devices -->
              <span class="logo-lg"><b>Admin</b>WMS</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
              <!-- Sidebar toggle button-->
              <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
              </a>
              
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  <!-- User Account: style can be found in dropdown.less -->
                  <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <img src="<?php if(Auth::user()->profile_path) { echo Auth::user()->profile_path; } else { ?> {{ asset('images/profile.png') }}<?php } ?>" class="user-image" alt="User Image">
                      <span class="hidden-xs">{{ Auth::user()->name }}
                     
                      </span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- User image -->

                      
                      <li class="user-header">
                        <img src="<?php if(Auth::user()->profile_path) { echo Auth::user()->profile_path; } else { ?> {{ asset('images/profile.png') }}<?php } ?>" class="img-circle" alt="User Image">

                        <p>
                          {{ Auth::user()->name }} - {{ Auth::user()->roles->pluck('name')->first() }}
                        </p>
                      </li>
                      <!-- Menu Footer-->
                      <li class="user-footer">
                        <div class="pull-left">
                          <a href="#" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                            <a onclick="logout_func()" class="btn btn-default btn-flat">Sign out</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </nav>
          </header>
          <!-- Left side column. contains the logo and sidebar -->
          <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
              <!-- Sidebar user panel -->
              <div class="user-panel">
                <div class="pull-left image">
                  <img src="<?php if(Auth::user()->profile_path) { echo Auth::user()->profile_path; } else { ?> {{ asset('images/profile.png') }}<?php } ?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                  <p>{{ Auth::user()->name }}</p>
                  <a href="#" style="display:none;"><i class="fa fa-circle text-success"></i>On</a>
                  
                </div>
              </div>
              <!-- sidebar menu: : style can be found in sidebar.less -->
              <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>
                <li class="{{ Request::is('home*') ? 'active' : '' }}">
                  <a href="{{ route('home') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                  </a>
                </li>
                @can('view_users')
                  <li class="{{ Request::is('users*') ? 'active' : '' }}">
                    <a href="{{ asset('users') }}"><i class="fa fa-user"></i><span>Users</span></a>
                  </li>
                @endcan
                @can('view_roles')
                  <li class="{{ Request::is('roles*') ? 'active' : '' }}">
                    <a href="{{ route('roles.index') }}"><i class="fa fa-lock"></i> <span>Roles</span></a>
                  </li>
                @endcan
                @can('view_holidays')
                  <li class="{{ Request::is('holidays*') ? 'active' : '' }}">
                    <a  href="{{ asset('holidays') }}"><i class="fa fa-bell-slash"></i> <span>Bank/Public Holidays</span></a>
                  </li>
                @endcan
                @can('view_working_hours')
                  <li class="{{ Request::is('trackingworkinghours*') ? 'active' : '' }}">
                    <a href="{{ asset('trackingworkinghours') }}"><i class="fa fa-bell"></i> <span>Tracking Working Hours</span></a>
                  </li>
                @endcan
                @can('view_reports')
                  <li class="{{ Request::is('reportdashboard*') ? 'active' : '' }}">
                    <a href="{{ asset('reportdashboard') }}"><i class="fa fa-file"></i> <span>Reports</span></a>
                  </li>
                @endcan
                @can('view_forget_login')
                  <li class="{{ Request::is('forgetlogin*') ? 'active' : '' }}">
                    <a href="{{ asset('forgetlogin') }}"><i class="fa fa-hand-pointer-o"></i> <span>Forget Login</span></a>
                  </li>
                @endcan
                @can('view_request_time_off')
                  <li class="{{ Request::is('leavedashboard*') ? 'active' : '' }}">
                    <a href="{{ asset('leavedashboard') }}"><i class="fa fa-power-off" aria-hidden="true"></i> <span>Request Time Off</span></a>
                  </li>
                @endcan
                @can('view_departments')
                  <li class="{{ Request::is('departmentlist') ? 'active' : '' }}">
                    <a href="{{ asset('departmentlist') }}"><i class="fa fa-align-justify" aria-hidden="true"></i> <span>Departments</span></a>
                  </li>
                @endcan
              </ul>
            </section>
            <!-- /.sidebar -->
          </aside>

          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- Main content -->
            <section class="content">
                <div id="flash-msg">
                    @include('flash::message')
                </div>
                @yield('content')
            </section>
            <!-- /.content -->
          </div>
          <!-- /.content-wrapper -->
          <footer class="main-footer">
            <strong>Copyright &copy; <?php echo date('Y'); ?>.
          </footer>
          <!-- /.control-sidebar -->
          <!-- Add the sidebar's background. This div must be placed
               immediately after the control sidebar -->
          <div class="control-sidebar-bg"></div>
        </div>
    @endif
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')

    <!-- jQuery 3 -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!--Start: Custom Script -->
    <script src="{{ asset('js/custom.js') }}"></script>
    <!--End: Custom Script -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Morris.js charts -->
    <script src="{{ asset('bower_components/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('bower_components/morris.js/morris.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
    <!-- jvectormap -->
    <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- datepicker -->
    <script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <!-- Slimscroll -->
    <script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <script src="{{ asset('sweet/sweetalert.min.js') }}"></script>

    <script>
        $(function () {
            // flash auto hide
            $('#flash-msg .alert').not('.alert-danger, .alert-important').delay(6000).slideUp(500);
        })
    </script>

  <!-- logout form submit functionality -->
  
  <script type="text/javascript">
  
  function logout_func() {

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




  <!-- logout form submit functionality end -->



</body>
</html>
