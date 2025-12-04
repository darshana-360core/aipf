@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Support Tickets</h4>
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
                        <h2>Open Tickets</h2>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>User Id</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Attachment</th>
                                        <th>Date</th>
                                        <th>Reply</th>
                                        <th>Close</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                $j=1;
                                @endphp
                                @if(isset($data['data']))
                                    @foreach($data['data'] as $pkey => $pvalue)
                                    <tr>
                                        <form method="post" id="withdrawForm" action="{{route('replySupportTickets')}}">
                                            <td>{{$pvalue['id']}}</td>
                                            <td>{{$pvalue['refferal_code']}}</td>
                                            <td>{{$pvalue['subject']}}</td>
                                            <td>{{$pvalue['message']}}</td>
                                            <td><a href="{{asset('storage/'.$pvalue['file'])}}" target="_blank">View</a></td>
                                            <td>{{date('d-m-Y h:i', strtotime($pvalue['created_on']))}}</td>
                                            <td><input type="text" name="reply"></td>
                                            <td><input type="submit" name="submit" value="Close Ticket"></td>
                                            <input type="hidden" name="ticket_id" value="{{$pvalue['id']}}">
                                        </form>
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
    <div class="row">
        <div class="white-box">
                <div class="panel-body">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <h2>Closed Tickets</h2>
                        <div class="table-responsive">
                            <table id="closedTicket" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>User Id</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Attachment</th>
                                        <th>Date</th>
                                        <th>Replied</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                $j=1;
                                @endphp
                                @if(isset($data['closed']))
                                    @foreach($data['closed'] as $pkey => $pvalue)
                                    <tr>
                                        <td>{{$pvalue['id']}}</td>
                                        <td>{{$pvalue['refferal_code']}}</td>
                                        <td>{{$pvalue['subject']}}</td>
                                        <td>{{$pvalue['message']}}</td>
                                        <td><a href="{{asset('storage/'.$pvalue['file'])}}" target="_blank">View</a></td>
                                        <td>{{date('d-m-Y h:i', strtotime($pvalue['created_on']))}}</td>
                                        <td>{{$pvalue['reply']}}</td>
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
        $('#closedTicket').DataTable();
	});

    $(".txnHash").each(async (s, d) => {
        console.log(s.innerText)
    })
</script>
@include('includes.footer')
