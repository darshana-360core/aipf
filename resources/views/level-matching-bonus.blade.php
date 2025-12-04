@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Level Matching Bonus</h4>
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
                    <form action="{{ route('level-matching-bonus.update', $editData['id']) }}" enctype="multipart/form-data" method="post">
                    	{{ method_field("PUT") }}
                    @else
                    <form action="{{ route('level-matching-bonus.store') }}" enctype="multipart/form-data" method="post">
                    	{{ method_field("POST") }}

                    @endif                        

                            @csrf

                        <div class="col-md-3 form-group">
                            <label>Level </label>
                            <input type="number" id='level' @if(isset($editData['level'])) value="{{$editData['level']}}" @endif name="level" class="form-control" required="required">
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Level Display Name </label>
                            <input type="text" id='level_display_name' @if(isset($editData['level_display_name'])) value="{{$editData['level_display_name']}}" @endif name="level_display_name" class="form-control" required="required">
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Percentage </label>
                            <input type="text" id='percentage' @if(isset($editData['percentage'])) value="{{$editData['percentage']}}" @endif name="percentage" class="form-control" required="required">
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Status </label>
                            <select id='status' name="status" class="form-control" required="required">
                                <option value=""> Select Status </option>
                                <option value="1" @if(isset($editData['status'])) @if($editData['status'] == 1) selected="selected" @endif @endif> Active </option>
                                <option value="0" @if(isset($editData['status'])) @if($editData['status'] == 0) selected="selected" @endif @endif> In-Active </option>
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
                                            <th>Level</th>
                                            <th>Level Display Name</th>
                                            <th>Percentage</th>
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
                                            <td>{{$pvalue['level']}}</td>
                                            <td>{{$pvalue['level_display_name']}}</td>
                                            <td>{{$pvalue['percentage']}}</td>
                                            <td><a href="{{ route('level-matching-bonus.edit',$pvalue['id'])}}"><button style="float:left;" type="button" class="btn btn-info btn-outline btn-circle btn m-r-5"><i class="ti-pencil-alt"></i></button></a>
                                            <!--
                                                <form action="{{ route('level-matching-bonus.destroy', $pvalue['id'])}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="float:left;" onclick="return confirmDelete();" class="btn btn-info btn-outline btn-circle btn m-r-5"><i class="ti-trash"></i></button>
                                                </form>
                                            -->
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
