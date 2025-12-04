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

                    <form action="{{ route('store_change_password') }}" enctype="multipart/form-data" method="post">
                        {{ method_field("POST") }}                      

                        @csrf

                        <div class="col-md-3 form-group">
                            <label>Old Password </label>
                            <input type="password" id='old_password' name="old_password" class="form-control" required="required">
                        </div>

                        <div class="col-md-3 form-group">
                            <label>New Password </label>
                            <input type="password" id='new_password' name="new_password" class="form-control" required="required" minlength="6">
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Confirm New Password </label>
                            <input type="password" id='renew_password' name="renew_password" class="form-control" required="required" minlength="6">
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Change</label><br>
                            <input type="submit" name="submit" value="Submit" class="btn btn-success">
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
