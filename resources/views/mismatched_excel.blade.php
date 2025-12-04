@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Mismatched MT5 {{$data['responseExcel']}}</h4>
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
                            @if($data['responseExcel'] == 'Balance Excel')
                                <table id="example" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>MT5 Account</th>
                                            <th>Name</th>
                                            <th>Volume</th>
                                            <th>Balance</th>
                                            <th>Date</th>
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
                                                <td>{{$pvalue['mt_acc']}}</td>
                                                <td>{{$pvalue['name']}}</td>
                                                <td>{{$pvalue['volume']}}</td>
                                                <td>{{$pvalue['balance']}}</td>
                                                <td>{{date('d-m-Y', strtotime($pvalue['date']))}}</td>
                                        </tr>
                                    @php
                                    $j++;
                                    @endphp
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            @else
                                <table id="example" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>MT5 Account</th>
                                            <th>Profit</th>
                                            <th>Date</th>
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
                                                <td>{{$pvalue['copier_acc']}}</td>
                                                <td>{{$pvalue['amount_paid_to_signal']}}</td>
                                                <td>{{date('d-m-Y', strtotime($pvalue['date']))}}</td>
                                        </tr>
                                    @php
                                    $j++;
                                    @endphp
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

@include('includes.footerJs')
<script>

$(document).ready(function () {

    var table = $('#example').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 100,
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5'
        ]
    } );

});

</script>
@include('includes.footer')
