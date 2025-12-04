@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Referral Income Report</h4>
            </div>
        </div>
        
        <div class="row">
            <div class="white-box">
                <div class="panel-body">
                    <div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs member-tab" role="tablist">
                            <li role="presentation" class="active"><a href="#all_members" aria-controls="all_members"
                                    role="tab" data-toggle="tab">Referral Income Report</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all_members">
                                <div class="search-form export-form">
                                    <form action="{{route('verifyReferralIncomeReport')}}" method="post" class="mb-0">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group">
                                                <input id="startDate" name="start_date" @if(isset($data['start_date'])) value="{{$data['start_date']}}" @endif type="text" class="form-control start-date" placeholder="From Date" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <input id="endDate" name="end_date" @if(isset($data['end_date'])) value="{{$data['end_date']}}" @endif type="text" class="form-control end-date" placeholder="To Date" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn waves-effect waves-light btn-success">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                        <div class="export-section">
                                            <form action="{{route('verifyReferralIncomeReportExport')}}" method="post" class="mb-0">
                                                <input  name="start_date" @if(isset($data['start_date'])) value="{{$data['start_date']}}" @endif type="hidden">

                                                <input name="end_date" @if(isset($data['end_date'])) value="{{$data['end_date']}}" @endif type="hidden">

                                                <button type="submit" class="btn waves-effect waves-light btn-info">Export excel</button>
                                            </form>
                                        </div>
                                </div>
                                @if(isset($data['data']))
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <h5 class="card-title mb-4">Referral Income Report</h5>
                                                <div class="table-responsive">
                                                    <table class="table no-wrap user-table mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Member Name</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Member Code</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">MT5 Id</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Amount</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Investor Member Name</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Investor Member Code</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Investor MT5 Id</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($data['data'] as $key => $value)
                                                                <tr>
                                                                    <td><h5 class="font-weight-medium mb-1">{{$value['name']}}</h5></td>
                                                                    <td><span class="badge badge-inverse fs-4">{{$value['refferal_code']}}</span></td>
                                                                    <td><span class="badge badge-inverse fs-4">{{$value['mt5']}}</span></td>
                                                                    <td><span class="badge badge-inverse fs-4">{{$value['amount']}}</span></td>
                                                                    <td><h5 class="font-weight-medium mb-1">{{$value['iname']}}</h5></td>
                                                                    <td><span class="badge badge-inverse fs-4">{{$value['irefferal_code']}}</span></td>
                                                                    <td><span class="badge badge-inverse fs-4">{{$value['imt5']}}</span></td>
                                                                </tr>
                                                            @endforeach
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