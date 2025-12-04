@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')


<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Roi Distribution Excel Import</h4> 
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

                    <form action="{{ route('roi-distribution-import.store') }}" enctype="multipart/form-data" method="post">
                        {{ method_field("POST") }}

                        @csrf

                        <div class="col-md-3 form-group">
                            <label>Date </label>
                            <input type="text" name="date" value="{{date('Y-m-d')}}" readonly class="form-control" required="required">
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Roi Excel</label>
                            <input type="file" name="file" required="required">
                        </div>

                        <div class="col-md-3 form-group">
                          <label>Download Demo File</label><br>
                            <a href="#" target="_blank">
                                <input type="button" value="Download Demo" class="btn btn-info">
                            </a>
                        </div>

                        <div class="col-md-3 form-group">
                          @if(isset($data['editData']))
                          <label>Update</label><br>
                            <input type="submit" name="submit" value="Update" class="btn btn-success">
                            @else
                            <label>Save</label><br>
                            <input type="submit" name="submit" value="Submit" class="btn btn-success">
                            @endif
                        </div>

                    </form>

                    <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Roi</th>
                                    <th>Date</th>
                                    <th>Download File</th>
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
                                    <td>{{$pvalue['roi']}}</td>
                                    <td>{{$pvalue['date']}}</td>
                                    <td><a href="{{asset('storage/'.$pvalue['file_name'])}}">Download</a></td>
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
@include('includes.footer')

