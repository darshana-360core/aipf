@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Orbitx Pools</h4>
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
                    <form action="{{ route('orbitx-pool.update', $editData['id']) }}" enctype="multipart/form-data" method="post">
                    	{{ method_field("PUT") }}
                    @else
                    <form action="{{ route('orbitx-pool.store') }}" enctype="multipart/form-data" method="post">
                    	{{ method_field("POST") }}

                    @endif
                @csrf

                <div class="row">
                    <div class="col-md-3 form-group">
                        <label>Founder Pool</label>
                        <input type="text" id="founder_pool_amount" @if(isset($editData['founder_pool_amount'])) value="{{$editData['founder_pool_amount']}}" @endif name="founder_pool_amount" placeholder="Enter Founder Pool Amount" class="form-control" required>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Promoter Pool</label>
                        <input type="text" id="promoter_pool_amount" @if(isset($editData['promoter_pool_amount'])) value="{{$editData['promoter_pool_amount']}}" @endif name="promoter_pool_amount" placeholder="Enter Promoter Pool Amount" class="form-control" required>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Marketing Pool</label>
                        <input type="text" id="marketing_pool_amount" @if(isset($editData['marketing_pool_amount'])) value="{{$editData['marketing_pool_amount']}}" @endif name="marketing_pool_amount" placeholder="Enter Marketing Pool Amount" class="form-control" required>
                    </div>

                    <div class="col-md-3 form-group">
					    <label for="month_pool">Pool Month</label>
					    <select id="month_pool" name="month_pool" class="form-control" required>
					        <option value="">-- Select Month --</option>
					        @php
					            $months = [
					                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
					                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
					                9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
					            ];
					        @endphp
					        @foreach($months as $num => $name)
					            <option value="{{ $num }}" {{ (isset($editData['month_pool']) && $editData['month_pool'] == $num) ? 'selected' : '' }}>
					                {{ $name }}
					            </option>
					        @endforeach
					    </select>
					</div>
                </div>

                <div class="row">
                    <div class="col-md-3 form-group">
                        <label>&nbsp;</label><br>
                        <input type="submit" name="submit" value="Save" class="btn btn-success btn-block mt-2">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

	@if(isset($data['data']))
        <div class="row mt-4">
		    <div class="col-md-12">
		        <div class="white-box">
		            <div class="d-flex justify-content-between align-items-center mb-3">
		                <h4 class="page-title">All Pool Entries</h4>
		            </div>

		            <div class="table-responsive">
		                <table id="orbitx-pools-table" class="table table-striped table-bordered">
		                    <thead class="thead-dark">
		                        <tr>
		                            <th>Marketing Pool</th>
		                            <th>Promoter Pool</th>
		                            <th>Founder Pool</th>
		                            <th>Pool Month</th>
		                            <th>Date</th>
		                            <th>Action</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        @foreach($data['data'] as $key => $value)
		                            <tr>
		                                <td>${{ number_format($value['marketing_pool_amount'], 2) }}</td>
		                                <td>${{ number_format($value['promoter_pool_amount'], 2) }}</td>
		                                <td>${{ number_format($value['founder_pool_amount'], 2) }}</td>
		                                <td>
		                                    @php
		                                        $months = [
		                                            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
		                                            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
		                                            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
		                                        ];
		                                        echo $months[$value['month_pool']] ?? $value['month_pool'];
		                                    @endphp
		                                </td>
		                                <td>{{ date('d-m-Y', strtotime($value['created_on'])) }}</td>
		                                <td><a href="{{ route('orbitx-pool.edit',$value['id'])}}"><button style="float:left;" type="button" class="btn btn-info btn-outline btn-circle btn m-r-5"><i class="ti-pencil-alt"></i></button></a></td>
		                            </tr>
		                        @endforeach
		                    </tbody>
		                </table>
		            </div>
		        </div>
		    </div>
		</div>
	@endif

    </div>
</div>

@include('includes.footerJs')
<script>
    $(document).ready(function () {
        $('#orbitx-pools-table').DataTable({
            responsive: true,
            pageLength: 10,
            ordering: true,
            language: {
                searchPlaceholder: "Search pools...",
                search: "",
            }
        });
    });
</script>
@include('includes.footer')
