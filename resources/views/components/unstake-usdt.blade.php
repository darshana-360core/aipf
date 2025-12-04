@if(isset($data['last_stake']))
@php
$lockPeriodHours = [
    0 => 24,         // 1 Day
    1 => 720,        // 30 Days
    2 => 2160,       // 90 Days
    3 => 4320,       // 180 Days
    4 => 8640,       // 360 Days
];

$createdOn = \Carbon\Carbon::parse($data['last_stake']['created_on']);
$hours = $lockPeriodHours[$data['last_stake']['lock_period']] ?? 0;
$unlockDate = $createdOn->copy()->addHours($hours);
$now = \Carbon\Carbon::now();

$totalSeconds = $unlockDate->diffInSeconds($createdOn);
$elapsedSeconds = min($now->diffInSeconds($createdOn), $totalSeconds);
$lockProgress = $totalSeconds > 0 ? ($elapsedSeconds / $totalSeconds) * 100 : 100;
$lockProgress = round($lockProgress, 1);

$remainingText = $hours >= 24 
    ? floor($hours / 24) . ' Days' 
    : $hours . ' Hours';

$isUnlocked = $now->greaterThanOrEqualTo($unlockDate);
@endphp

<div class="my-4 space-y-6">
    <div class="rounded-lg p-6 border bg-blue-900/20 border-blue-700/30">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-blue-400">Locked</h3>
            <span class="text-sm font-medium text-blue-300">Unlocks in {{ $remainingText }}</span>
        </div>
        <p class="text-sm mb-4 text-blue-300">
            Your stake is currently locked and will unlock in {{ $remainingText }}.
        </p>

        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-blue-400"></div>
                    <span class="text-gray-300 font-medium">Lock Progress</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-bold text-lg text-blue-300">{{ $lockProgress }}%</span>
                    <div class="text-xs text-gray-400">🟡</div>
                </div>
            </div>

            <div class="relative">
                <div class="w-full h-4 bg-gray-900 rounded-full border-2 border-gray-700 overflow-hidden">
                    <div class="h-full rounded-full bg-blue-500" style="width: {{ $lockProgress }}%;"></div>
                </div>
                <div class="absolute inset-0 flex justify-between items-center px-1">
                    <div class="w-1 h-2 rounded bg-white"></div>
                    <div class="w-1 h-2 rounded bg-white"></div>
                    <div class="w-1 h-2 rounded bg-white"></div>
                    <div class="w-1 h-2 rounded bg-gray-600"></div>
                    <div class="w-1 h-2 rounded bg-gray-600"></div>
                </div>
            </div>

            <div class="flex justify-between text-xs text-gray-500">
                <span class="text-gray-300">Start</span>
                <span class="text-gray-300">25%</span>
                <span class="text-gray-300">50%</span>
                <span>75%</span>
                <span>Unlock</span>
            </div>

            <div class="flex justify-between text-xs text-gray-400 pt-2 border-t border-gray-700">
                <span>🕒 Staked: {{ $createdOn->format('d F, y H:i') }}</span>
                <span>🔓 Unlocks: {{ $unlockDate->format('d F, y H:i') }}</span>
            </div>
        </div>
    </div>

    <div class="bg-[#2a2a40] rounded-lg p-4 border-2 border-[#22c55e]">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-400">Total You'll Receive</p>
                <p class="text-xl font-bold text-white">{{ number_format(($data['compound_amount'] - $data['total_unstake_amount']), 3) }} RTX</p>
                <p class="text-sm text-gray-400">${{ number_format((($data['compound_amount'] - $data['total_unstake_amount']) ?? 0) * ($data['rtxPrice'] ?? 0), 3) }} USD</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-red-400">Total Fees: {{ number_format((($data['compound_amount'] - $data['total_unstake_amount']) ?? 0) * 0.06, 3) }} RTX</p>
                <p class="text-xs text-gray-500">6% applied to both principal and returns</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-4 mt-6">
        <button onclick="document.getElementById('claim-rio-modal').classList.remove('hidden')" class="bg-emerald-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-emerald-700 transition">
            Claim ROI
        </button>

        <button onclick="document.getElementById('unstake-bonds-modal').classList.remove('hidden')" class="px-8 py-3 rounded-xl font-medium transition 
                   {{ $isUnlocked 
                        ? 'bg-red-600 hover:bg-red-700 text-white' 
                        : 'bg-red-900/50 text-red-200 cursor-not-allowed' }}"
            {{ $isUnlocked ? '' : 'disabled' }}>
            Unstake
        </button>
    </div>
</div>
@else
    <div class="my-4 space-y-6">
        <div class="rounded-lg p-4 border bg-blue-900/20 border-blue-700/30">
            <p class="text-sm mb-0 text-blue-300">
                You have nothing to unstake.
            </p>
        </div>
    </div>
@endif

<div class="w-full p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl mt-10">
        <div class="overflow-x-auto">
            <table id="withdrawalsTable" class="w-full text-left border-collapse" style="padding-top: 15px;">
                <thead>
                    <tr class="bg-white bg-opacity-10 text-white">
                        <th class="px-4 py-2">Sr.</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Transaction ID</th>
                        <th class="px-4 py-2">Tag</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['withdraw'] as $key => $value)
                    <tr>
                        <td class="text-nowrap mr-3 px-4 py-2 flex items-center">
                            <span>{{ $key + 1 }}</span>
                        </td>
                        <td class="text-nowrap px-4 py-2">{{ $value['amount'] }}</td>
                        <td class="text-nowrap px-4 py-2 {{ $value['status'] == 1 ? 'text-green-400' : ($value['status'] == 2 ? 'text-red-300' : 'text-yellow-400') }}">{{ $value['status'] == 1 ? "Complete" : ($value['status'] == 2 ? "Reject" : "Pending (Queue ". $data['queue'].")") }}</td>
                        @if($value['status'] == 1)
                        <td class="text-nowrap px-4 py-2"><a href="https://bscscan.com/tx/{{ $value['claim_hash'] }}" class="text-blue-600 flex items-center gap-2" target="_blank">View <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="Interface / External_Link">
                                        <path id="Vector" d="M10.0002 5H8.2002C7.08009 5 6.51962 5 6.0918 5.21799C5.71547 5.40973 5.40973 5.71547 5.21799 6.0918C5 6.51962 5 7.08009 5 8.2002V15.8002C5 16.9203 5 17.4801 5.21799 17.9079C5.40973 18.2842 5.71547 18.5905 6.0918 18.7822C6.5192 19 7.07899 19 8.19691 19H15.8031C16.921 19 17.48 19 17.9074 18.7822C18.2837 18.5905 18.5905 18.2839 18.7822 17.9076C19 17.4802 19 16.921 19 15.8031V14M20 9V4M20 4H15M20 4L13 11" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                </svg></a></td>
                        @else
                        <td class="text-nowrap px-4 py-2 text-yellow-400">No Transaction Hash</td>
                        @endif
                        <td class="text-nowrap px-4 py-2">
                            @if($value['withdraw_type']=='USDT')
                                Claimed
                            @else
                                Unstake
                            @endif
                        </td>
                        <td class="text-nowrap px-4 py-2 text-[#30b8f5]">{{ \Carbon\Carbon::parse($value['created_on'], 'UTC')->setTimezone('Europe/London')->format('d-m H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

<!-- claim-rio-modal Start -->
<div id="claim-rio-modal" class="px-4 fixed inset-0 z-[9999] bg-black/60 hidden flex items-center justify-center">
    <div class="bg-[#1a1a23] rounded-xl p-6 w-full max-w-md border border-[#322751] shadow-2xl overflow-auto" style="max-height: 97vh;">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-white">Claim ROI</h2>
            <button onclick="document.getElementById('claim-rio-modal').classList.add('hidden')" class="text-gray-400 hover:text-white disabled:opacity-50 disabled:cursor-not-allowed">✕</button>
        </div>
        <form class="space-y-5" action="{{route('fwithdrawProcess')}}" id="unstake-process-form" method="post">
            @method('POST')
            @csrf
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-300">Amount</label>
                <div class="relative">
                    <input placeholder="Enter amount" id="yourfinalamount" class="w-full bg-[#1a1a23] border border-[#322751] rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#845dcb] focus:border-transparent disabled:opacity-50 disabled:cursor-not-allowed"
                        type="text" value="">
                    <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 bg-[#845dcb] hover:bg-[#6b3fb9] disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm px-3 py-1 rounded transition-colors" onclick="document.getElementById('yourfinalamount').value = ({{$data['generated_roi'] - $data['claim_roi'] - 0.0001}})">MAX</button>
                </div>
            </div>
            <div class="flex gap-3">
                <input type="hidden" name="transaction_hash" id="transaction_hash">
                <input type="hidden" name="withdraw_type" value="UNSTAKE" id="withdraw_type">
                <input type="hidden" name="package_id" value="3" id="package_id">
                <button onclick="document.getElementById('claim-rio-modal').classList.add('hidden')" type="button" class="flex-1 bg-gray-700 hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed text-white font-medium py-3 px-4 rounded-lg transition-colors">Cancel</button>
                <button type="button" class="flex-1 bg-gradient-to-r from-[#845dcb] to-[#6b3fb9] hover:from-[#6b3fb9] hover:to-[#5a2fa8] disabled:from-gray-600 disabled:to-gray-600 disabled:cursor-not-allowed text-white font-medium py-3 px-4 rounded-lg transition-all flex items-center justify-center" onclick="processWithdraw(this);">Process</button>
            </div>
        </form>
    </div>
</div>
<!-- claim-rio-modal End -->

<!-- unstake-bonds-modal Start -->
<div id="unstake-bonds-modal" class="px-4 fixed inset-0 z-[9999] bg-black/60 hidden flex items-center justify-center">
    <div class="bg-[#1a1a23] rounded-xl p-6 w-full max-w-md border border-[#322751] shadow-2xl overflow-auto" style="max-height: 97vh;">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-white">Unstake Bonds</h2>
            <button onclick="document.getElementById('unstake-bonds-modal').classList.add('hidden')" class="text-gray-400 hover:text-white disabled:opacity-50 disabled:cursor-not-allowed">✕</button>
        </div>
        <form class="space-y-5" action="{{route('fwithdrawProcess')}}" id="unstake-process-form" method="post">
            @method('POST')
            @csrf
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-300">Amount</label>
                <div class="relative">
                    <input placeholder="Enter amount" name="amount" id="yourunstakeamount" class="w-full bg-[#1a1a23] border border-[#322751] rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#845dcb] focus:border-transparent disabled:opacity-50 disabled:cursor-not-allowed"
                        type="text">

                    <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 bg-[#845dcb] hover:bg-[#6b3fb9] disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm px-3 py-1 rounded transition-colors" onclick="document.getElementById('yourunstakeamount').value = ({{$data['compound_amount'] - $data['total_unstake_amount'] - 0.0001}})">MAX</button>
                </div>
            </div>
            <div class="flex gap-3">
                <input type="hidden" name="transaction_hash" id="unstake_transaction_hash">
                <input type="hidden" name="withdraw_type" value="UNSTAKE" id="withdraw_type">
                <button onclick="document.getElementById('unstake-bonds-modal').classList.add('hidden')" type="button" class="flex-1 bg-gray-700 hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed text-white font-medium py-3 px-4 rounded-lg transition-colors">Cancel</button>
                <button type="button" class="flex-1 bg-gradient-to-r from-[#845dcb] to-[#6b3fb9] hover:from-[#6b3fb9] hover:to-[#5a2fa8] disabled:from-gray-600 disabled:to-gray-600 disabled:cursor-not-allowed text-white font-medium py-3 px-4 rounded-lg transition-all flex items-center justify-center" onclick="processUnstake(this);">Process</button>
            </div>
        </form>
    </div>
</div>
<!-- unstake-bonds-modal End -->

@section('script')
<script type="text/javascript" src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="{{asset('web3/ethers.umd.min.js')}}"></script>

<script src="{{asset('web3/web3.min.js')}}"></script>

<script src="{{asset('web3/web3.js?v=' . time())}}"></script>

<script type="text/javascript">
    let buyContract = '0x07991cfd051C5FC63bBC45A2c4eF7E428912b225';

    let buyContractABI = '[{"anonymous":false,"inputs":[{"indexed":false,"internalType":"uint8","name":"version","type":"uint8"}],"name":"Initialized","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"previousOwner","type":"address"},{"indexed":true,"internalType":"address","name":"newOwner","type":"address"}],"name":"OwnershipTransferred","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"user","type":"address"},{"indexed":true,"internalType":"address","name":"referrer","type":"address"},{"indexed":false,"internalType":"uint256","name":"level","type":"uint256"},{"indexed":false,"internalType":"uint256","name":"amount","type":"uint256"},{"indexed":false,"internalType":"enum OrbitXPlan.StakeType","name":"stakeType","type":"uint8"}],"name":"UserBusinessAdded","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"user","type":"address"},{"indexed":false,"internalType":"uint256","name":"amount","type":"uint256"},{"indexed":false,"internalType":"uint256","name":"previousBalance","type":"uint256"},{"indexed":false,"internalType":"uint256","name":"newBalance","type":"uint256"}],"name":"UserRewardsUpdated","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"user","type":"address"},{"indexed":true,"internalType":"address","name":"referrer","type":"address"},{"indexed":false,"internalType":"uint256","name":"amount","type":"uint256"},{"indexed":false,"internalType":"uint256","name":"amountParsed","type":"uint256"},{"indexed":false,"internalType":"enum OrbitXPlan.StakeType","name":"stakeType","type":"uint8"}],"name":"UserStake","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"user","type":"address"},{"indexed":false,"internalType":"uint256","name":"amount","type":"uint256"},{"indexed":false,"internalType":"enum OrbitXPlan.StakeType","name":"stakeType","type":"uint8"}],"name":"UserWithdraw","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"user","type":"address"},{"indexed":false,"internalType":"uint256","name":"amount","type":"uint256"}],"name":"UserWithdrawFromRewards","type":"event"},{"inputs":[],"name":"DAYS_INTERVAL","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"enum OrbitXPlan.StakeType","name":"_stakeType","type":"uint8"},{"internalType":"uint256","name":"_amount","type":"uint256"}],"name":"getParsedAmount","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"_token","type":"address"},{"internalType":"enum OrbitXPlan.StakeType","name":"_stakeType","type":"uint8"}],"name":"getPrice","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"_token","type":"address"},{"internalType":"address","name":"_usdt","type":"address"},{"internalType":"address","name":"_priceOracle","type":"address"}],"name":"initialize","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"","type":"address"}],"name":"isValidCaller","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"enum OrbitXPlan.LockPeriod","name":"","type":"uint8"}],"name":"lockPeriods","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"owner","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"priceOracle","outputs":[{"internalType":"contract IPriceOracle","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"renounceOwnership","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"_caller","type":"address"},{"internalType":"bool","name":"_isValid","type":"bool"}],"name":"setValidCaller","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"_referrer","type":"address"},{"internalType":"uint256","name":"_amount","type":"uint256"},{"internalType":"enum OrbitXPlan.StakeType","name":"_stakeType","type":"uint8"},{"internalType":"enum OrbitXPlan.LockPeriod","name":"_lockPeriod","type":"uint8"}],"name":"stake","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"enum OrbitXPlan.StakeType","name":"","type":"uint8"}],"name":"stakingToken","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"newOwner","type":"address"}],"name":"transferOwnership","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address[]","name":"_users","type":"address[]"},{"internalType":"uint256[]","name":"_amounts","type":"uint256[]"}],"name":"updateRewardsOfUser","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"","type":"address"}],"name":"userEarnings","outputs":[{"internalType":"uint256","name":"totalStaked","type":"uint256"},{"internalType":"uint256","name":"availableBalance","type":"uint256"},{"internalType":"uint256","name":"lastClaimed","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"","type":"address"},{"internalType":"enum OrbitXPlan.StakeType","name":"","type":"uint8"}],"name":"userInfo","outputs":[{"internalType":"uint256","name":"amount","type":"uint256"},{"internalType":"enum OrbitXPlan.LockPeriod","name":"lockPeriod","type":"uint8"},{"internalType":"uint256","name":"claimed","type":"uint256"},{"internalType":"uint256","name":"lastStakedAt","type":"uint256"},{"internalType":"uint256","name":"lastClaimedAt","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"","type":"address"}],"name":"users","outputs":[{"internalType":"address","name":"referrer","type":"address"},{"internalType":"bool","name":"isActive","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"_amount","type":"uint256"},{"internalType":"enum OrbitXPlan.StakeType","name":"_stakeType","type":"uint8"}],"name":"withdraw","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"uint256","name":"_amount","type":"uint256"}],"name":"withdrawFromRewards","outputs":[],"stateMutability":"nonpayable","type":"function"}]';

    let buyContractInst;
</script>
<script type="text/javascript">
    async function processWithdraw(btn) {

        try {
            event.preventDefault();
            btn.disabled = true;

            let finalAmount = document.getElementById('yourunstakeamount').value;

            if (finalAmount <= 0) {
                showToast("error", "Please enter valid amount");
                btn.disabled = false;
                return false;
            }

            var walletAddress = await doConnect();

            var storedWalletAddress = "{{$data['user']['wallet_address']}}";

            if (walletAddress.toLowerCase() !== storedWalletAddress.toLowerCase()) {
                alert("Wallet Address Not Matched.")
                btn.disabled = false;
                return;
            }

            let usdtAmount = ethers.utils.parseUnits((finalAmount.toString()), 18);

            buyContractInst = new ethers.Contract(buyContract, buyContractABI, signer);

            swal({
                    text: 'Confirm Request For Unstake.\n\nThe request transaction will take 5-10 minutes to update status on Bsc Chain, if you get any errors, do try after 10 mins from your request.\nClick on request to proceed.\n\nRegards,\nTeam OrbitX',
                    button: {
                        text: "Request",
                        closeModal: false,
                    },
                })
                .then(async (confirmed) => {
                    let txn;
                    if (confirmed) {
                        let gasPrice = await signer.provider.getGasPrice()
                            txn = await buyContractInst.withdraw(usdtAmount, 3);
                            return txn
                    } else {
                        return null
                    }
                }).then((signature) => {
                    if (!signature) {
                        btn.disabled = false;
                        swal("Request declined!", "The transaction was declined by the user", "error")
                        return;
                    }
                    
                    showToast("info", "Confirming transaction.. Please Don't refresh the page!!!");

                    document.getElementById('unstake_transaction_hash').value = txn.hash ? txn.hash : txn;

                    document.getElementById("unstake-process-form").submit();
                }).catch((err) => {
                    btn.disabled = false;
                    swal(`Error while requesting`, `${err['data'] ? err['data']['message']: err['message']}`, "error")
                })

        } catch (err) {
            btn.disabled = false;
            showToast("warning", err);
        }

    }
</script>

<script type="text/javascript">
    async function processUnstake(btn) {

        try {
            event.preventDefault();
            btn.disabled = true;

            let finalAmount = document.getElementById('yourunstakeamount').value;

            if (finalAmount <= 0) {
                showToast("error", "Please enter valid amount");
                btn.disabled = false;
                return false;
            }

            var walletAddress = await doConnect();

            var storedWalletAddress = "{{$data['user']['wallet_address']}}";

            if (walletAddress.toLowerCase() !== storedWalletAddress.toLowerCase()) {
                alert("Wallet Address Not Matched.")
                btn.disabled = false;
                return;
            }

            let usdtAmount = ethers.utils.parseUnits((finalAmount.toString()), 18);

            buyContractInst = new ethers.Contract(buyContract, buyContractABI, signer);

            swal({
                    text: 'Confirm Request For Unstake.\n\nThe request transaction will take 5-10 minutes to update status on Bsc Chain, if you get any errors, do try after 10 mins from your request.\nClick on request to proceed.\n\nRegards,\nTeam OrbitX',
                    button: {
                        text: "Request",
                        closeModal: false,
                    },
                })
                .then(async (confirmed) => {
                    let txn;
                    if (confirmed) {
                        let gasPrice = await signer.provider.getGasPrice()
                            txn = await buyContractInst.withdraw(usdtAmount, 3);
                            return txn
                    } else {
                        return null
                    }
                }).then((signature) => {
                    if (!signature) {
                        btn.disabled = false;
                        swal("Request declined!", "The transaction was declined by the user", "error")
                        return;
                    }
                    
                    showToast("info", "Confirming transaction.. Please Don't refresh the page!!!");

                    document.getElementById('unstake_transaction_hash').value = txn.hash ? txn.hash : txn;

                    document.getElementById("unstake-process-form").submit();
                }).catch((err) => {
                    btn.disabled = false;
                    swal(`Error while requesting`, `${err['data'] ? err['data']['message']: err['message']}`, "error")
                })

        } catch (err) {
            btn.disabled = false;
            showToast("warning", err);
        }

    }
</script>
@endsection