@include('includes.headcss')
<link rel="stylesheet" href="{{ asset("/plugins/bower_components/dropify/dist/css/dropify.min.css") }}">
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Principal</h4>
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

                    <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>User Id</th>
                                            <th>Amount</th>
                                            <th>Date</th>
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
                                            <td>{{$pvalue['name']}}</td>
                                            <td>{{$pvalue['refferal_code']}}</td>
                                            <td>{{$pvalue['amount']}}</td>
                                            <td>{{date('d-m-Y', strtotime($pvalue['created_on']))}}</td>
                                            <td>
                                            <form action="{{ route('principal.destroy', $pvalue['id'])}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="float:left;" onclick="return confirmDelete();" class="btn btn-info btn-outline btn-circle btn m-r-5"><i class="ti-check"></i></button>
                                            </form>
                                            <form action="{{ route('principal.destroy', $pvalue['id'])}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="float:left;" onclick="return confirmDelete();" class="btn btn-info btn-outline btn-circle btn m-r-5"><i class="ti-close"></i></button>
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
