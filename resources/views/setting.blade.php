@include('includes.headcss')
<link rel="stylesheet" href="{{ asset("/plugins/bower_components/dropify/dist/css/dropify.min.css") }}">
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">setting</h4> </div>
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

                    <form action="{{ route('setting.store') }}" enctype="multipart/form-data" method="post">
                    	{{ method_field("POST") }}
                            @csrf

                        <div class="col-md-3 form-group">
                            <label>Min Withdraw </label>
                            <input type="text" id='min_withdraw' @if(isset($data['data']['min_withdraw'])) value="{{$data['data']['min_withdraw']}}" @endif name="min_withdraw" class="form-control" required="required">
                        </div>

						<div class="col-md-3 form-group">
                            <label>Admin Fees </label>
                            <input type="text" id='admin_fees' @if(isset($data['data']['admin_fees'])) value="{{$data['data']['admin_fees']}}" @endif name="admin_fees" class="form-control" required="required">
                        </div>

						<div class="col-md-4 form-group">
                            <label>Website Name </label>
                            <input type="text" id='website_name' @if(isset($data['data']['website_name'])) value="{{$data['data']['website_name']}}" @endif name="website_name" class="form-control" required="required">
                        </div>
						
						<div class="col-md-4 form-group">
                            <label>Website Title </label>
                            <input type="text" id='website_title' @if(isset($data['data']['website_title'])) value="{{$data['data']['website_title']}}" @endif name="website_title" class="form-control" required="required">
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Enable Withdraw </label>
                            <input type="checkbox" id='withdraw_setting' @if(isset($data['data']['withdraw_setting'])) @if($data['data']['withdraw_setting'] == 1) checked @endif @endif name="withdraw_setting" value="1" class="form-control">
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
