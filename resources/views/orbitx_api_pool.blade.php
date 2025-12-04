@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Verify Pool</h4>
            </div>
        </div>
        
        <div class="row">
            <div class="white-box">
                <div class="panel-body">
                    <div>
                        <ul class="nav nav-tabs member-tab" role="tablist">
                            <li role="presentation" class="active"><a href="#all_members" aria-controls="all_members"
                                    role="tab" data-toggle="tab">Verify Pool</a></li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all_members">
                                <div class="d-flex flex-wrap search-form export-form">
                                    <form action="{{route('orbitx_api_pool_report')}}" method="post" class="mb-0 col-xs-12 col-md-8">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group">
                                                <input id="startDate" name="start_date" @if(isset($data['start_date'])) value="{{$data['start_date']}}" @endif type="text" class="form-control start-date" placeholder="From Date" autocomplete="off">
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn waves-effect waves-light btn-success">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                @if(isset($data['start_date']))
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <h5 class="card-title mb-4">All Members</h5>
                                                <div class="table-responsive">
                                                    <table class="table no-wrap user-table mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Pool</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Total Reward</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">reward_per_user</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">total_members</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(isset($data['founder_data']))
                                                            <tr>
                                                                <td><h5 class="font-weight-medium mb-1">Founder</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['founder_data']['total_reward']}}</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['founder_data']['reward_per_user']}}</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['founder_data']['total_members']}}</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['founder_data']['distribution_date']}}</h5></td>
                                                            </tr>
                                                        @endif
                                                        @if(isset($data['marketting_data']))
                                                            <tr>
                                                                <td><h5 class="font-weight-medium mb-1">Marketting</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['marketting_data']['total_reward']}}</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['marketting_data']['reward_per_user']}}</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['marketting_data']['total_members']}}</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['marketting_data']['distribution_date']}}</h5></td>
                                                            </tr>
                                                        @endif
                                                        @if(isset($data['promoter_data']))
                                                            <tr>
                                                                <td><h5 class="font-weight-medium mb-1">Promoter</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['promoter_data']['total_reward']}}</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['promoter_data']['reward_per_user']}}</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['promoter_data']['total_members']}}</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['promoter_data']['distribution_date']}}</h5></td>
                                                            </tr>
                                                        @endif
                                                        @if(isset($data['lic_data']))
                                                            <tr>
                                                                <td><h5 class="font-weight-medium mb-1">LIC</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['lic_data']['total_reward']}}</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['lic_data']['reward_per_user']}}</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['lic_data']['total_members']}}</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['lic_data']['distribution_date']}}</h5></td>
                                                            </tr>
                                                        @endif
                                                        @if(isset($data['glc_data']))
                                                            <tr>
                                                                <td><h5 class="font-weight-medium mb-1">GIC</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['glc_data']['total_reward']}}</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['glc_data']['reward_per_user']}}</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['glc_data']['total_members']}}</h5></td>
                                                                <td><h5 class="font-weight-medium mb-1">{{ $data['glc_data']['distribution_date']}}</h5></td>
                                                            </tr>
                                                        @endif
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('includes.footerJs')
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
    <script>
        $(function() {
            $('.start-date').datepicker({ dateFormat: 'dd-mm-yy' });
            $('.end-date').datepicker({ dateFormat: 'dd-mm-yy' });
        });
    </script>
    @include('includes.footer')