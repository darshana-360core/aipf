@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Bank Details</h4> </div>
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

                    <form action="{{ route('bank-details.store') }}" enctype="multipart/form-data" method="post">
                    	{{ method_field("POST") }}
                            @csrf

                        <div class="col-md-3 form-group">
                            <label>Account Holder Name </label>
                            <input type="text" id='account_holder_name' @if(isset($data['data']['account_holder_name'])) value="{{$data['data']['account_holder_name']}}" @endif name="account_holder_name" class="form-control" required="required">
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Bank Name </label>
                            <input type="text" id='bank_name' @if(isset($data['data']['bank_name'])) value="{{$data['data']['bank_name']}}" @endif name="bank_name" class="form-control" required="required">
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Account Number </label>
                            <input type="text" id='account_number' @if(isset($data['data']['account_number'])) value="{{$data['data']['account_number']}}" @endif name="account_number" class="form-control" required="required">
                        </div>

                        <div class="col-md-3 form-group">
                            <label>IFSC Code </label>
                            <input type="text" id='ifsc_code' @if(isset($data['data']['ifsc_code'])) value="{{$data['data']['ifsc_code']}}" @endif name="ifsc_code" class="form-control" required="required">
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Deposit Wallet Address </label>
                            <input type="text" id='deposit_address' @if(isset($data['data']['deposit_address'])) value="{{$data['data']['deposit_address']}}" @endif name="deposit_address" class="form-control" required="required">
                        </div>

                        <div class="col-md-3 form-group">
                        	<label>Update</label><br>
                            <input type="submit" name="submit" value="Update" class="btn btn-success">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.footerJs')
@include('includes.footer')
