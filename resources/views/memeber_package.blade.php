@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')


<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Update User</h4>
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

                        <form action="{{ route('searchMember') }}" enctype="multipart/form-data" method="post">
                            {{ method_field("POST") }}

                            @csrf

                            <div class="col-md-6 form-group">
                                <label>Member Code </label>
                                <input type="text" @if(isset($data['member_code'])) value="{{$data['member_code']}}" @endif name="member_code" placeholder="Enter user id / wallet address / name / email here" class="form-control" required="required">
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
            <!-- <div class="row">
                <div class="white-box">
                    <h3>Add Business</h3>
                    <div class="panel-body">
                    
                        <form action="{{ route('process_business') }}" enctype="multipart/form-data" method="post">
                            {{ method_field("POST") }}

                            @csrf
                            <div class="col-md-6 form-group">
                                <label> Strong Business </label>
                                <input type="number" name="power_leg_amt" placeholder="Enter Strong Leg Amount" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Weak Business </label>
                                <input type="number" name="weak_leg_amt" placeholder="Enter Weak Leg Amount" class="form-control">
                            </div>
                                <input type="hidden" name="user_id" class="form-control" @if(isset($data['user']['0']['id'])) value="{{$data['user']['0']['id']}}" @endif required="required">

                            <div class="col-md-6 form-group">
                                <label>Submit</label><br>
                                <input type="submit" name="submit" value="Submit" class="btn btn-success">
                            </div>

                        </form>

                    </div>
                </div>
            </div> -->
            @endif

            @if(isset($data['user']))
            <div class="row">
                <div class="white-box">
                    <div class="panel-body">
                        <form action="{{ route('updateUserDetails') }}" enctype="multipart/form-data" method="post">
                            {{ method_field("POST") }}

                            @csrf
                            <div class="col-md-3 form-group">
                                <label>Name </label>
                                <input type="text" @if(isset($data['user']['0']['name'])) value="{{$data['user']['0']['name']}}" @endif name="name" class="form-control">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Email </label>
                                <input type="hidden" name="user_id" @if(isset($data['user']['0']['id'])) value="{{$data['user']['0']['id']}}" @endif>
                                <input type="text" @if(isset($data['user']['0']['email'])) value="{{$data['user']['0']['email']}}" @endif name="email" class="form-control">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Wallet Address </label>
                                <input type="text" @if(isset($data['user']['0']['wallet_address'])) value="{{$data['user']['0']['wallet_address']}}" @endif name="wallet_address" class="form-control">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Status </label>
                                <select id='status' name="status" class="form-control">
                                    <option value=""> Select Status </option>
                                    <option value="1" @if(isset($data['user']['0']['status'])) @if($data['user']['0']['status']==1) selected="selected" @endif @endif> Unblock </option>
                                    <option value="0" @if(isset($data['user']['0']['status'])) @if($data['user']['0']['status']==0) selected="selected" @endif @endif> Block </option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Withdraw Status </label>
                                <select id='canWithdraw' name="canWithdraw" class="form-control">
                                    <option value=""> Select Status </option>
                                    <option value="1" @if(isset($data['user']['0']['canWithdraw'])) @if($data['user']['0']['canWithdraw']==1) selected="selected" @endif @endif> Unblock </option>
                                    <option value="0" @if(isset($data['user']['0']['canWithdraw'])) @if($data['user']['0']['canWithdraw']==0) selected="selected" @endif @endif> Block </option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Password </label>
                                <input type="text" name="password" class="form-control">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Update</label><br>
                                <input type="submit" name="submit" value="Update" class="btn btn-success">
                            </div>

                        </form>

                    </div>

                    <div class="table-responsive border-top manage-table px-4 py-3">
                        <table class="table no-wrap">
                            <thead>
                                <tr>
                                    <th scope="col" class="border-0">Name</th>
                                    <th scope="col" class="border-0">Member Code</th>
                                    <th scope="col" class="border-0">Current Package</th>
                                    <th scope="col" class="border-0">Packages</th>
                                    <th scope="col" class="border-0">Balance</th>
                                    <th scope="col" class="border-0">Amount</th>
                                    <th scope="col" class="border-0">Process</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($data['user']))
                                @foreach($data['user'] as $key => $value)
                                <form method="post" action="{{route('processpackagemember')}}">
                                    @method('POST')
                                    @csrf
                                    <tr class="advanced-table active">
                                        <td>{{$value['name']}}</td>
                                        <td>{{$value['refferal_code']}}</td>
                                        <td>@if(isset($data['current_package'])) {{$data['current_package']}} @else - @endif</td>
                                        <td>{{$value['packages']}}</td>
                                        <td>{{$value['balance']}}</td>
                                        <td>
                                            <input class="form-control" placeholder="Enter package amount." name="amount" id="amount" type="amount" required>
                                        </td>
                                        <td>
                                            <input type="hidden" name="user_id" value="{{$value['id']}}">
                                            <input type="submit" name="submit" value="Process" class="btn btn-success">
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