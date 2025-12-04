@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Website Popup</h4>
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
                        <form action="{{ route('add_website_popup') }}" enctype="multipart/form-data" method="post">
                    	    {{ method_field("POST") }}
                                @csrf
                            <div class="col-md-3 form-group">
                                <label>Title </label>
                                <input type="text" id='title' name="title" class="form-control">
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Image </label>
                                <input type="file" id='image' name="image" class="form-control" required="required">
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Save</label><br>
                                <input type="submit" name="submit" value="Submit" class="btn btn-success">
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
                                            <th>Title</th>
                                            <th>Image</th>
                                            <th>Created On</th>
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
                                            <td>{{$pvalue->title}}</td>
                                            <td>{{$pvalue->image}}</td>
                                            <td>{{$pvalue->created_on}}</td>
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
        $(function() {
            $('.start-date').datepicker({
                dateFormat: 'dd-mm-yy'
            });
            $('.end-date').datepicker({
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>
    @include('includes.footer')