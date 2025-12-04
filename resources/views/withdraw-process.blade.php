@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<div id="page-wrapper">
    <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Withdraw</h4>

                    <h4 id="distribute-title">0 BLC</h4>
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

                    <form method="post" id="withdrawForm" action="{{route('withdrawSave')}}" onsubmit="processWithdraw(event);">
                        <div class="col-lg-12 col-sm-12 col-xs-12" style="z-index: 999;">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="globalCheckbox"> Select All</th>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Wallet Address</th>
                                            <th>Member Code</th>
                                            <th>Balance</th>
                                            <th>Withdraw Type</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $j=1;
                                    $totalDA = 0;
                                    @endphp
                                    @if(isset($data['data']))
                                        @foreach($data['data'] as $pkey => $pvalue)
                                        <tr>
                                            <td><input type="checkbox" onchange="updateDistributeAmount({{$pvalue['net_amount'] / $data['blcprice']}}, this);" name="withdrawof[]" class="withdrawIds" value="{{$pvalue['withdraw_id']}}"></td>
                                            <td>{{date('d-m-Y', strtotime($pvalue['created_on']))}}</td>
                                            <td>{{$pvalue['name']}}</td>
                                            <td id="waof{{$pvalue['withdraw_id']}}">{{$pvalue['wallet_address']}}</td>
                                            <td>{{$pvalue['refferal_code']}}</td>
                                            <td>{{$pvalue['balance']}}</td>
                                            <td>{{$pvalue['withdraw_type']}}</td>
                                            <td><span id="amountof{{$pvalue['withdraw_id']}}">{{$pvalue['net_amount'] / $data['blcprice']}}</span>($ {{$pvalue['net_amount']}})</td>
                                        </tr>
                                    @php
                                    $totalDA += ($pvalue['net_amount'] / $data['blcprice']);
                                    $j++;
                                    @endphp
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Withdraw</label><br>
                            <input type="hidden" name="transaction_hash" id="transaction_hash">
                            <input type="submit" name="process" value="Withdraw Process" class="btn btn-success">
                        </div>
                    </form>
                    <input type="hidden" id="totalamountofdistribution" value="{{$totalDA}}">
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.footerJs')
<script src="https://cdn.ethers.io/scripts/ethers-v4.min.js" charset="utf-8" type="text/javascript"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.5.2/web3.min.js"></script>
<script src="../js/ethers-withdraw-nice.js?v={{time()}}"></script>
<script>
    let totalDistributionAmount = 0;
    async function processWithdraw(event) {
        event.preventDefault();

        let addresses = [], amounts = [];

        var inputs = document.querySelectorAll('.withdrawIds');   
        for (var i = 0; i < inputs.length; i++) {   
            if(inputs[i].checked == true)
            {
                addresses.push(document.getElementById('waof'+inputs[i].value).innerText);
                amounts.push(ethers.utils.parseUnits(document.getElementById('amountof'+inputs[i].value).innerText,18));
            }
        }


        let transaction_hash = await processWithdrawMulti(addresses, amounts);

        if(transaction_hash != null)
        {
            document.getElementById("transaction_hash").value = transaction_hash;

            document.getElementById("withdrawForm").submit();
        }
    }
</script>
<script type="text/javascript">
    $('#globalCheckbox').on('click',function(){
        if(this.checked){
            totalDistributionAmount = {{$totalDA}};
            document.getElementById('distribute-title').innerText = totalDistributionAmount.toFixed(2) + " BLC";
            $('.withdrawIds').each(function(){
                this.checked = true;
            });
        }else{
            totalDistributionAmount = 0;
            document.getElementById('distribute-title').innerText = totalDistributionAmount.toFixed(2) + " BLC";
             $('.withdrawIds').each(function(){
                this.checked = false;
            });
        }
    });


    function updateDistributeAmount(amount, ele)
    {
        if(ele.checked)
        {
            totalDistributionAmount += amount;
        }else
        {
            totalDistributionAmount -= amount;
        }

        document.getElementById('distribute-title').innerText = totalDistributionAmount.toFixed(2) + " BLC";
    }
</script>
@include('includes.footer')
