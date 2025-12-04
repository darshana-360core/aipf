@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Team Strong Business</h4>
            </div>
        </div>

        <div class="row">
            <div class="white-box">
                <div class="panel-body">

                    {{-- Alert Message --}}
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

                    {{-- Form Start --}}
                    <form action="{{ route('process_team_strong_business') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>First Wallet Address</label>
                                <input type="text" name="first_wallet_address" class="form-control" placeholder="Enter first wallet address" required>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Last Wallet Address</label>
                                <input type="text" name="last_wallet_address" class="form-control" placeholder="Enter last wallet address" required>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Business Amount</label>
                                <input type="number" step="0.01" name="business" class="form-control" placeholder="Enter business amount" required>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>
                                    <input type="checkbox" name="isForced" value="1">
                                    Enable Force Mode
                                </label>
                                <!-- <br> -->
                                <!-- <small class="text-muted">Leave unchecked for Normal Mode</small> -->
                            </div>


                            <div class="col-md-6 form-group">
                                <label>Submit</label><br>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                    {{-- Form End --}}
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.footerJs')
@include('includes.footer')
