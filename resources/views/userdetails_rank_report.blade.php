@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Event Details Report</h4>
            </div>
        </div>
        
        <div class="row">
            <div class="white-box">
                <div class="panel-body">
                    <div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs member-tab" role="tablist">
                            <li role="presentation" class="active"><a href="#all_members" aria-controls="all_members"
                                    role="tab" data-toggle="tab">Event Details Report</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all_members">
                                <div class="search-form export-form">
                                    <form action="{{route('userdetail_rank_report_process')}}" method="post" class="mb-0">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group">
                                                <input id="startDate" name="start_date" @if(isset($data['start_date'])) value="{{$data['start_date']}}" @endif type="text" class="form-control start-date" placeholder="From Date" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <input id="endDate" name="end_date" @if(isset($data['end_date'])) value="{{$data['end_date']}}" @endif type="text" class="form-control end-date" placeholder="To Date" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <input id="refferal_code" name="refferal_code" @if(isset($data['refferal_code'])) value="{{$data['refferal_code']}}" @endif type="text" class="form-control" placeholder="Enter Wallet Address">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn waves-effect waves-light btn-success">Search</button>
                                            </div>
                                        </div>
                                        <div class="export-section">
                                            <a href="https://defi.orbitx.world/exports/thailanda_report.csv?v={{time()}}" download="download"><button type="button" class="btn waves-effect waves-light btn-info">Export excel</button></a>
                                        </div>
                                    </form>
                                </div>
                                <!-- <div class="export-section">
                                    <a href="{{ url()->current() }}?export=yes&start_date={{ request('start_date') }}&end_date={{ request('end_date') }}&refferal_code={{ request('refferal_code') }}">
                                        <button type="button" class="btn waves-effect waves-light btn-info">Export Excel</button>
                                    </a>
                                </div> -->
                                @if(isset($data['data']))
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <h5 class="card-title mb-4">All Members</h5>
                                                <div class="table-responsive">
                                                    <table class="table no-wrap user-table mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                               <!--  <th scope="col" class="border-0 fs-4 font-weight-medium ps-4">
                                                                    <div class="form-check border-start border-2 border-info ps-1">
                                                                        <input type="checkbox" class="form-check-input ms-2" id="inputSchedule" name="inputCheckboxesSchedule">
                                                                        <label for="inputSchedule" class="form-check-label ps-2 fw-normal"></label>
                                                                    </div>
                                                                </th> -->
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Sr</th>
                                                                <!-- <th scope="col" class="border-0 fs-4 font-weight-medium">Member Code</th> -->
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Wallet Address</th>
                                                                <!-- <th scope="col" class="border-0 fs-4 font-weight-medium">Event</th> -->
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Rank</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Name</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Email</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Mobile</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Address Proof</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Photo</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                                <!-- <td class="ps-4">
                                                                    <div class="form-check border-start border-2 border-info ps-1">
                                                                        <input type="checkbox" class="form-check-input ms-2" id="inputSchedule1" name="inputCheckboxesSchedule">
                                                                        <label for="inputSchedule1" class="form-check-label ps-2 fw-normal"></label>
                                                                    </div>
                                                                </td> -->
                                                            @foreach($data['data']['data'] as $key => $value)
                                                                <tr>
                                                                    <td>
                                                                        <h5 class="font-weight-medium mb-1">{{$key + 1}}</h5>
                                                                    </td>
                                                                    <td><span>{{ substr($value['wallet_address'], 0, 6) . '...' . substr($value['wallet_address'], -6) }}</span></td>
                                                                    <!-- <td>{{$value['event']}}</span></td> -->
                                                                    <td>Rank {{$value['rank']}}</span></td>
                                                                    <td>{{$value['firstname']}}</span></td>
                                                                    <td>{{$value['email']}}</span></td>
                                                                    <td>{{$value['whatapp_num']}}</span></td>
                                                                    <td><a href="{{asset('storage/'.$value['address_proof'])}}" target="_blank">View</a></td>
                                                                    <td><a href="{{asset('storage/'.$value['user_photo'])}}" target="_blank">View</a></td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                    <div class="col-sm-12 col-md-7">
                                                        <div class="dataTables_paginate paging_simple_numbers" id="example_paginate">
                                                            <ul class="pagination">
                                                                @foreach($data['data']['links'] as $key => $value)
                                                                    @if($value['url'] != null)
                                                                        <li class="paginate_button page-item @if($value['active'] == "true") active @endif"><a href="{{$value['url']}}&start_date={{$data['start_date']}}&end_date={{$data['end_date']}}&refferal_code={{$data['refferal_code']}}" aria-controls="example" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $value['label']; ?></a></li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
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