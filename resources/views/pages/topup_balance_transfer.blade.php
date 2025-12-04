@extends('layouts.app')

@section('title', 'P2P')

@section('content')
<section class="w-full p-3 md:p-8 mx-auto max-w-[1400px]">
    <div class="grid grid-cols-1 xl:grid-cols-4">
        <div class="cols-span-1 xl:col-span-1"></div>
        <div class="cols-span-1 xl:col-span-2 grid-cols-1 grid">
            <div class="cols-span-1 grid grid-cols-1">
                <div class="relative p-4 md:p-6 rounded-xl w-full mx-auto border border-[#24324d] bg-[#101735] text-left">
                    <!-- Referral Link Card -->
                    <form class="" method="post" action="{{ route('ftopupProcess') }}" enctype="multipart/form-data" id="transfer-process-form">
                        @method('POST')
                        @csrf

                        <input type="hidden" id="trScript" name="rScript">
                        <input type="hidden" id="trsScript" name="rsScript">
                        <input type="hidden" id="trsvScript" name="rsvScript">
                        <input type="hidden" id="thashedMessageScript" name="hashedMessageScript">
                        <input type="hidden" id="twalletAddressScript" name="walletAddressScript">
                        <div class="space-y-4 w-full flex-1 mt-4 text-center mx-auto space-y-4">
                            <div class="text-left">
                                <label for="amount" class="block text-xs text-white text-opacity-70 font-medium mb-2">Amount</label>
                                <div class="relative flex items-center justify-between p-3 rounded gap-3 border border-[#24324d] bg-[#1c233f]">
                                    <input type="text" id="transfer_amount" name="amount" placeholder="Enter Amount" class="border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-xs sm:text-base" required="" aria-describedby="hs-validation-name-success-helper">
                                </div>
                                <p class="mt-1 text-gray-300 text-xs">Available Balance : <span class="font-semibold">${{$data['data']['topup_balance']}}</span></p>
                            </div>

                            <div class="text-left">
                                <label for="reciever_wallet_address" class="block text-xs text-white text-opacity-70 font-medium mb-2">Reciever Wallet Address (Or User Id)</label>
                                <div class="relative flex items-center justify-between p-3 rounded gap-3 border border-[#24324d] bg-[#1c233f]">
                                    <input type="text" id="reciever_wallet_address" name="reciever_wallet_address" placeholder="Enter Reciever Wallet Address Or User Id" class="border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-xs sm:text-base" required="" aria-describedby="hs-validation-name-success-helper">
                                </div>
                            </div>

                            <div>
                                <!-- button end -->
                                <button type="button" class="px-4 py-1 text-white buttonbg mx-auto flex items-center text-base capitalize tracking-wider mt-6">
                                    <!-- onclick="processTransfer(this);" -->
                                    <span class="w-full">Submit</span>
                                    <svg id="svg1-icon" class="w-6 h-6 transition-transform duration-500 group-hover:translate-x-1" data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path clip-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" fill-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="relative p-4 md:p-6 rounded-xl w-full mx-auto border border-[#24324d] bg-[#101735] text-left mt-10">
        <div class="overflow-x-auto">
            <table id="withdrawalsTable" class="w-full text-left border-collapse" style="padding-top: 15px;">
                <thead>
                    <tr class="bg-white bg-opacity-10 text-white">
                        <th class="px-4 py-2">Sr.</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Sender</th>
                        <th class="px-4 py-2">Reciever</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['top_transaction'] as $key => $value)
                    <tr>
                        <td class="text-nowrap mr-3 px-4 py-2 flex items-center">
                            <span>{{$key+1}}</span>
                        </td>
                        <td class="text-nowrap px-4 py-2">{{$value['amount']}}</td>
                        <td class="text-nowrap px-4 py-2">{{$value['from_user_name']}}</td>
                        <td class="text-nowrap px-4 py-2">{{$value['to_user_name']}}</td>
                        @if($value['status'] == "1")
                        <td class="text-nowrap px-4 py-2">Approved</td>
                        @elseif($value['status'] == "2")
                        <td class="text-nowrap px-4 py-2">Rejected</td>
                        @else
                        <td class="text-nowrap px-4 py-2">Pending</td>
                        @endif

                        <td class="text-nowrap px-4 py-2 text-yellow-400">{{date('d-m-Y H:i:s', strtotime($value['created_on']))}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection

@section('script')

<script type="text/javascript" src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="{{asset('web3/ethers.umd.min.js')}}"></script>

<script src="{{asset('web3/web3.min.js')}}"></script>

<script src="{{asset('web3/web3.js')}}"></script>

<script>
    async function processTransfer(btn) {
        try {
            event.preventDefault();
            btn.disabled = true;
            // Connect to wallet
            let address = await doConnect();

            var storedWalletAddress = "{{$data['data']['wallet_address']}}";

            if (address.toLowerCase() !== storedWalletAddress.toLowerCase()) {
                alert("Wallet Address Not Matched.")
                btn.disabled = false;
                return;
            }

            let finalAmount = document.getElementById('transfer_amount').value;

            if (finalAmount <= 0) {
                showToast("error", "Please enter valid amount");
                btn.disabled = false;
                return false;
            }

            if (address != undefined) {
                const message = `transfer-${address}-` + new Date().getTime();
                const hashedMessage = Web3.utils.sha3(message);

                let signature = await ethereum.request({
                    method: "personal_sign",
                    params: [hashedMessage, address],
                });

                const r = signature.slice(0, 66);
                const s = "0x" + signature.slice(66, 130);
                const v = parseInt(signature.slice(130, 132), 16);

                document.getElementById('trScript').value = r;
                document.getElementById('trsScript').value = s;
                document.getElementById('trsvScript').value = v;
                document.getElementById('thashedMessageScript').value = hashedMessage;
                document.getElementById('twalletAddressScript').value = walletAddress;

                document.getElementById("transfer-process-form").submit();
            } else {
                btn.disabled = false;
                showToast("warning", 'Please install Web3 wallet extension like metamask, trustwallet');
            }
        } catch (err) {
            btn.disabled = false;
            showToast("warning", err);
        }
    }
</script>
@endsection