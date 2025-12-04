@include('includes.headcss')
<link rel="stylesheet" href="{{ asset("/plugins/bower_components/dropify/dist/css/dropify.min.css") }}">
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Ads</h4>
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
                    <form action="{{ route('ads.update', $editData['id']) }}" enctype="multipart/form-data" method="post">
                    	{{ method_field("PUT") }}
                    @else
                    <form action="{{ route('ads.store') }}" enctype="multipart/form-data" method="post">
                    	{{ method_field("POST") }}

                    @endif                        

                            @csrf                        

                        <div class="col-md-3 form-group">
                            <label>Title </label>
                            <input type="text" id='title' @if(isset($editData['title'])) value="{{$editData['title']}}" @endif name="title" class="form-control" required="required">
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Description </label>
                            <input type="text" id='description' @if(isset($editData['description'])) value="{{$editData['description']}}" @endif name="description" class="form-control" required="required">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Logo </label>
                            <input type="file" id='file' @if(isset($editData['file'])) data-default-file="{{ asset('/storage/'.$editData['file'])}}" @endif name="file" class="dropify">
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Type </label>
                            <select id='file_type' name="file_type" class="form-control" required="required">
                                <option value="image" @if(isset($editData['file_type'])) @if($editData['file_type'] == "image") selected="selected" @endif @endif> Image </option>
                                <option value="video" @if(isset($editData['file_type'])) @if($editData['file_type'] == "video") selected="selected" @endif @endif> Video </option>
                                <option value="youtube" @if(isset($editData['file_type'])) @if($editData['file_type'] == "youtube") selected="selected" @endif @endif> Youtube </option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Status </label>
                            <select id='status' name="status" class="form-control" required="required">
                                <option value="1" @if(isset($editData['status'])) @if($editData['status'] == "1") selected="selected" @endif @endif> Active </option>
                                <option value="0" @if(isset($editData['status'])) @if($editData['status'] == "0") selected="selected" @endif @endif> In-Active </option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Display </label>
                            <select id='website' name="website" class="form-control" required="required">
                                <option value="0" @if(isset($editData['website'])) @if($editData['website'] == "0") selected="selected" @endif @endif> Network </option>
                                <option value="1" @if(isset($editData['website'])) @if($editData['website'] == "1") selected="selected" @endif @endif> Website </option>
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
                                            <th>Title</th>
                                            <th>Desciption</th>
                                            <th>Views</th>
                                            <th>Display</th>
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
                                            <td>{{$pvalue['title']}}</td>
                                            <td>{{$pvalue['description']}}</td>
                                            <td>{{$pvalue['views']}}</td>
                                            <td>{{$pvalue['website'] == 1 ? "Website" : "Network"}}</td>
                                            <td><a href="{{ route('ads.edit',$pvalue['id'])}}"><button style="float:left;" type="button" class="btn btn-info btn-outline btn-circle btn m-r-5"><i class="ti-pencil-alt"></i></button></a>
                                            <form action="{{ route('ads.destroy', $pvalue['id'])}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="float:left;" onclick="return confirmDelete();" class="btn btn-info btn-outline btn-circle btn m-r-5"><i class="ti-trash"></i></button>
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
</div>

@include('includes.footerJs')

<script src="{{ asset("/plugins/bower_components/dropify/dist/js/dropify.min.js") }}"></script>
<script>
$(document).ready(function() {
    // Basic
    $('.dropify').dropify();
    // Translated
    $('.dropify-fr').dropify({
        messages: {
            default: 'Glissez-déposez un fichier ici ou cliquez',
            replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
            remove: 'Supprimer',
            error: 'Désolé, le fichier trop volumineux'
        }
    });
    // Used events
    var drEvent = $('#input-file-events').dropify();
    drEvent.on('dropify.beforeClear', function(event, element) {
        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
    });
    drEvent.on('dropify.afterClear', function(event, element) {
        alert('File deleted');
    });
    drEvent.on('dropify.errors', function(event, element) {
        console.log('Has Errors');
    });
    var drDestroy = $('#input-file-to-destroy').dropify();
    drDestroy = drDestroy.data('dropify')
    $('#toggleDropify').on('click', function(e) {
        e.preventDefault();
        if (drDestroy.isDropified()) {
            drDestroy.destroy();
        } else {
            drDestroy.init();
        }
    })
});
</script>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
@include('includes.footer')
