@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Verify Deposit</h4>
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
                                        <th>Amount</th>
                                        <th>Amount in Usdt</th>
                                        <th>Proof/Link</th>
                                        <th>Approve</th>
                                        <th>Reject</th>
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
                                            <td>{{$pvalue['amount']}}</td>
                                            <td>{{($pvalue['amount'] / $pvalue['usdt_conversion'])}}</td>
                                            @if($pvalue['transaction_hash'] == "By Other")
                                                <td><a href="https://ai.vitnixx.com/storage/{{$pvalue['proof']}}" target="_blank">View</a></td>
                                            @else
                                                <td><a href="https://polygonscan.com/tx/{{$pvalue['transaction_hash']}}" target="_blank">View</a></td>
                                            @endif
                                            <td>
                                                <form action="{{route('depositOtherProcess')}}" method="POST" onsubmit="disableButtonAndSubmit(this); return false;">
                                                    <input type="hidden" name="decision" value="1">
                                                    <input type="hidden" name="ptid" value="{{$pvalue['id']}}">
                                                    <input type="text" name="remark" placeholder="Enter your remarks" class="form-control" >
                                                    <input type="submit" class="btn btn-success" name="submit" value="Accept">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{route('depositOtherProcess')}}" method="POST" onsubmit="disableButtonAndSubmit(this); return false;">
                                                    <input type="hidden" name="decision" value="0">
                                                    <input type="hidden" name="ptid" value="{{$pvalue['id']}}">
                                                    <input type="text" name="remark" placeholder="Enter your remarks" class="form-control" >
                                                    <input type="submit" class="btn btn-danger" name="submit" value="Reject">
                                                </form>
                                            </td>
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
    function disableButtonAndSubmit(form) {
        const submitButton = form.querySelector('input[type="submit"]');
        submitButton.disabled = true;
        submitButton.value = 'Processing...';
        form.submit();
    }
</script>
<script>
	$(document).ready(function () {
	    $('#example').DataTable();
	});
</script>
@include('includes.footer')
