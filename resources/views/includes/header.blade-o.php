<body class="fix-header">
    <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
    <!--<div class="preloader">-->
    <!--    <svg class="circular" viewBox="25 25 50 50">-->
    <!--        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />-->
    <!--    </svg>-->
    <!--</div>-->
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo" href="{{route('dashboard')}}">
                        <!-- Logo icon image, you can use font-icon also -->
                        <!-- <b> -->
                        <!--This is dark logo icon--><img src="{{ asset('assets/images/logo.webp') }}" style="height: 25px;margin-top:15px;" alt="home" class="dark-logo" /><!--This is light logo icon-->
                        <!-- <img src="{{ asset("/admin_dep/images/icon.png") }}" alt="home" style="height: 25px;margin-top:15px;" class="light-logo" /> -->
                        <!-- </b> -->
                        
                        <!-- <span class="hidden-xs"> -->
                            <!--This is dark logo text-->
                            <!--This is light logo text-->
                            <img src="{{ asset('assets/images/logo.webp') }}" style="height: 43px;" alt="home" class="light-logo">
                        <!-- </span> -->
                      </a>
                </div>
                <!-- /Logo -->
                <!-- Search input and Toggle icon -->
                <ul class="nav navbar-top-links navbar-left">
                    <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu" style="line-height: 60px;"></i></a></li>
                    
                </ul>
                
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="javascript:void(0);" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset('assets/images/logo.webp') }}" alt="user-img" width="36" class="img-circle">
                            <b class="hidden-xs">{{ Session::get('email') }}</b>
                            <span class="caret"></span> 
                        </a>
                        <ul class="dropdown-menu dropdown-user animated123 flipInY123">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="{{ asset('assets/images/logo.webp') }}" alt="user" /></div>
                                    <div class="u-text">
                                        <p class="text-muted">{{ Session::get('email') }}</p>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <div class="d-flex align-items-center justify-content-between px-4">
                                    <div class="h6 fw-normal m-0">Dark Mode</div>
                                    <input type="checkbox" id="switch" class="switch" /><label for="switch">Toggle</label>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('logout') }}"><i class="fa fa-power-off me-3"></i>Logout</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->