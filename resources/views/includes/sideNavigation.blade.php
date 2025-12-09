<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head">
            <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu"></span></h3>
        </div>
        <div class="user-profile">

        </div>
        <ul class="nav" id="side-menu">
            <li> <a href="{{ route('dashboard') }}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Dashboard </span></a></li>

            {{-- <li> <a href="{{ route('setting.index') }}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Setting </span></a></li> --}}

            <li> <a href="{{route('users.index')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Manage Users </span></a></li>
           {{--   <!-- <li> <a href="{{route('activated_admin_users')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Admin Activated Users </span></a></li> -->--}}


           {{-- <!-- <li> <a href="{{route('rank-bonus.index')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Rank Bonus </span></a></li> --> --}}

           {{-- <!-- <li> <a href="{{route('roi-distribution-import.index')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Roi Distribution </span></a></li> --> --}}
           {{-- <li> <a href="{{route('process_team_strong_business')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Strong Team Business </span></a></li> --}}
            <li> <a href="{{route('level_income_report')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">Income Report </span></a></li>
            <li> <a href="{{route('user_genealogy')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">Genealogy </span></a></li>
            <li> <a href="{{route('withdrawReport')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">Withdraw Report </span></a></li>
            <li> <a href="{{route('turbineReport')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">Turbine Report </span></a></li>
            <!-- <li> <a href="{{route('orbitx_pool')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">Pool Report </span></a></li> -->
            <li> <a href="{{route('releaseReport')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">Release Report </span></a></li>
          {{--  <li> <a href="{{route('orbitx_api_pool')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">Verify Pool Report </span></a></li> --}}
            <li> <a href="{{route('investmentReport')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">Investment Report </span></a></li>
            <li> <a href="{{route('orbitx_pool_report')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">5% Pool Report </span></a></li>
           {{-- <li> <a href="{{route('stablebonds_userdetail_report')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">Bonanza Form Details Report </span></a></li> --}}
           {{-- <li> <a href="{{route('userdetail_rank_report')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">Event Report </span></a></li> --}}
           {{-- <li> <a href="{{route('power_business_report')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">Power Business Report </span></a></li> --}}
           {{-- <li> <a href="{{route('incomeGReport')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">Income Report </span></a></li> --}}
           {{-- <li> <a href="{{route('orbitx-pool.index')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">OrbitX Pools </span></a></li> --}}

          {{--  <!-- <li> <a href="{{route('memberSupportTickets')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Support Tickets </span></a></li> -->

            <!-- <li> <a href="{{route('withdraw_stop')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Withdraw Stop </span></a></li>
            <li> <a href="{{route('add_website_popup')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Website Popup </span></a></li> -->

            <!-- <li> <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Reports <span class="fa arrow"></span> </span> </a>
                <ul class="nav nav-second-level collapse">
                    <li> <a href="{{route('investment_report')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Investment Report </span></a></li>
                    <li> <a href="{{route('withdraw_report')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Withdraw Report </span></a></li>
                </ul>
            </li> --> --}}
        </ul>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Left Sidebar -->
<!-- ============================================================== -->