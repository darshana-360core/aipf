<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Orbitx || LOGIN</title>
  <!-- Bootstrap Core CSS -->
  <link href="{{ asset("admin_dep/bootstrap/dist/css/bootstrap.min.css") }}" rel="stylesheet">
  <!-- animation CSS -->
  <link href="{{ asset("admin_dep/css/animate.css") }}" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="{{ asset("admin_dep/css/style.css") }}" rel="stylesheet">
  <link href="{{ asset("admin_dep/css/ext-component-toastr.css") }}" rel="stylesheet">
  <!-- color CSS -->
  <link href="{{ asset("admin_dep/css/colors/default.css") }}" id="theme" rel="stylesheet">

</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <div class="cssload-speeding-wheel"></div>
  </div>
  <section id="wrapper" class="new-login-register">
    <div class="lg-info-panel">
      <div class="inner-panel">
        <a href="javascript:void(0)" class="p-20 di"><img style="width: 150px;" src="{{ asset('assets/images/loader.svg') }}"></a>
        <div class="lg-content">
          <h2>Orbitx</h2>
        </div>
      </div>
    </div>
    <div class="new-login-box">
      <div class="white-box">
        <h3 class="box-title m-b-0">Enter OTP to login</h3>
        <!-- <small>Enter your details below</small> -->
        <small>@if(!empty($data)){{ $data['message'] }} @endif</small>
        <form class="form-horizontal new-lg-form" id="loginform" method="POST" action="{{route('aotpProcess')}}">
          @csrf
          <div class="form-group  m-t-20">
            <div class="col-xs-12">
              <label>OTP</label>
              <input class="form-control" name="otp" type="text" required="" placeholder="Enter OTP.">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
              <div class="checkbox checkbox-info pull-left p-t-0">
                <input id="checkbox-signup" type="checkbox">
                <label for="checkbox-signup"> Did not received? </label>
              </div>
              <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Resend OTP</a>
            </div>
          </div>
          <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
              <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit">Verify</button>
            </div>
          </div>
        </form>
      </div>
    </div>


  </section>
  <!-- jQuery -->
  <script src="{{ asset("plugins/bower_components/jquery/dist/jquery.min.js") }}"></script>
  <!-- Bootstrap Core JavaScript -->
  <script src="{{ asset("admin_dep/bootstrap/dist/js/bootstrap.min.js") }}"></script>
  <!-- Menu Plugin JavaScript -->
  <script src="{{ asset("plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js") }}"></script>

  <!--slimscroll JavaScript -->
  <script src="{{ asset("admin_dep/js/jquery.slimscroll.js") }}"></script>
  <!--Wave Effects -->
  <script src="{{ asset("admin_dep/js/waves.js") }}"></script>
  <!-- Custom Theme JavaScript -->
  <script src="{{ asset("admin_dep/js/custom.min.js") }}"></script>
  <!--Style Switcher -->
  <script src="{{ asset("plugins/bower_components/styleswitcher/jQuery.style.switcher.js") }}"></script>
</body>

</html>