@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Income Report</h4>
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
                                <div class="h5 fw-normal m-0 ms-4">Alliance Reward</div>
                            </div>
                            <div class="ms-auto">
                                <h2 class="display-7 mb-0">{{ number_format($data['team_bonus'], 2) }}</h2>
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
                                <div class="h5 fw-normal m-0 ms-4">Roi Income</div>
                            </div>
                            <div class="ms-auto">
                                <h2 class="display-7 mb-0">{{ number_format($data['ROI_income'], 2) }}</h2>
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
                                <div class="h5 fw-normal m-0 ms-4">Prime Reward</div>
                            </div>
                            <div class="ms-auto">
                                <h2 class="display-7 mb-0">{{ number_format($data['level_income'], 2) }}</h2>
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
                                <div class="h5 fw-normal m-0 ms-4">Global Reward</div>
                            </div>
                            <div class="ms-auto">
                                <h2 class="display-7 mb-0">{{ number_format($data['direct_pool_income'], 2) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="white-box">
                <div class="panel-body">
                    <div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs member-tab" role="tablist">
                            <li role="presentation" class="active"><a href="#all_members" aria-controls="all_members"
                                    role="tab" data-toggle="tab">Income Report</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all_members">
                                <div class="search-form export-form">
                                    <form action="{{route('level_income_report')}}" method="post" class="mb-0">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group">
                                                <input id="refferal_code" name="refferal_code" @if(isset($data['refferal_code'])) value="{{$data['refferal_code']}}" @endif type="text" class="form-control" placeholder="Enter Wallet Address">
                                            </div>
                                            <div class="form-group">
                                                <select name="tag" class="form-control">
                                                    <option value="">Select Type</option>
                                                    <option value="ROI" @if(isset($data['tag'])) @if($data['tag'] == 'ROI') selected @endif @endif>ROI</option>
                                                    <option value="LEADERSHIP-REF-INCOME" @if(isset($data['tag'])) @if($data['tag'] == 'LEADERSHIP-REF-INCOME') selected @endif @endif>Prime Reward</option>
                                                    <option value="DIFF-TEAM-BONUS" @if(isset($data['tag'])) @if($data['tag'] == 'DIFF-TEAM-BONUS') selected @endif @endif>Alliance Reward</option>
                                                    <option value="DIRECT-POOL-BONUS" @if(isset($data['tag'])) @if($data['tag'] == 'DIRECT-POOL-BONUS') selected @endif @endif>Global Reward</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <input id="startDate" name="startDate" @if(isset($data['startDate'])) value="{{$data['startDate']}}" @endif type="date" class="form-control start-date" placeholder="From Date" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <input id="endDate" name="endDate" @if(isset($data['endDate'])) value="{{$data['endDate']}}" @endif type="date" class="form-control end-date" placeholder="To Date" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn waves-effect waves-light btn-success">Search</button>
                                            </div>
                                        </div>
                                        <!-- @if(isset($data['data']))
                                            <div class="export-section">
                                                <a href="https://finlyai.com/exports/userdataExport.csv" download="download"><button type="button" class="btn waves-effect waves-light btn-info">Export excel</button></a>
                                            </div>
                                        @endif -->
                                    </form>
                                </div>
                                <div class="export-section">
                                    <a href="{{ url()->current() }}?export=yes&startDate={{ request('startDate') }}&endDate={{ request('endDate') }}&refferal_code={{ request('refferal_code') }}&tag={{ request('tag') }}">
                                        <button type="button" class="btn waves-effect waves-light btn-info">Export Excel</button>
                                    </a>
                                </div>
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
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Tag</th>
                                                                <!-- <th scope="col" class="border-0 fs-4 font-weight-medium">Rank</th> -->
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Amount</th>
                                                                @if($data['tag'] == 'LEADERSHIP-REF-INCOME')
                                                                    <th scope="col" class="border-0 fs-4 font-weight-medium">Direct Referral Code</th>
                                                                @endif
                                                                <!-- <th scope="col" class="border-0 fs-4 font-weight-medium">Total</th> -->
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Date</th>
    
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                                <!-- <td class="ps-4">
                                                                    <div class="form-check border-start border-2 border-info ps-1">
                                                                        <input type="checkbox" class="form-check-input ms-2" id="inputSchedule1" name="inputCheckboxesSchedule">
                                                                        <label for="inputSchedule1" class="form-check-label ps-2 fw-normal"></label>
                                                                    </div>
                                                                </td> -->
                                                            @php
                                                                $total=0;
                                                            @endphp
                                                            @if(isset($data['data']['data']))
                                                            @foreach($data['data']['data'] as $key => $value)
                                                                <tr>
                                                                    <td><h5 class="font-weight-medium mb-1">{{ ($data['data']['current_page'] - 1) * 20 + $key + 1 }}</h5></td>
                                                                    <!-- <td><span class="badge badge-inverse fs-4">{{$value['refferal_code']}}</span></td> -->
                                                                    <td><h5 class="font-weight-medium mb-1">{{ substr($value['wallet_address'], 0, 6) . '...' . substr($value['wallet_address'], -6) }}</h5></td>
                                                                    <td><h5 class="font-weight-medium mb-1">{{$value['tag']}}</h5></td>
                                                                    <!-- <td>
                                                                        @if($value['tag']=='REWARD-BONUS')
                                                                            <h5 class="font-weight-medium mb-1">{{$value['refrence_id']}}</h5>
                                                                        @else
                                                                            <h5 class="font-weight-medium mb-1">-</h5>
                                                                        @endif
                                                                    </td> -->
                                                                    <!-- <td><span>{{$value['amount']}}</span></td> -->
                                                                    <td><span>{{number_format($value['amount'],4)}}</span></td>
                                                                    @if($data['tag'] == 'LEADERSHIP-REF-INCOME')
                                                                        <td><span>{{$value['refrence']}}</span></td>
                                                                    @endif
                                                                    <!-- <td><span>{{$data['amt']}}</span></td> -->
                                                                    <td><span>{{ date('d-m-Y H:i', strtotime($value['created'])) }}</span></td>
                                                                </tr>
                                                                @php
                                                                    $total+=$value['amount'];
                                                                @endphp
                                                            @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <br>
                                                    <hr>
                                                    <h3>Total : {{$total}}</h3>
                                                    <div class="col-sm-12 col-md-7">
                                                        <div class="dataTables_paginate paging_simple_numbers" id="example_paginate">
                                                            <ul class="pagination">
                                                            @if(isset($data['data']['data']))
                                                                @foreach($data['data']['links'] as $key => $value)
                                                                    @if($value['url'] != null)
                                                                        <li class="paginate_button page-item @if($value['active'] == "true") active @endif"><a href="{{$value['url']}}&refferal_code={{$data['refferal_code']}}&tag={{$data['tag']}}&endDate={{$data['endDate']}}&startDate={{$data['startDate']}}" aria-controls="example" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $value['label']; ?></a></li>
                                                                    @endif
                                                                @endforeach
                                                            @endif
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
    @include('includes.footer')