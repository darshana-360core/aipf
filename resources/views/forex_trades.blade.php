@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Forex Trades</h4>
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

                    @if(isset($data['editData']))
                    @php
                    $editData = $data['editData'];
                    @endphp
                    <form action="{{ route('forex_trades.update', $editData['id']) }}" enctype="multipart/form-data" method="post">
                    	{{ method_field("PUT") }}
                    @else
                    <form action="{{ route('forex_trades.store') }}" enctype="multipart/form-data" method="post">
                    	{{ method_field("POST") }}

                    @endif
                            @csrf
                        <div class="col-md-3 form-group">
                            <label>Currency </label>
                            <select id='currency' name="currency" class="form-control" required="required">
                                <option value=""> Select Currency </option>
                                <!-- <option value="EURUSD" @if(isset($editData['currency'])) @if($editData['currency'] == "EURUSD") selected="selected" @endif @endif> EURUSD </option> -->
                                <!-- <option value="QUREUR" @if(isset($editData['currency'])) @if($editData['currency'] == "QUREUR") selected="selected" @endif @endif> QUREUR </option> -->
                                <option value="XAUUSD" @if(isset($editData['currency'])) @if($editData['currency'] == "XAUUSD") selected="selected" @endif @endif> XAUUSD </option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Order Type </label>
                            <select id='order_type' name="order_type" class="form-control" required="required">
                                <option value=""> Select Order Type </option>
                                <option value="BUY" @if(isset($editData['order_type'])) @if($editData['order_type'] == "BUY") selected="selected" @endif @endif> BUY </option>
                                <option value="SELL" @if(isset($editData['order_type'])) @if($editData['order_type'] == "SELL") selected="selected" @endif @endif> SELL </option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Order Status </label>
                            <select id='order_status' name="order_status" class="form-control" required="required">
                                <option value=""> Select Order Status </option>
                                <option value="1" @if(isset($editData['order_status'])) @if($editData['order_status'] == 1) selected="selected" @endif @endif> Open </option>
                                <option value="0" @if(isset($editData['order_status'])) @if($editData['order_status'] == 0) selected="selected" @endif @endif> Closed </option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label>MIN PNL RANGE %</label>
                            <input type="text" id='min_pnl' @if(isset($editData['min_pnl'])) value="{{$editData['min_pnl']}}" @endif name="min_pnl" class="form-control" required="required">
                        </div>

                        <div class="col-md-3 form-group">
                            <label>MAX PNL RANGE %</label>
                            <input type="text" id='max_pnl' @if(isset($editData['max_pnl'])) value="{{$editData['max_pnl']}}" @endif name="max_pnl" class="form-control" required="required">
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Display Status </label>
                            <select id='display_status' name="display_status" class="form-control" required="required">
                                <option value=""> Select Display Status </option>
                                <option value="1" @if(isset($editData['display_status'])) @if($editData['display_status'] == 1) selected="selected" @endif @endif> Show </option>
                                <option value="0" @if(isset($editData['display_status'])) @if($editData['display_status'] == 0) selected="selected" @endif @endif> Hide </option>
                            </select>
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
                    <br><br><br>
                    <br><br><br>
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Currency</th>
                                            <th>Order Type</th>
                                            <th>Order Status</th>
                                            <th>PNL RANGE %</th>
                                            <th>Display Status</th>
                                            <th>Action</th>
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
                                            <td>{{$pvalue['currency']}}</td>
                                            <td>{{$pvalue['order_type']}}</td>
                                            <td>{{$pvalue['order_status'] == 1 ? "Open" : "Close"}}</td>
                                            <td>{{$pvalue['min_pnl']}} / {{$pvalue['max_pnl']}}</td>
                                            <td>{{$pvalue['display_status'] == 1 ? "Show" : "Hide"}}</td>
                                            <td><a href="{{ route('forex_trades.edit',$pvalue['id'])}}"><button style="float:left;" type="button" class="btn btn-info btn-outline btn-circle btn m-r-5"><i class="ti-pencil-alt"></i></button></a>
<!--                                             <form action="{{ route('forex_trades.destroy', $pvalue['id'])}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="float:left;" onclick="return confirmDelete();" class="btn btn-info btn-outline btn-circle btn m-r-5"><i class="ti-trash"></i></button>
                                            </form> -->
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
</div>

@include('includes.footerJs')
<script>
	$(document).ready(function () {
	    $('#example').DataTable();
	});
</script>
@include('includes.footer')
