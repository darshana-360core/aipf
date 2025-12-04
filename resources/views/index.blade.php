@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="m-t-30 hidden">
            <div class="white-box">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Dashboard</h4>
                        <h5 class="welcome-msg">Welcome {{ Session::get('email') }}</h5>
                    </div>
                    <!-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20">
                            <i class="ti-settings text-white"></i>
                        </button>
                    </div> -->
                    <!-- /.col-lg-12 -->
                </div>
            </div>
        </div>

        <div class="m-t-30">
            <div class="card-group">
                <div class="card p-2 p-lg-3">
                    <div class="p-lg-3 p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center justify-content-between">
                                <button class="btn btn-circle btn-danger text-white btn-lg" href="javascript:void(0)">
                                    <i class="ti-clipboard"></i>
                                </button>
                                <div class="h5 fw-normal m-0 ms-4">Total Users</div>
                            </div>
                            <div class="ms-auto">
                                <h2 class="display-7 mb-0">{{$data['total_users']}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card p-2 p-lg-3">
                    <div class="p-lg-3 p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center justify-content-between">
                                <button class="btn btn-circle btn-danger text-white btn-lg" href="javascript:void(0)">
                                    <i class="ti-clipboard"></i>
                                </button>
                                <div class="h5 fw-normal m-0 ms-4">Total Activated Plan</div>
                            </div>
                            <div class="ms-auto">
                                <h2 class="display-7 mb-0">{{$data['total_activated_count']}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card p-2 p-lg-3">
                    <div class="p-lg-3 p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center justify-content-between">
                                <button class="btn btn-circle btn-danger text-white btn-lg" href="javascript:void(0)">
                                    <i class="ti-clipboard"></i>
                                </button>
                                <div class="h5 fw-normal m-0 ms-4">Total Activated Plan(By Admin)</div>
                            </div>
                            <div class="ms-auto">
                                <h2 class="display-7 mb-0">{{$data['total_activated_by_admin_count']}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="m-t-30">
            <div class="card-group">
                <div class="card p-2 p-lg-3">
                    <div class="p-lg-3 p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center justify-content-between">
                                <button class="btn btn-circle btn-danger text-white btn-lg" href="javascript:void(0)">
                                    <i class="ti-clipboard"></i>
                                </button>
                                <div class="h5 fw-normal m-0 ms-4">Total Activated Amount</div>
                            </div>
                            <div class="ms-auto">
                                <h2 class="display-7 mb-0">{{$data['total_activated_amount']}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card p-2 p-lg-3">
                    <div class="p-lg-3 p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center justify-content-between">
                                <button class="btn btn-circle btn-danger text-white btn-lg" href="javascript:void(0)">
                                    <i class="ti-clipboard"></i>
                                </button>
                                <div class="h5 fw-normal m-0 ms-4">Total Activated Amount (By Admin)</div>
                            </div>
                            <div class="ms-auto">
                                <h2 class="display-7 mb-0">{{$data['total_activatedamount_by_admin']}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card p-2 p-lg-3">
                    <div class="p-lg-3 p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center justify-content-between">
                                <button class="btn btn-circle btn-danger text-white btn-lg" href="javascript:void(0)">
                                    <i class="ti-clipboard"></i>
                                </button>
                                <div class="h5 fw-normal m-0 ms-4">Total Withdraws</div>
                            </div>
                            <div class="ms-auto">
                                <h2 class="display-7 mb-0">{{$data['total_withdraws']}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.row -->
        <!-- ============================================================== -->
        <!-- Different data widgets @if(!empty($data['message'])){{ $data['message'] }} @endif -->
        <!-- ============================================================== -->
        <!-- .row -->
        <div class="row">
            <div class="right-sidebar">
                <div class="slimscrollright">
                    <div class="rpanel-title"> Choose Theme <span><i class="ti-close right-side-toggle"></i></span> </div>
                    <div class="r-panel-body">
                        <ul id="themecolors" class="m-t-20">
                            <li><b>With Light sidebar</b></li>
                            <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
                            <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                            <li><a href="javascript:void(0)" data-theme="gray" class="yellow-theme">3</a></li>
                            <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme">4</a></li>
                            <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                            <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end right sidebar -->
            <!-- ============================================================== -->
        </div>
        <!-- /.container-fluid -->
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>


    @include('includes.footerJs')
    @include('includes.footer')