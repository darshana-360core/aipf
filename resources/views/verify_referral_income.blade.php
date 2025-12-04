@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Verify Referral Income.</h4>
            </div>
        </div>
        
        <div class="row">
            <div class="white-box">
                <div class="panel-body">
                    <div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs member-tab" role="tablist">
                            <li role="presentation" class="active"><a href="#all_members" aria-controls="all_members"
                                    role="tab" data-toggle="tab">Verify Referral Income</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all_members">
                                @if(isset($data['data']))
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="col-md-3 form-group">
                                                    <label>Active</label><br>
                                                    <a href="{{route('activeReferralIncome')}}"><input type="submit" name="submit" value="Active Income" class="btn btn-success"></a>
                                                </div>
                                                <h5 class="card-title mb-4">Verify Referral Income</h5>
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