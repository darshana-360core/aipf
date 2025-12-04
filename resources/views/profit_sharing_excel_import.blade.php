@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')


<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Ranking Excel Import</h4> 
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

                    <form action="{{ route('profitSharingExcel.store') }}" enctype="multipart/form-data" method="post">
                        {{ method_field("POST") }}

                        @csrf

                        <div class="col-md-4 form-group">
                            <label>Date </label>
                            <input type="text" name="date" value="{{date('Y-m-d', strtotime('-1 day'))}}" readonly class="form-control" required="required">
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Question</label>
                            <input type="file" name="file" required="required">
                        </div>

                        <div class="col-md-4 form-group">
                          @if(isset($data['editData']))
                          <label>Update</label><br>
                            <input type="submit" name="submit" value="Update" class="btn btn-success">
                            @else
                            <label>Save</label><br>
                            <input type="submit" name="submit" value="Submit" class="btn btn-success">
                            @endif
                        </div>

                    </form>

                    <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Is Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                            $j=1;
                            @endphp
                            @if(isset($data['data']))
                                @foreach($data['data'] as $pkey => $pvalue)
                                <tr>
                                    <td>{{$j}}</td>
                                    <td>{{$pvalue['date']}}</td>
                                    <td>@if($pvalue['isSynced'] == 0) "PENINDG" @else "COMPLETE" @endif</td>
                                </tr>
                            @php
                            $j++;
                            @endphp
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    </div>

                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <h4 class="title"> Excel History </h4>
                    <div class="table-responsive">
                        <table id="example" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Total Users</th>
                                    <th>Total Company Profit</th>
                                    <th>Total Client Profit</th>
                                    <th>Download File</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                            $j=1;
                            @endphp
                            @if(isset($data['excel']))
                                @foreach($data['excel'] as $pkey => $pvalue)
                                <tr>
                                    <td>{{$j}}</td>
                                    <td>{{$pvalue['date']}}</td>
                                    <td>{{$pvalue['total_users']}}</td>
                                    <td>{{$pvalue['total_amount_paid_to_signal']}}</td>
                                    <td>{{$pvalue['total_signal_amount']}}</td>
                                    <td><a href="{{asset('storage/'.$pvalue['file_name'])}}">Download</a></td>
                                </tr>
                            @php
                            $j++;
                            @endphp
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.footerJs')
@include('includes.footer')

