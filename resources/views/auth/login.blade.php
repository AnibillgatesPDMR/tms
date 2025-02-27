<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title') {{ config('app.name', 'TMS') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css">
    .login-box-body, .register-box-body {
      background-color: #666;
      color: #fff;
    }
    .login-box-body a, .register-box-body a {
      color: #fff;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box"  style='width:470px;'>
  <div class="login-logo">
    <a href="{{ url('/') }}"><img src="{{url('/images/compuscript_logo_tms.png')}}" alt="Campus Script Logo" /></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" style='border-radius: 15px;border: 1px solid #666;'>
    <p class="login-box-msg">Sign in to start your session <br />
     
    </p>

       @if (Session::has('message'))
   <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
    

    <form action="{{ route('login') }}" method="POST" role="form">
        {{ csrf_field() }}
        <div class="form-group has-feedback form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group has-feedback form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

            <div class="form-group has-feedback">
            <select id='work_type' name='work_type' style='width:100%;height:40px;color:#000;' required>
            <option value="" selected>Choose Work Type</option>
            <option value="office">Office</option>
            <option value="home">Home</option>
            </select>

           
        </div>




        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-success btn-block btn-flat">Sign In</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
    <!-- /.social-auth-links -->
  

    <a href="password">I forgot my password</a>

  </div>
  <!-- /.login-box-body -->
  <div style='text-align:center;font-weight:bold;margin-top:20px;'>&copy; Copy Rights - <?php echo date("Y"); ?></div>
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>