@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">User Rank Report</h4>
            </div>
        </div>
        <div class="row">
            <div class="white-box">
                <div class="panel-body">
                    <div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs member-tab" role="tablist">
                            <li role="presentation" class="active"><a href="#all_members" aria-controls="all_members"
                                    role="tab" data-toggle="tab">User Rank Report</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all_members">
                                <div class="search-form export-form">
                                    <form action="{{route('userRankReport')}}" method="post" class="mb-0">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group">
                                                <input id="refferal_code" name="refferal_code" @if(isset($data['refferal_code'])) value="{{$data['refferal_code']}}" @endif type="text" class="form-control" placeholder="Enter Wallet Address">
                                            </div>
                                            <div class="form-group">
                                                <select name="level" class="form-control">
                                                    <option value="">Select Type</option>
                                                    <option value="1" @if(isset($data['level'])) @if($data['level'] == '1') selected @endif @endif>Nova</option>
                                                    <option value="2" @if(isset($data['level'])) @if($data['level'] == '2') selected @endif @endif>Vibe</option>
                                                    <option value="3" @if(isset($data['level'])) @if($data['level'] == '3') selected @endif @endif>Core</option>
                                                    <option value="4" @if(isset($data['level'])) @if($data['level'] == '4') selected @endif @endif>Flux</option>
                                                    <option value="5" @if(isset($data['level'])) @if($data['level'] == '5') selected @endif @endif>Pulse</option>
                                                    <option value="6" @if(isset($data['level'])) @if($data['level'] == '6') selected @endif @endif>Sync</option>
                                                    <option value="7" @if(isset($data['level'])) @if($data['level'] == '7') selected @endif @endif>Neura</option>
                                                    <option value="8" @if(isset($data['level'])) @if($data['level'] == '8') selected @endif @endif>Quantum</option>
                                                    <option value="9" @if(isset($data['level'])) @if($data['level'] == '9') selected @endif @endif>Vertex</option>
                                                    <option value="10" @if(isset($data['level'])) @if($data['level'] == '10') selected @endif @endif>Sigma</option>
                                                    <option value="11" @if(isset($data['level'])) @if($data['level'] == '11') selected @endif @endif>Alpha</option>
                                                    <option value="12" @if(isset($data['level'])) @if($data['level'] == '12') selected @endif @endif>Omega</option>
                                                    <option value="13" @if(isset($data['level'])) @if($data['level'] == '13') selected @endif @endif>Zenith</option>
                                                    <option value="14" @if(isset($data['level'])) @if($data['level'] == '14') selected @endif @endif>Matrix</option>
                                                    <option value="15" @if(isset($data['level'])) @if($data['level'] == '15') selected @endif @endif>Apex</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn waves-effect waves-light btn-success">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="export-section">
                                    <a href="{{ url()->current() }}?export=yes&refferal_code={{ request('refferal_code') }}&level={{ request('level') }}">
                                        <button type="button" class="btn waves-effect waves-light btn-info">Export Excel</button>
                                    </a>
                                </div>
                                @if(isset($data['data']))
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <h5 class="card-title mb-4">All Members</h5>
                                                <div class="table-responsive">
                                                    <table class="table no-wrap user-table mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                               <!--  <th scope="col" class="border-0 fs-4 font-weight-medium ps-4">
                                                                    <div class="form-check border-start border-2 border-info ps-1">
                                                                        <input type="checkbox" class="form-check-input ms-2" id="inputSchedule" name="inputCheckboxesSchedule">
                                                                        <label for="inputSchedule" class="form-check-label ps-2 fw-normal"></label>
                                                                    </div>
                                                                </th> -->
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Sr</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Wallet Address</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Member Code</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Amount</th>
                                                                <th scope="col" class="border-0 fs-4 font-weight-medium">Level</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(isset($data['data']['data']))
                                                            @foreach($data['data']['data'] as $key => $value)
                                                            @php
                                                                $levels = [
                                                                    1  => 'Nova',
                                                                    2  => 'Vibe',
                                                                    3  => 'Core',
                                                                    4  => 'Flux',
                                                                    5  => 'Pulse',
                                                                    6  => 'Sync',
                                                                    7  => 'Neura',
                                                                    8  => 'Quantum',
                                                                    9  => 'Vertex',
                                                                    10 => 'Sigma',
                                                                    11 => 'Alpha',
                                                                    12 => 'Omega',
                                                                    13 => 'Zenith',
                                                                    14 => 'Matrix',
                                                                    15 => 'Apex',
                                                                ];
                                                            @endphp

                                                                <tr>
                                                                    <td>
                                                                        <h5 class="font-weight-medium mb-1">{{$key + 1}}</h5>
                                                                        <!-- <a href="javascript:void(0);" class="font-14 text-muted"></a> -->
                                                                    </td>
                                                                    <td><span>{{ substr($value['wallet_address'], 0, 6) . '...' . substr($value['wallet_address'], -6) }}</span></td>

                                                                    <td><span>{{$value['refferal_code']}}</span></td>
                                                                    <td><span>{{number_format($value['total_amount'],3)}}</span></td>
                                                                    <td><span>{{ $levels[$value['level']] ?? '-' }}</span></td>
                                                                </tr>
                                                            @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>

                                                    <div class="col-sm-12 col-md-7">
                                                        <div class="dataTables_paginate paging_simple_numbers" id="example_paginate">
                                                            <ul class="pagination">
                                                            @if(isset($data['data']['data']))
                                                                @foreach($data['data']['links'] as $key => $value)
                                                                    @if($value['url'] != null)
                                                                        <li class="paginate_button page-item @if($value['active'] == "true") active @endif"><a href="{{$value['url']}}&refferal_code={{$data['refferal_code']}}&level={{$data['level']}}" aria-controls="example" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $value['label']; ?></a></li>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
    <script>
        $(function() {
            $('.start-date').datepicker({ dateFormat: 'dd-mm-yy' });
            $('.end-date').datepicker({ dateFormat: 'dd-mm-yy' });
        });
    </script>
    @include('includes.footer')