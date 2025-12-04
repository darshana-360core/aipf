@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Users</h4>
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
                        <form action="{{ route('withdraw_stop') }}" enctype="multipart/form-data" method="get">
                            {{ method_field("GET") }}

                            @csrf
                            <div class="col-md-2 form-group">
                                <label>User id </label>
                                <input type="text" @if(isset($data['search'])) value="{{$data['search']}}" @endif name="search" placeholder="Enter user id / wallet address" class="form-control">
                            </div>

                            <div class="col-md-2 form-group">
                                <label>Search</label><br>
                                <input type="submit" name="submit" value="Search" class="btn btn-success">
                            </div>

                        </form>
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Wallet Address</th>
                                            <th>User Id</th>
                                            <th>Roi Stop Date</th>
                                            <th>Level Stop Date</th>
                                            <th colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $j=1;
                                        @endphp
                                        @if(isset($data['data']))
                                        @foreach($data['data']['data'] as $pkey => $pvalue)
                                        <tr>
                                            <td>{{$j}}</td>
                                            <td>{{$pvalue['name']}}</td>
                                            <td>{{$pvalue['email']}}</td>
                                            <td>{{$pvalue['wallet_address']}}</td>
                                            <td>{{$pvalue['refferal_code']}}</td>
                                            @if($pvalue['roi_stop_date']==NULL)
                                                <td>
                                                    -
                                                </td>
                                            @else
                                                <td>{{$pvalue['roi_stop_date']}}</td>
                                            @endif
                                            @if($pvalue['level_stop_date']==NULL)
                                            <td>
                                                -
                                            </td>
                                            @else
                                            <td>{{$pvalue['level_stop_date']}}</td>
                                            @endif
                                            <td>
                                                @if($pvalue['roi_stop_date']==NULL)
                                                    <form action="{{route('update_roi_stop_date')}}" method="POST">
                                                        @method('post')
                                                        @csrf
                                                        <input type="hidden" name="user_id" value="{{$pvalue['id']}}">

                                                        <input type="submit" name="submit" value="Stop Roi" class="btn btn-info">
                                                    </form>    
                                                @endif
                                                @if($pvalue['level_stop_date']==NULL)
                                                    <form action="{{route('update_level_stop_date')}}" method="POST">
                                                        @method('post')
                                                        @csrf
                                                        <input type="hidden" name="user_id" value="{{$pvalue['id']}}">

                                                        <input type="submit" name="submit" value="Stop Level" class="btn btn-info">
                                                    </form>    
                                                @endif
                                            </td>

                                        </tr>
                                        @php
                                        $j++;
                                        @endphp
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>

                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_simple_numbers" id="example_paginate">
                                        <ul class="pagination">
                                            @foreach($data['data']['links'] as $key => $value)
                                            @if($value['url'] != null)
                                            <li class="paginate_button page-item @if($value['active'] == " true") active @endif"><a href="{{$value['url']}}" aria-controls="example" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $value['label']; ?></a></li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('includes.footerJs')

    <script>
        $(function() {
            $('.start-date').datepicker({
                dateFormat: 'dd-mm-yy'
            });
            $('.end-date').datepicker({
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>
    @include('includes.footer')