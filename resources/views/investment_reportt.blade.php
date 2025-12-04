@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Investment Report</h4>
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
                                <div class="h5 fw-normal m-0 ms-4">Flexible</div>
                            </div>
                            <div class="ms-auto">
                                <h2 class="display-7 mb-0">{{ number_format($data['flexible'], 2) }}</h2>
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
                                <div class="h5 fw-normal m-0 ms-4">Fixed</div>
                            </div>
                            <div class="ms-auto">
                                <h2 class="display-7 mb-0">{{ number_format($data['fixed'], 2) }}</h2>
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
                                <div class="h5 fw-normal m-0 ms-4">Bond</div>
                            </div>
                            <div class="ms-auto">
                                <h2 class="display-7 mb-0">{{ number_format($data['bond'], 2) }}</h2>
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
                                    role="tab" data-toggle="tab">Investment Report</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all_members">
                                <div class="search-form export-form">
                                    <form action="{{route('investmentReport')}}" method="post" class="mb-0">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group">
                                                <input id="startDate" name="start_date" @if(isset($data['start_date'])) value="{{$data['start_date']}}" @endif type="text" class="form-control start-date" placeholder="From Date" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <input id="endDate" name="end_date" @if(isset($data['end_date'])) value="{{$data['end_date']}}" @endif type="text" class="form-control end-date" placeholder="To Date" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <input id="refferal_code" name="refferal_code" @if(isset($data['refferal_code'])) value="{{$data['refferal_code']}}" @endif type="text" class="form-control" placeholder="Enter wallet address">
                                            </div>
                                            <div class="form-group">
                                                <select name="pkg_id" class="form-control">
                                                    <option value="">Select Type</option>
                                                    <option value="1" @if(isset($data['pkg_id'])) @if($data['pkg_id'] == '1') selected @endif @endif>Flexible</option>
                                                    <option value="3" @if(isset($data['pkg_id'])) @if($data['pkg_id'] == '3') selected @endif @endif>Fixed</option>
                                                    <option value="2" @if(isset($data['pkg_id'])) @if($data['pkg_id'] == '2') selected @endif @endif>Bond</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <select name="days" class="form-control">
                                                    <option value="">Select Type</option>
                                                    <option value="0" @if(isset($data['days'])) @if($data['days'] == '0') selected @endif @endif>1 Day</option>
                                                    <option value="1" @if(isset($data['days'])) @if($data['days'] == '1') selected @endif @endif>45 Days</option>
                                                    <option value="2" @if(isset($data['days'])) @if($data['days'] == '2') selected @endif @endif>90 Days</option>
                                                    <option value="3" @if(isset($data['days'])) @if($data['days'] == '3') selected @endif @endif>180 Days</option>
                                                    <option value="4" @if(isset($data['days'])) @if($data['days'] == '4') selected @endif @endif>360 Days</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn waves-effect waves-light btn-success">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @if(isset($data['data']))
                                <div class="export-section">
                                    <a href="{{ url()->current() }}?export=yes&start_date={{ request('start_date') }}&end_date={{ request('end_date') }}&refferal_code={{ request('refferal_code') }}&pkg_id={{ request('pkg_id') }}&days={{ request('days') }}">
                                        <button type="button" class="btn waves-effect waves-light btn-info">Export Excel</button>
                                    </a>
                                </div>
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
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Amount</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Type</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Days</th>
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
                                                            @foreach($data['data']['data'] as $key => $value)
                                                                <tr>
                                                                    <td>
                                                                        <h5 class="font-weight-medium mb-1">{{$key+1}}</h5>
                                                                        <!-- <a href="javascript:void(0);" class="font-14 text-muted"></a> -->
                                                                    </td>
                                                                    <!-- <td><span class="badge badge-inverse fs-4">{{$value['refferal_code']}}</span></td> -->
                                                                    <td>{{ substr($value['wallet_address'], 0, 6) . '...' . substr($value['wallet_address'], -6) }}</span></td>
                                                                    <!-- <td><span>{{$value['amount']}}</span></td> -->
                                                                    <td><span>{{number_format($value['amount'],4)}}</span></td>
                                                                    <td><span>
                                                                        @if($value['package_id']==1)
                                                                            Flexible
                                                                        @elseif($value['package_id']==3)
                                                                            Fixed
                                                                        @elseif($value['package_id']==2)
                                                                            Bond
                                                                        @endif
                                                                    </span></td>
                                                                    <td><span>
                                                                        @if($value['lock_period']==0)
                                                                            1 Day
                                                                        @elseif($value['lock_period']==1)
                                                                            45 Days
                                                                        @elseif($value['lock_period']==2)
                                                                            90 Days
                                                                        @elseif($value['lock_period']==3)
                                                                            180 Days
                                                                        @elseif($value['lock_period']==4)
                                                                            360 Days
                                                                        @endif
                                                                    </span></td>
                                   
                                                                    <td><span>{{date('d-m-Y H:i', strtotime($value['dateofearning']))}}</span></td>
                                                                </tr>
                                                                @php
                                                                    $total+=$value['amount'];
                                                                @endphp
                                                            @endforeach
                                                                <tr>
                                                                    <td><h3>Total : {{$total}}</h3></td>
                                                                </tr>  
                                                        </tbody>
                                                    </table>

                                                    <div class="col-sm-12 col-md-7">
                                                        <div class="dataTables_paginate paging_simple_numbers" id="example_paginate">
                                                            <ul class="pagination">
                                                                @foreach($data['data']['links'] as $key => $value)
                                                                    @if($value['url'] != null)
                                                                        <li class="paginate_button page-item @if($value['active'] == "true") active @endif"><a href="{{$value['url']}}&start_date={{$data['start_date']}}&end_date={{$data['end_date']}}&refferal_code={{$data['refferal_code']}}&days={{$data['days']}}&pkg_id={{$data['pkg_id']}}" aria-controls="example" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $value['label']; ?></a></li>
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