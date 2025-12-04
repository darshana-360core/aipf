@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Award Withdraw Request</h4>
            </div>
        </div>
        
        <div class="row">
            <div class="white-box">
                <div class="panel-body">
                    <div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs member-tab" role="tablist">
                            <li role="presentation" class="active"><a href="#all_members" aria-controls="all_members"
                                    role="tab" data-toggle="tab">Award Withdraw Request</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all_members">
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
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Member Name</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Member Code</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">MT5 Id</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Sponsor Code</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Amount</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Email</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Mobile Number</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Address</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Id Proof</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Document</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Approve</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Reject</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                                <!-- <td class="ps-4">
                                                                    <div class="form-check border-start border-2 border-info ps-1">
                                                                        <input type="checkbox" class="form-check-input ms-2" id="inputSchedule1" name="inputCheckboxesSchedule">
                                                                        <label for="inputSchedule1" class="form-check-label ps-2 fw-normal"></label>
                                                                    </div>
                                                                </td> -->
                                                            @foreach($data['data'] as $key => $value)
                                                                <tr>
                                                                    <td>
                                                                        <h5 class="font-weight-medium mb-1">{{$value['name']}}</h5>
                                                                        <!-- <a href="javascript:void(0);" class="font-14 text-muted"></a> -->
                                                                    </td>
                                                                    <td><span class="badge badge-inverse fs-4">{{$value['refferal_code']}}</span></td>
                                                                    <td><span class="badge badge-inverse fs-4">{{$value['mt5']}}</span></td>
                                                                    <td><span class="badge badge-inverse fs-4">{{$value['sponser_code']}}</span></td>
                                                                    <td><span>{{$value['award_option']}}</span></td>
                                                                    <td><span>{{$value['email']}}</span></td>
                                                                    <td><span>{{$value['mobile_number']}}</span></td>
                                                                    <td><span>{{$value['address']}}</span></td>
                                                                    <td><span>{{$value['id_proof'] == 1 ? "Aadhar Card" : "Pancard"}}</span></td>
                                                                    <td><span><a href="{{"https://ai.vitnixx.com/storage/".$value['document']}}">View Txn</a></span></td>
                                                                    <td>
                                                                        <form action="{{route('awardIncomeProcessAdmin')}}" method="POST">
                                                                            <input type="hidden" name="decision" value="1">
                                                                            <input type="hidden" name="wid" value="{{$value['id']}}">
                                                                            <input type="submit" class="btn btn-success" name="submit" value="Accept">
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <form action="{{route('awardIncomeProcessAdmin')}}" method="POST">
                                                                            <input type="hidden" name="decision" value="0">
                                                                            <input type="hidden" name="wid" value="{{$value['id']}}">
                                                                            <input type="submit" class="btn btn-danger" name="submit" value="Reject">
                                                                        </form>
                                                                    </td>
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