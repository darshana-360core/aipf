@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')


<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Add User Balance</h4>
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

                    <form action="{{ route('searchUserForAddBalance') }}" enctype="multipart/form-data" method="post">
                        {{ method_field("POST") }}

                        @csrf

                        <div class="col-md-6 form-group">
                            <label>Member Code </label>
                            <input type="text" @if(isset($data['search'])) value="{{$data['search']}}" @endif name="search" placeholder="Enter user id" class="form-control" required="required">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Search</label><br>
                            <input type="submit" name="submit" value="Search" class="btn btn-success">
                        </div>

                    </form>

                </div>
            </div>
        </div>

    @if(isset($data['user']))
        <div class="row">
                <div class="white-box">

                        <div class="table-responsive border-top manage-table px-4 py-3" >
                            <table class="table no-wrap">
                              <thead>
                                <tr>
                                  <th scope="col" class="border-0">Name</th>
                                  <th scope="col" class="border-0">Member Code</th>
                                  <th scope="col" class="border-0">MT5 Id</th>
                                  <th scope="col" class="border-0">MT5 Status</th>
                                  <th scope="col" class="border-0">All Balance</th>
                                  <th scope="col" class="border-0">Profit Sharing Balance</th>
                                  <th scope="col" class="border-0">Amount</th>
                                  <th scope="col" class="border-0">Remarks</th>
                                  <th scope="col" class="border-0">Process</th>
                                </tr>
                              </thead>
                              <tbody>
                                    @if(isset($data['user']))
                                        @foreach($data['user'] as $key => $value)       
                                        <form method="post" action="{{route('addUserBalance')}}">
                                            <tr class="advanced-table active">
                                                <td>{{$value['name']}}</td>
                                                <td>{{$value['refferal_code']}}</td>
                                                <td>{{$value['mt5']}}</td>
                                                <td>@if(empty($value['mt5']))
                                                    {{"MT5 not submitted"}}
                                                @else
                                                    @if($value['mt5_verify'] == 0)
                                                        {{ "Pending" }}
                                                    @elseif($value['mt5_verify'] == 1)
                                                        {{ "Verified" }}
                                                    @else
                                                        {{ "Rejected" }}
                                                    @endif
                                                @endif
                                                </td>
                                                <td>{{$data['allIncome']}}</td>
                                                <td>{{$data['profitSharingIncome']}}</td>
                                                <td>
                                                    <input class="form-control" placeholder="Enter withdraw amount." name="amount" id="amount" type="amount" required>
                                                </td>
                                                <td>
                                                    <input class="form-control" placeholder="Enter Remarks." name="remarks" id="remarks" type="text" required>
                                                </td>
                                                <td>
                                                    @if($value['mt5_verify'] == 1)
                                                    <input type="hidden" name="user_id" value="{{$value['id']}}">
                                                    <input type="submit" name="submit" value="Process" class="btn btn-success">
                                                    @else
                                                        <p>Please ask user to create MT5 Account</p>
                                                    @endif
                                                </td>
                                        </form>
                                            </tr>
                                        @endforeach
                                    @endif
                              </tbody>
                            </table>
                          </div>
                </div>
            </div>
        @endif
    </div>
</div>


@include('includes.footerJs')
@include('includes.footer')
