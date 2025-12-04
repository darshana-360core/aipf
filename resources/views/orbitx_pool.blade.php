@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">5% Pool Report</h4>
            </div>
        </div>
        
        <div class="row">
            <div class="white-box">
                <div class="panel-body">
                    <div>
                        <ul class="nav nav-tabs member-tab" role="tablist">
                            <li role="presentation" class="active"><a href="#all_members" aria-controls="all_members"
                                    role="tab" data-toggle="tab">5% Pool Report</a></li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all_members">
                                <div class="d-flex flex-wrap search-form export-form">
                                    <form action="{{route('orbitx_pool_report')}}" method="post" class="mb-0 col-xs-12 col-md-8">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group">
                                                <input id="startDate" name="start_date" @if(isset($data['start_date'])) value="{{$data['start_date']}}" @endif type="text" class="form-control start-date" placeholder="From Date" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <input id="endDate" name="end_date" @if(isset($data['end_date'])) value="{{$data['end_date']}}" @endif type="text" class="form-control end-date" placeholder="To Date" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <input id="hash" name="hash" @if(isset($data['hash'])) value="{{$data['hash']}}" @endif type="text" class="form-control" placeholder="Transaction Hash Or Wallet Address" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn waves-effect waves-light btn-success">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                @if(isset($data['data']))
                                    <div class="m-t-30">
                                        <div class="card-group">
                                            <div class="card p-2 p-lg-3">
                                                <div class="p-lg-3 p-2">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <button class="btn btn-circle btn-info text-white btn-lg" href="javascript:void(0)">
                                                                <i class="fas fa-dollar-sign"></i>
                                                            </button>
                                                            <h4 class="h5 fw-normal m-0 ms-4">Total Amount</h4>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <h2 class="display-7 mb-0">{{number_format($data['total_sum'], 2)}} Aipf</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card p-2 p-lg-3">
                                                <div class="p-lg-3 p-2">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <button class="btn btn-circle btn-success text-white btn-lg" href="javascript:void(0)">
                                                                <i class="fas fa-dollar-sign"></i>
                                                            </button>
                                                            <h4 class="h5 fw-normal m-0 ms-4">Today's Amount</h4>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <h2 class="display-7 mb-0">{{number_format($data['today_sum'], 2)}} Aipf</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if(isset($data['data']))
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <h5 class="card-title mb-4">All Members</h5>
                                                <div class="table-responsive">
                                                    <table class="table no-wrap user-table mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Sr</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Wallet Address</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Amount</th>
                                                                <!-- <th scope="col" class="border-0 fs-4 font-weight-medium">Transaction Hash</th> -->
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($data['data']['data'] as $key => $value)
                                                                <tr>
                                                                    <td><h5 class="font-weight-medium mb-1">{{ $key+1 }}</h5></td>
                                                                    <td><h5 class="font-weight-medium mb-1">{{ substr($value->wallet_address, 0, 6) . '...' . substr($value->wallet_address, -6) }}</h5></td>
                                                                    <td><span>{{ number_format($value->amount, 6, '.', '') }}</span></td>
                                                                    <!-- <td><h5 class="font-weight-medium mb-1">{{ substr($value->transaction_hash, 0, 6) . '...' . substr($value->transaction_hash, -6) }}</h5></td> -->
                                                                    <td><span>{{date('d-m-Y', strtotime($value->created_on))}}</span></td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                      <div class="col-sm-12 col-md-7">
                                                        <div class="dataTables_paginate paging_simple_numbers" id="example_paginate">
                                                            <ul class="pagination">
                                                            @if(isset($data['data']['data']))
                                                                @foreach($data['data']['links'] as $key => $value)
                                                                    @if($value['url'] != null)
                                                                        <li class="paginate_button page-item @if($value['active'] == "true") active @endif"><a href="{{$value['url']}}&hash={{$data['hash']}}&end_date={{$data['end_date']}}&start_date={{$data['start_date']}}" aria-controls="example" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $value['label']; ?></a></li>
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
    <script>
        $(function() {
            $('.start-date').datepicker({ dateFormat: 'dd-mm-yy' });
            $('.end-date').datepicker({ dateFormat: 'dd-mm-yy' });
        });
    </script>
    @include('includes.footer')