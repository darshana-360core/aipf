<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Aipf || LOGIN</title>
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
        <a href="javascript:void(0)" class="p-20 di"><img style="width: 150px;" src="{{ asset('assets/images/logo.png') }}"></a>
        <div class="lg-content">
          <h2>Aipf</h2>
        </div>
      </div>
    </div>
    <div class="new-login-box">
      <div class="white-box">
        <h3 class="box-title m-b-0">Sign In to User</h3>
        <!-- <small>Enter your details below</small> -->
        <small>@if(!empty($data)){{ $data['message'] }} @endif</small>
        <form class="form-horizontal new-lg-form" id="loginform" method="POST" action="{{route('login')}}">
          @csrf
          <div class="form-group  m-t-20">
            <div class="col-xs-12">
              <label>Email Address</label>
              <input class="form-control" name="email" type="text" required="" placeholder="Email Address">
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <label>Password</label>
              <input class="form-control" name="password" type="password" id="typepass" required="" placeholder="Password">
              <input type="checkbox" onclick="Toggle()">
              <b>Show Password</b>
            </div>
          </div>
          <!-- <div class="form-group">
                      <div class="col-md-12">
                        <div class="checkbox checkbox-info pull-left p-t-0">
                          <input id="checkbox-signup" type="checkbox">
                          <label for="checkbox-signup"> Remember me </label>
                        </div>
                        <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> </div>
                    </div> -->
          <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
              <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit">Log In</button>
            </div>
          </div>
          <!-- <div class="form-group m-b-0">
                      <div class="col-sm-12 text-center">
                        <p>Don't have an account? <a href="register.html" class="text-primary m-l-5"><b>Sign Up</b></a></p>
                      </div>
                    </div> -->
        </form>
        <form class="form-horizontal" id="recoverform" action="#">
          <div class="form-group ">
            <div class="col-xs-12">
              <h3>Recover Password</h3>
              <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
            </div>
          </div>
          <div class="form-group ">
            <div class="col-xs-12">
              <input class="form-control" type="text" required="" placeholder="Email">
            </div>
          </div>
          <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
              <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
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
  <script>
    // Change the type of input to password or text 
    function Toggle() {
      var temp = document.getElementById("typepass");
      if (temp.type === "password") {
        temp.type = "text";
      } else {
        temp.type = "password";
      }
    }
  </script>
</body>

</html>