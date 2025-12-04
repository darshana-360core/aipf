@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Deposit Report</h4>
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
                                        <th>Id</th>
                                        <th>User Id</th>
                                        <th>Join Date</th>
                                        <th>Sponsor Code</th>
                                        <th>Level</th>
                                        <th>Amount</th>
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
                                            <td>{{$pvalue['refferal_code']}}</td>
                                            <td>{{date('d-m-Y H:i', strtotime($pvalue['joining']))}}</td>
                                            <td>{{$pvalue['sponser_code']}}</td>
                                            <td>{{$pvalue['level']}}</td>
                                            <td>{{$pvalue['amount']}}</td>
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

@include('includes.footerJs')
<script>
	$(document).ready(function () {
	    $('#example').DataTable();
	});
</script>
@include('includes.footer')
