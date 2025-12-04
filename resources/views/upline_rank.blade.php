@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')


<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Upline Ranks</h4>
                </div>
            </div>
        <div class="row">
            <div class="white-box">
                <div class="panel-body">
                    @if ($sessionData = Session::get('data'))
                    @if($sessionData['status_code'] == 1)
                    <div class="alert alert-success alert-block">
                    @else
                    <div class="alert alert-danger alert-block">
                    @endif
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $sessionData['message'] }}</strong>
                    </div>
                    @endif

                    <form action="{{ route('findUplineRankViewResult') }}" enctype="multipart/form-data" method="post">
                        {{ method_field("POST") }}

                        @csrf

                        <div class="col-md-6 form-group">
                            <label>Member Code </label>
                            <input type="text" @if(isset($data['member_code'])) value="{{$data['member_code']}}" @endif name="member_code" placeholder="Enter user id" class="form-control" required="required">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Search</label><br>
                            <input type="submit" name="submit" value="Search" class="btn btn-success">
                        </div>

                    </form>

                </div>


                @if(isset($data['data']))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <h5 class="card-title mb-4">Upline Ranks</h5>
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
                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Sponsor Code</th>
                                                <th scope="col" class="border-0 fs-4 font-weight-medium">MT5 Name</th>
                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Wallet Address</th>
                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Rank</th>
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
                                                    <td><h5 class="font-weight-medium mb-1">{{$value['name']}}</h5></td>
                                                    <td><span class="badge badge-inverse fs-4">{{$value['refferal_code']}}</span></td>
                                                    <td>{{$value['sponser_code']}}</td>
                                                    <td>{{$value['mt5_name']}}</td>
                                                    <td>{{$value['wallet_address']}}</td>
                                                    <td><span class="badge badge-inverse fs-4">{{$value['rank']}}</span></td>
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


@include('includes.footerJs')
@include('includes.footer')
