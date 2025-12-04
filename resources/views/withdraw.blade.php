@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Withdraw History</h4>
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
                                    <th>Paid Date</th>
                                    <th>Withdraw Date</th>
                                    <th>Member Code</th>
                                    <th>Wallet Address</th>
                                    <th>Paid Amount</th>
                                    <th>Blc Price</th>
                                    <th>TXN Hash</th>
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
                                    <td class="txnDate{{$j}}">{{isset($pvalue['processed_date']) ? date('d-m-Y', strtotime($pvalue['processed_date'])) : "-"}}</td>
                                    <td>{{date('d-m-Y', strtotime($pvalue['created_on']))}}</td>
                                    <td>{{$pvalue['refferal_code']}}</td>
                                    <td>{{$pvalue['wallet_address']}}</td>
                                    <td>${{number_format($pvalue['amount'])}}</td>
                                    <td>{{$pvalue['blc_price'] > 0 ? "$".number_format($pvalue['blc_price'], 3) : ""}}</td>
                                    <td><a href="https://polygonscan.com/tx/{{$pvalue['transaction_hash']}}" target="_blank">View</a><span class="txnHash" data-value="{{$j}}" style="display: none">{{$pvalue['transaction_hash']}}</span></td>
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
<script>
	$(document).ready(function () {
	    $('#example').DataTable();
	});

    $(".txnHash").each(async (s, d) => {
        console.log(s.innerText)
    })
</script>
@include('includes.footer')
