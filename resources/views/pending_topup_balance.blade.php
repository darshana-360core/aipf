@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Pending Topup Balance</h4>
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
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sr</th>
                                            <th>Amount</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Update User</th>
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
                                            <td>{{$pvalue['amount']}}</td>
                                            <td>{{$pvalue['from_user_name']}}</td>
                                            <td>{{$pvalue['to_user_name']}}</td>
                                            <td>
                                                <div class='d-flex items-center gap-2'>
                                                    <form action="{{route('process_pending_topup_balance')}}" method="POST" class='me-2'>
                                                    @method('post')
                                                    @csrf
                                                    <input type="hidden" name="tid" value="{{$pvalue['id']}}">
                                                    <input type="hidden" name="status" value="1">

                                                    <input type="submit" name="submit" value="Accept" class="btn btn-success">
                                                </form>

                                                <form action="{{route('process_pending_topup_balance')}}" method="POST">
                                                    @method('post')
                                                    @csrf
                                                    <input type="hidden" name="tid" value="{{$pvalue['id']}}">
                                                    <input type="hidden" name="status" value="2">

                                                    <input type="submit" name="submit" value="Reject" class="btn btn-danger">
                                                </form>
                                                </div>
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