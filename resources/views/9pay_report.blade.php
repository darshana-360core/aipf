@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">9pay Report</h4>
            </div>
        </div>
        @if(isset($data))

        <div class="m-t-30">
            <div class="card-group">
                <div class="card p-2 p-lg-3">
                    <div class="p-lg-3 p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center justify-content-between">
                                <button class="btn btn-circle btn-danger text-white btn-lg" href="javascript:void(0)">
                                    <i class="ti-clipboard"></i>
                                </button>
                                <div class="h5 fw-normal m-0 ms-4">Ethereum Total</div>
                            </div>
                            <div class="ms-auto">
                                <h2 class="display-7 mb-0">{{$data['ethSum']}}</h2>
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
                                <div class="h5 fw-normal m-0 ms-4">Tron Total</div>
                            </div>
                            <div class="ms-auto">
                                <h2 class="display-7 mb-0">{{$data['tronSum']}}</h2>
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
                                <div class="h5 fw-normal m-0 ms-4">Polygon Total</div>
                            </div>
                            <div class="ms-auto">
                                <h2 class="display-7 mb-0">{{$data['polygonSum']}}</h2>
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
                                <div class="h5 fw-normal m-0 ms-4">Bsc Total</div>
                            </div>
                            <div class="ms-auto">
                                <h2 class="display-7 mb-0">{{$data['bscSum']}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="white-box">
                <div class="panel-body">
                    <div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs member-tab" role="tablist">
                            <li role="presentation" class="active"><a href="#all_members" aria-controls="all_members"
                                    role="tab" data-toggle="tab">9pay Report</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all_members">
                                <div class="search-form export-form">
                                    <form action="{{route('9payReport')}}" method="post" class="mb-0">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group">
                                                <input id="startDate" name="start_date" @if(isset($data['start_date'])) value="{{$data['start_date']}}" @endif type="text" class="form-control start-date" placeholder="From Date" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <input id="endDate" name="end_date" @if(isset($data['end_date'])) value="{{$data['end_date']}}" @endif type="text" class="form-control end-date" placeholder="To Date" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <input id="refferal_code" name="refferal_code" @if(isset($data['refferal_code'])) value="{{$data['refferal_code']}}" @endif type="text" class="form-control" placeholder="Enter refferal code">
                                            </div>
                                            <div class="form-group">
                                                <select name="chain" class="form-control">
                                                    <option value="">Select Type</option>
                                                    <option value="polygon" @if(isset($data['chain'])) @if($data['chain'] == 'polygon') selected @endif @endif>Polygon</option>
                                                    <option value="bsc" @if(isset($data['chain'])) @if($data['chain'] == 'bsc') selected @endif @endif>BSC</option>
                                                    <option value="tron" @if(isset($data['chain'])) @if($data['chain'] == 'tron') selected @endif @endif>Tron</option>
                                                    <option value="eth" @if(isset($data['chain'])) @if($data['chain'] == 'eth') selected @endif @endif>Ethereum</option>
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
                                    <a href="{{ url()->current() }}?export=yes&start_date={{ request('start_date') }}&end_date={{ request('end_date') }}&refferal_code={{ request('refferal_code') }}&chain={{ request('chain') }}">
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
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Member Name</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Member Code</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Amount</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Fees Amount</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Recieved Amount</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Chain</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Date</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Status</th>
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
                                                                    <td><span class="badge badge-inverse fs-4">{{$value['refferal_code']}}</span></td>
                                                                    <td>
                                                                        <h5 class="font-weight-medium mb-1">{{$value['name']}}</h5>
                                                                        <!-- <a href="javascript:void(0);" class="font-14 text-muted"></a> -->
                                                                    </td>
                                                                    <td><span class="badge badge-inverse fs-4">{{$value['amount']}}</span></td>
                                                                    <td><span>{{$value['fees_amount']}}</span></td>
                                                                    <td><span>{{$value['received_amount']}}</span></td>
                                                                    <td><span>{{$value['chain']}}</span></td>
                                                                    <td><span>{{date('d-m-Y', strtotime($value['created_on']))}}</span></td>
                                                                    <td><span>{{ $value['status'] == 1 ? 'Completed' : ($value['status'] == 2 ? 'Canceled' : 'Pending') }}</span></td>
                                                                </tr>
                                                            @endforeach
                                                                <tr>
                                                                    <td><h3>Total : {{$data['totalAmount']}}</h3></td>
                                                                </tr>
                                                        </tbody>
                                                    </table>

                                                    <div class="col-sm-12 col-md-7">
                                                        <div class="dataTables_paginate paging_simple_numbers" id="example_paginate">
                                                            <ul class="pagination">
                                                                @foreach($data['data']['links'] as $key => $value)
                                                                    @if($value['url'] != null)
                                                                        <li class="paginate_button page-item @if($value['active'] == "true") active @endif"><a href="{{$value['url']}}&start_date={{$data['start_date']}}&end_date={{$data['end_date']}}&refferal_code={{$data['refferal_code']}}&chain={{$data['chain']}}" aria-controls="example" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $value['label']; ?></a></li>
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