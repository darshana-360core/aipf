@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')


<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">User Details</h4> 
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

                    <form action="{{ route('userDetails') }}" enctype="multipart/form-data" method="post">
                        {{ method_field("POST") }}

                        @csrf

                        <div class="col-md-6 form-group">
                            <label>Member Code </label>
                            <input type="text" @if(isset($data['member_code'])) value="{{$data['member_code']}}" @endif name="member_code" class="form-control" required="required">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Search</label><br>
                            <input type="submit" name="submit" value="Search" class="btn btn-success">
                        </div>

                    </form>

                </div>
            </div>
            @if(isset($data['data']))

                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">
                        <h3 class="card-title">User Details</h3>
                        <div class="row">
                          <div class="col-lg-6 col-md-6 col-sm-6">
                            <h4 class="box-title mt-5">{{$data['data']['refferal_code']}}</h4>
                            <h2 class="mt-5">
                              ${{number_format($data['data']['matching_income'] + $data['data']['bonus_income'] + $data['data']['binary_income'] + $data['data']['roi_income'] - $data['withdraw'] ,2)}} <small class="text-success">Balance</small>
                            </h2>
                            <h2 class="mt-5">
                              ${{$data['withdraw']}} <small class="text-danger">Withdrawn</small>
                            </h2>
                            <h3 class="box-title mt-5">Incomes</h3>
                            <ul class="list-group list-group-flush ps-0">
                              <li class="
                                  list-group-item
                                  border-bottom-0
                                  py-1
                                  px-0
                                  text-muted
                                ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-primary feather-sm me-2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                ${{number_format($data['data']['matching_income'],2)}} <b>MATCHING INCOME</b>
                              </li>
                              <li class="
                                  list-group-item
                                  border-bottom-0
                                  py-1
                                  px-0
                                  text-muted
                                ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-primary feather-sm me-2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                ${{number_format($data['data']['bonus_income'],2)}} <b>REFERRAL INCOME</b>
                              </li>
                              <li class="
                                  list-group-item
                                  border-bottom-0
                                  py-1
                                  px-0
                                  text-muted
                                ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-primary feather-sm me-2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                ${{number_format($data['data']['roi_income'],2)}} <b>ROI INCOME</b>
                              </li>
                              <li class="
                                  list-group-item
                                  border-bottom-0
                                  py-1
                                  px-0
                                  text-muted
                                ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-primary feather-sm me-2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                ${{number_format($data['data']['binary_income'],2)}} <b>BINARY INCOME</b>
                              </li>
                            </ul>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-6">
                            <h3 class="box-title mt-5">Member Info</h3>
                            <div class="table-responsive">
                              <table class="table">
                                <tbody>
                                  <tr>
                                    <td width="390">Left Team</td>
                                    <td>{{$data['data']['left_team']}}</td>
                                  </tr>
                                  <tr>
                                    <td>Right Team</td>
                                    <td>{{$data['data']['right_team']}}</td>
                                  </tr>
                                  <tr>
                                    <td width="390">Left Direct</td>
                                    <td>{{$data['data']['left_direct']}}</td>
                                  </tr>
                                  <tr>
                                    <td>Right Direct</td>
                                    <td>{{$data['data']['right_direct']}}</td>
                                  </tr>
                                  <tr>
                                    <td width="390">Left Business</td>
                                    <td>{{$data['data']['left_business']}}</td>
                                  </tr>
                                  <tr>
                                    <td>Right Business</td>
                                    <td>{{$data['data']['right_business']}}</td>
                                  </tr>
                                  <tr>
                                    <td>Pending Withdraw</td>
                                    <td>{{$data['pending_withdraw']}}</td>
                                  </tr>
                                  <tr>
                                    <td style="font-weight: bold;">All Packages</td>
                                    <td style="font-weight: bold;">Activation Date</td>
                                  </tr>
                                  @php
                                    $iAmount = 0;
                                  @endphp
                                  @foreach($data['packages'] as $key => $value)
                                    <tr>
                                      <td width="390">${{$value['amount']}}</td>
                                      <td>{{date('d-m-Y', strtotime($value['created_on']))}}</td>
                                    </tr>
                                    @php
                                      $iAmount += $value['amount'];
                                    @endphp
                                  @endforeach
                                  <tr>
                                    <td style="font-weight: bold;">Total Investment</td>
                                    <td style="font-weight: bold;">{{$iAmount}}</td>
                                  </tr>
                                </tbody>
                              </table>
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

@include('includes.footerJs')
@include('includes.footer')

