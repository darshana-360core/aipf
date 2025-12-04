<div class="my-4 space-y-6">
    <div class="bg-[#1c1a39] rounded-lg p-4 md:p-5 border border-[#322751]">
        <h3 class="text-lg font-semibold text-white mb-4">Your RTX Balance</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-sm text-gray-400 mb-1">Available RTX</p>
                <p class="text-xl font-bold text-white availableRTX">0 RTX</p>
            </div>
            <div>
                <p class="text-sm text-gray-400 mb-1">Staked RTX</p>
                <p class="text-xl font-bold text-[#845dcb]">{{$data['staked_amount']}} RTX</p>
            </div>
            @if(isset($data['last_stake_days']))
            <div>
                <p class="text-sm text-gray-400 mb-1">Staking Duration</p>
                <p class="text-xl font-bold text-green-400">{{$data['last_stake_days']}} <span class="text-sm text-gray-400">days</span></p>
                <p class="text-xs text-gray-500">Since: {{date('d F, Y H:i', strtotime($data['last_stake']['created_on']))}}</p>
            </div>
            @endif
        </div>
    </div>
    <div class="bg-[#1c1a39] rounded-lg p-4 md:p-5 border border-[#322751]">
        <div class="mb-5">
            <h3 class="text-lg font-semibold text-white mb-2">Increase Your RTX Stake</h3>
            <p class="text-gray-400">Add more RTX to boost your stable rewards with guaranteed returns.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-[#20202a] rounded-lg p-4 border-l-4 border-green-500">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <p class="text-sm text-gray-400">Total Claimed Rewards</p>
                </div>
                <p class="text-lg font-semibold text-white">{{$data['claimed_rewards']}} RTX</p>
                <p class="text-xs text-green-400">Active user • Stable bonds rewards</p>
            </div>
            <div class="bg-[#20202a] rounded-lg p-4">
                <p class="text-sm text-gray-400 mb-1">Discount Benefits</p>
                <p class="text-lg font-semibold text-white flex items-center gap-2">
                    Up to 10%
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                    </svg>
                </p>
                <p class="text-xs text-gray-500">Applied based on lock period selection</p>
            </div>
        </div>

        <button onclick="document.getElementById('stakertxnow-modal').classList.remove('hidden')"
            class="bg-gradient-to-r from-[#22c55e] to-[#16a34a] hover:from-[#16a34a] hover:to-[#15803d] text-white rounded-full w-full md:w-auto px-8 py-3">
            Stake RTX Now
        </button>
    </div>
    <div class="bg-gradient-to-r from-green-900/20 to-blue-900/20 border border-green-700/30 rounded-lg p-4">
        <h4 class="text-sm font-semibold text-green-400 mb-2">🛡️ Stable Bond Benefits</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <ul class="text-xs text-green-300 space-y-1 list-disc list-inside">
                <li>Income generation with RTX stability</li>
                <li>Minimum stake: 1 RTX</li>
            </ul>
            <ul class="text-xs text-green-300 space-y-1 list-disc list-inside">
                <li>Flexible staking with minimal lock periods</li>
                <li>Lower risk compared to token staking</li>
                <li>Perfect for conservative investors</li>
            </ul>
        </div>
    </div>
</div>

<div id="stakertxnow-modal" class="fixed inset-0 z-[9999] bg-black/60 hidden flex items-center justify-center">
    <div class="bg-[#1a1a23] rounded-xl p-6 w-full max-w-md border border-[#322751] shadow-2xl overflow-auto" style="max-height: 97vh;">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-white">Stake RTX for Stable Returns</h2>
            <button onclick="document.getElementById('stakertxnow-modal').classList.add('hidden')" class="text-gray-400 hover:text-white disabled:opacity-50 disabled:cursor-not-allowed">✕</button>
        </div>
        <div class="space-y-4">
            <form class="space-y-4" id="processPackage" method="post" action="{{route('fhandlePackageTransaction')}}">
                @method('POST')
                @csrf
                <div class="bg-[#20202a] rounded-lg p-4">
                    <div class="flex justify-between text-sm"><span class="text-gray-400">Available Balance:</span><span class="text-white font-medium availableRTX">0 RTX</span></div>
                    <!-- <div class="flex justify-between text-sm"><span class="text-gray-400">RTX Allowance</span><span class="text-white font-medium">Insufficient</span></div> -->
                </div>
                <div class="bg-blue-900/20 border border-blue-700/30 rounded-lg p-4 mb-4">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        <h4 class="text-sm font-semibold text-blue-400">Referrer Already Set</h4>
                    </div>
                    <div class="space-y-1 text-xs">
                        <div class="flex justify-between"><span class="text-gray-400">Your Referrer:</span><span class="text-blue-300 font-mono">{{$data['user']['sponser_code']}}</span></div>
                        <p class="text-blue-300">No referrer input needed for additional stakes.</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-300">Amount to Stake</label>
                    <div class="relative">
                        <input placeholder="Enter amount" id="packageAmount" name="amount" class="w-full bg-[#1a1a23] border border-[#322751] rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#845dcb] focus:border-transparent disabled:opacity-50 disabled:cursor-not-allowed pr-20"
                            type="number" value="" onkeyup="amountInUsdt(this.value);" onchange="initializeData()">
                        <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 bg-[#845dcb] hover:bg-[#6b3fb9] disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm px-3 py-1 rounded transition-colors" onclick="setStakeAmount('100');">MAX</button>
                    </div>
                    <p class="text-blue-500 text-sm" id="packageAmountUsdt">Amount in $</p>
                    <p class="text-red-500 text-sm hidden" id="packageAmountError">Please enter a valid amount</p>
                </div>
                <div class="flex gap-2 mb-4">
                    <button type="button" class="flex-1 bg-[#1a1a23] hover:bg-[#322751] disabled:opacity-50 disabled:cursor-not-allowed border border-[#322751] text-white text-sm py-1 rounded transition-colors" onclick="setStakeAmount('25');">25%</button>
                    <button type="button" class="flex-1 bg-[#1a1a23] hover:bg-[#322751] disabled:opacity-50 disabled:cursor-not-allowed border border-[#322751] text-white text-sm py-1 rounded transition-colors" onclick="setStakeAmount('50');">50%</button>
                    <button type="button" class="flex-1 bg-[#1a1a23] hover:bg-[#322751] disabled:opacity-50 disabled:cursor-not-allowed border border-[#322751] text-white text-sm py-1 rounded transition-colors" onclick="setStakeAmount('75');">75%</button>
                    <button type="button" class="flex-1 bg-[#1a1a23] hover:bg-[#322751] disabled:opacity-50 disabled:cursor-not-allowed border border-[#322751] text-white text-sm py-1 rounded transition-colors" onclick="setStakeAmount('100');">100%</button>
                </div>
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-medium text-gray-300">Lock Period <span class="text-red-400">*</span></label>
                    </div>
                    <!-- <div class="bg-purple-900/20 border border-purple-700/30 rounded-lg p-3 mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 text-purple-400">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="text-xs text-purple-300"><strong>LP Bond Standard:</strong> All liquidity bonds require a lock period for yield optimization. Default is 30 days for maximum returns.</div>
                        </div>
                    </div> -->
                     <!-- onclick="setLockPeriod(1);" -->
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" class="lock-period-button p-3 rounded-lg border-2 text-sm transition-all disabled:opacity-50 disabled:cursor-not-allowed bg-[#1a1a23] border-[#322751] text-white hover:border-gray-500/50 hover:bg-gray-500/5">
                            <div class="font-medium">30 Days</div>
                            <div class="text-xs mt-1"><span class="text-gray-400">2.5% bonus <span class="text-red-400">(Quota Full)</span></span></div>
                        </button>
                        <button type="button" class="lock-period-button p-3 rounded-lg border-2 text-sm transition-all disabled:opacity-50 disabled:cursor-not-allowed bg-[#1a1a23] border-[#322751] text-white hover:border-purple-500/50 hover:bg-purple-500/5" onclick="setLockPeriod(2);">
                            <div class="font-medium">90 Days</div>
                            <div class="text-xs mt-1"><span class="text-purple-400">5% bonus</span></div>
                        </button>
                        <button type="button" class="lock-period-button p-3 rounded-lg border-2 text-sm transition-all disabled:opacity-50 disabled:cursor-not-allowed bg-[#1a1a23] border-[#322751] text-white hover:border-purple-500/50 hover:bg-purple-500/5" onclick="setLockPeriod(3);">
                            <div class="font-medium">180 Days</div>
                            <div class="text-xs mt-1"><span class="text-purple-400">7.5% bonus</span></div>
                        </button>
                        <button type="button" class="lock-period-button p-3 rounded-lg border-2 text-sm transition-all disabled:opacity-50 disabled:cursor-not-allowed bg-purple-500/10 border-purple-500 text-white shadow-lg shadow-purple-500/20" onclick="setLockPeriod(4);">
                            <div class="font-medium">360 Days</div>
                            <div class="text-xs mt-1"><span class="text-purple-300">10% bonus</span></div>
                        </button>
                    </div>
                    <div class="mt-3 p-2 bg-purple-900/20 border border-purple-700/30 rounded-lg">
                        <div class="flex items-center justify-between text-xs" id="lockPeriodDetails"><span class="text-purple-400 font-medium">Selected: 360 Days</span><span class="text-purple-300">10% bonus applied</span></div>
                    </div>
                </div>
                <!-- <div class="bg-green-900/20 border border-green-700/30 rounded-lg p-4 mb-4">
                    <h4 class="text-sm font-semibold text-green-400 mb-2">💰 Market Discount Applied</h4>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between items-center"><span class="text-gray-400">Original Amount:</span><span class="text-white line-through">$0.00</span></div>
                        <div class="flex justify-between items-center"><span class="text-gray-400">Discount (10%):</span><span class="text-green-400">-$0.00</span></div>
                        <div class="flex justify-between items-center border-t border-green-700/30 pt-1 mt-1"><span class="text-green-400 font-medium">You Pay:</span><span class="text-green-400 font-medium">$0.00</span></div>
                    </div>
                </div> -->
                <!-- <div class="bg-purple-900/20 border border-purple-700/30 rounded-lg p-3 mb-6">
                    <p class="text-xs text-purple-400"><strong>LP Creation Process:</strong> 50% of your USDT will be used to buy RTX tokens, then both assets are combined to create LP tokens. Minimum 1 USDT. Mandatory lock period of 360 days. Higher rewards than single token staking.</p>
                </div> -->
                <div class="flex gap-3">
                    <input type="hidden" name="transaction_hash" id="transaction_hash">
                    <input type="hidden" name="package" id="package" value="3">
                    <input type="hidden" name="lock_period" id="lock_period" value="4">
                    <button onclick="document.getElementById('stakertxnow-modal').classList.add('hidden')" type="button" class="flex-1 bg-gray-700 hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed text-white font-medium py-3 px-4 rounded-lg transition-colors">Cancel</button>
                    <button type="button" onclick="activatePackage(this);" id="proccessButton" class="flex-1 bg-gradient-to-r from-[#845dcb] to-[#6b3fb9] hover:from-[#6b3fb9] hover:to-[#5a2fa8] disabled:from-gray-600 disabled:to-gray-600 disabled:cursor-not-allowed text-white font-medium py-3 px-4 rounded-lg transition-all flex items-center justify-center">
                        Process
                    </button>
                    <!-- <button type="button" onclick="activatePackage(this);" class="flex-1 bg-gradient-to-r from-[#845dcb] to-[#6b3fb9] hover:from-[#6b3fb9] hover:to-[#5a2fa8] disabled:from-gray-600 disabled:to-gray-600 disabled:cursor-not-allowed text-white font-medium py-3 px-4 rounded-lg transition-all flex items-center justify-center">Process</button> -->
                </div>
            </form>
        </div>
    </div>
</div>

@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script src="{{asset('web3/ethers.umd.min.js')}}"></script>

<script src="{{asset('web3/web3.min.js')}}"></script>

<script src="{{asset('web3/web3.js?v=' . time())}}"></script>


<script type="text/javascript">
    let referrer = "{{$data['sponser']['wallet_address']}}"

    let lpLockPeriod;

    let buyContract = '0xA9D202213608f6661c1B46612270167751BeC8DD';

    let buyContractABI = '[{"anonymous":false,"inputs":[{"indexed":false,"internalType":"uint8","name":"version","type":"uint8"}],"name":"Initialized","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"previousOwner","type":"address"},{"indexed":true,"internalType":"address","name":"newOwner","type":"address"}],"name":"OwnershipTransferred","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"user","type":"address"},{"indexed":true,"internalType":"address","name":"referrer","type":"address"},{"indexed":false,"internalType":"uint256","name":"level","type":"uint256"},{"indexed":false,"internalType":"uint256","name":"amount","type":"uint256"},{"indexed":false,"internalType":"enum OrbitXPlan.StakeType","name":"stakeType","type":"uint8"}],"name":"UserBusinessAdded","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"user","type":"address"},{"indexed":false,"internalType":"uint256","name":"amount","type":"uint256"},{"indexed":false,"internalType":"uint256","name":"previousBalance","type":"uint256"},{"indexed":false,"internalType":"uint256","name":"newBalance","type":"uint256"}],"name":"UserRewardsUpdated","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"user","type":"address"},{"indexed":true,"internalType":"address","name":"referrer","type":"address"},{"indexed":false,"internalType":"uint256","name":"amount","type":"uint256"},{"indexed":false,"internalType":"uint256","name":"amountParsed","type":"uint256"},{"indexed":false,"internalType":"enum OrbitXPlan.StakeType","name":"stakeType","type":"uint8"}],"name":"UserStake","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"user","type":"address"},{"indexed":false,"internalType":"uint256","name":"amount","type":"uint256"},{"indexed":false,"internalType":"enum OrbitXPlan.StakeType","name":"stakeType","type":"uint8"}],"name":"UserWithdraw","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"user","type":"address"},{"indexed":false,"internalType":"uint256","name":"amount","type":"uint256"}],"name":"UserWithdrawFromRewards","type":"event"},{"inputs":[],"name":"DAYS_INTERVAL","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"enum OrbitXPlan.StakeType","name":"_stakeType","type":"uint8"},{"internalType":"uint256","name":"_amount","type":"uint256"}],"name":"getParsedAmount","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"_token","type":"address"},{"internalType":"enum OrbitXPlan.StakeType","name":"_stakeType","type":"uint8"}],"name":"getPrice","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"_token","type":"address"},{"internalType":"address","name":"_usdt","type":"address"},{"internalType":"address","name":"_priceOracle","type":"address"}],"name":"initialize","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"","type":"address"}],"name":"isValidCaller","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"enum OrbitXPlan.LockPeriod","name":"","type":"uint8"}],"name":"lockPeriods","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"owner","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"priceOracle","outputs":[{"internalType":"contract IPriceOracle","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"renounceOwnership","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"_caller","type":"address"},{"internalType":"bool","name":"_isValid","type":"bool"}],"name":"setValidCaller","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"_referrer","type":"address"},{"internalType":"uint256","name":"_amount","type":"uint256"},{"internalType":"enum OrbitXPlan.StakeType","name":"_stakeType","type":"uint8"},{"internalType":"enum OrbitXPlan.LockPeriod","name":"_lockPeriod","type":"uint8"}],"name":"stake","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"enum OrbitXPlan.StakeType","name":"","type":"uint8"}],"name":"stakingToken","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"newOwner","type":"address"}],"name":"transferOwnership","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address[]","name":"_users","type":"address[]"},{"internalType":"uint256[]","name":"_amounts","type":"uint256[]"}],"name":"updateRewardsOfUser","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"","type":"address"}],"name":"userEarnings","outputs":[{"internalType":"uint256","name":"totalStaked","type":"uint256"},{"internalType":"uint256","name":"availableBalance","type":"uint256"},{"internalType":"uint256","name":"lastClaimed","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"","type":"address"},{"internalType":"enum OrbitXPlan.StakeType","name":"","type":"uint8"}],"name":"userInfo","outputs":[{"internalType":"uint256","name":"amount","type":"uint256"},{"internalType":"enum OrbitXPlan.LockPeriod","name":"lockPeriod","type":"uint8"},{"internalType":"uint256","name":"claimed","type":"uint256"},{"internalType":"uint256","name":"lastStakedAt","type":"uint256"},{"internalType":"uint256","name":"lastClaimedAt","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"","type":"address"}],"name":"users","outputs":[{"internalType":"address","name":"referrer","type":"address"},{"internalType":"bool","name":"isActive","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"_amount","type":"uint256"},{"internalType":"enum OrbitXPlan.StakeType","name":"_stakeType","type":"uint8"}],"name":"withdraw","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"uint256","name":"_amount","type":"uint256"}],"name":"withdrawFromRewards","outputs":[],"stateMutability":"nonpayable","type":"function"}]';

    let buyContractInst;
</script>


<script>
    async function getRtxBalance() {
        walletAddress = await doConnect();

        const balance = await tokenInst.balanceOf(walletAddress);

        const formattedBalance = ethers.utils.formatUnits(balance, 18); // assumes 18 decimals

        // document.getElementById("availableRTX").innerHtml = formattedBalance;

        setHtml("availableRTX", formattedBalance);
    }

    async function amountInUsdt(rtxAmount) {
        let rtxPrice = {{$data['rtxPrice']}};

        document.getElementById("packageAmountUsdt").innerHTML = "Amount in $" + (rtxAmount * rtxPrice);
    }

    async function initializeData() {
        try {
            // if (!tokenInst) {
            //     setTimeout(() => {
            //         initializeData();
            //     }, 5000);
            //     return;
            // }

            let allowance = await tokenInst.allowance(walletAddress, buyContract)
            allowance = ethers.utils.formatUnits((allowance), 18)

            let amount = document.getElementById('packageAmount').value;

            if (parseFloat(allowance) >= parseFloat((amount.toString()))) {
                document.getElementById('proccessButton').innerHTML = 'Stable';
            } else {
                document.getElementById('proccessButton').innerHTML = 'Approve';
            }
        } catch (error) {
            console.log(error);
        }
    }

    // initializeData();

    async function setStakeAmount(percentage){
        var walletAddress = await doConnect();

        const balance = await tokenInst.balanceOf(walletAddress);

        const formattedBalance = ethers.utils.formatUnits(balance, 18); // assumes 18 decimals

        if (percentage == 100 || percentage == '100') {
            document.getElementById("packageAmount").value = formattedBalance;
        } else {
            document.getElementById("packageAmount").value = (formattedBalance * (percentage / 100));
        }

    }

    async function setLockPeriod(period) {
        lpLockPeriod = period;
        // Get all buttons
        const buttons = document.querySelectorAll('.lock-period-button');

        buttons.forEach((btn, index) => {
            if (index + 1 === period) {
                btn.classList.remove('bg-[#1a1a23]', 'border-[#322751]');
                btn.classList.add('bg-purple-500/10', 'border-purple-500', 'shadow-lg', 'shadow-purple-500/20');
            } else {
                btn.classList.remove('bg-purple-500/10', 'border-purple-500', 'shadow-lg', 'shadow-purple-500/20');
                btn.classList.add('bg-[#1a1a23]', 'border-[#322751]');
            }
        });

        if(lpLockPeriod == 1)
        {
            document.getElementById('lockPeriodDetails').innerHTML = `<span class="text-purple-400 font-medium">Selected: 30 Days</span><span class="text-purple-300">2.5% bonus applied</span>`
        }

        if(lpLockPeriod == 2)
        {
            document.getElementById('lockPeriodDetails').innerHTML = `<span class="text-purple-400 font-medium">Selected: 90 Days</span><span class="text-purple-300">5% bonus applied</span>`
        }

        if(lpLockPeriod == 3)
        {
            document.getElementById('lockPeriodDetails').innerHTML = `<span class="text-purple-400 font-medium">Selected: 180 Days</span><span class="text-purple-300">7.5% bonus applied</span>`
        }

        if(lpLockPeriod == 4)
        {
            document.getElementById('lockPeriodDetails').innerHTML = `<span class="text-purple-400 font-medium">Selected: 360 Days</span><span class="text-purple-300">10% bonus applied</span>`
        }

        document.getElementById("lock_period").value = lpLockPeriod;
    }

    getRtxBalance();

    async function activatePackage(btn) {
        btn.disabled = true;

        var amount = document.getElementById('packageAmount').value;

        if (amount <= 0) {
            showToast("error", "Please enter valid amount.");
            btn.disabled = false;
            return;
        }

        if (amount < 1) {
            showToast("error", "Minimum Investment Amount is 1 RTX.");
            btn.disabled = false;
            return;
        }

        // if (amount > 10000) {
        //     showToast("error", "Maximum Investment Amount is $10000.");
        //     btn.disabled = false;
        //     return;
        // }

        let extraText = '';

        let usdtAmount = amount;

        usdtAmount = ethers.utils.parseUnits((usdtAmount.toString()), 18);

        try {

            event.preventDefault();

            var walletAddress = await doConnect();

            var storedWalletAddress = "{{$data['user']['wallet_address']}}"

            if (storedWalletAddress.trim() == "") {
                btn.disabled = false;
                showToast("Update wallet address from profile first!!")
                return;
            }

            if (walletAddress.toLowerCase() !== storedWalletAddress.toLowerCase()) {
                btn.disabled = false;
                showToast("Update wallet address from profile first!!")
                return;
            }

            try {

                buyContractInst = new ethers.Contract(buyContract, buyContractABI, signer);

                let allowance = await tokenInst.allowance(walletAddress, buyContract)
                allowance = ethers.utils.formatUnits((allowance), 18)

                if (parseFloat(allowance) > parseFloat((amount.toString()))) {
                    let txn;
                    try {
                        btn.innerHTML = 'Staking...';
                        console.debug(usdtAmount, referrer, 3, lpLockPeriod ?? 4);
                        let gasPrice = await signer.provider.getGasPrice()
                        txn = await buyContractInst.stake(referrer, usdtAmount, 3, lpLockPeriod ?? 4);
                    } catch (err) {
                        btn.innerHTML = 'Stake';
                        btn.disabled = false;
                        console.debug(err);
                        swal("Package Activation", "Error while processing the transaction! Check balance, gas fees and try again.", "error")
                        return {
                            txn,
                            isErrorWithin: true
                        }
                    }
                    if (!txn && !txn?.isErrorWithin) {
                        swal("Package Activation", "Activation declined by the user!", "error")
                        btn.disabled = false;
                        btn.innerHTML = 'Stake';
                        return;
                    }
                    if (txn?.isErrorWithin) {
                        return;
                    }

                    showToast("info", "Confirming transaction.. Please Don't refresh the page!!!");

                    document.getElementById('transaction_hash').value = txn.hash ? txn.hash : txn;

                    document.getElementById('processPackage').submit();
                    btn.innerHTML = 'Stake';
                } else {
                    let txn;
                    try {
                        btn.innerHTML = 'Approving...';
                        let gasPrice = await signer.provider.getGasPrice()
                        txn = await tokenInst.approve(buyContract, ethers.constants.MaxUint256);
                    } catch (err) {
                        btn.disabled = false;
                        btn.innerHTML = 'Process';

                        swal("Package Activation", "Error while processing the transaction! Check balance, gas fees and try again.", "error")
                        return {
                            txn,
                            isErrorWithin: true
                        }
                    }
                    if (!txn && !txn?.isErrorWithin) {
                        swal("Package Activation", "Activation declined by the user!", "error")
                        btn.disabled = false
                        btn.innerHTML = 'Process';
                        return;
                    }
                    if (txn?.isErrorWithin) {
                        return;
                    }

                    // showToast("info", "Confirming transaction.. Please Don't refresh the page!!!");

                    
                    await txn.wait();
                    showToast("info", "Successfully approved contract to activate package.");
                    btn.innerHTML = 'Stake';
                    btn.disabled = false;

                    return;

                    // let txnBuy;
                    // try {
                    //     console.debug(usdtAmount, referrer, 3, lpLockPeriod);
                    //     let gasPrice = await signer.provider.getGasPrice()
                    //     txnBuy = await buyContractInst.stake(referrer, usdtAmount, 3, lpLockPeriod);
                    // } catch (err) {
                    //     btn.disabled = false;

                    //     swal("Package Activation", "Error while processing the transaction! Check balance, gas fees and try again.", "error")
                    //     return {
                    //         txnBuy,
                    //         isErrorWithin: true
                    //     }
                    // }
                    // if (!txnBuy && !txnBuy?.isErrorWithin) {
                    //     btn.disabled = false;
                    //     swal("Package Activation", "Activation declined by the user!", "error")
                    //     return;
                    // }

                    // if (txnBuy?.isErrorWithin) {
                    //     return;
                    // }

                    // showToast("info", "Confirming transaction.. Please Don't refresh the page!!!");

                    // document.getElementById('transaction_hash').value = txnBuy.hash ? txnBuy.hash : txnBuy;

                    // document.getElementById('processPackage').submit();
                }
            } catch (err) {
                console.debug(err);
                btn.disabled = false;
                btn.innerHTML = 'Process';
                showToast("error", err['data'] ? err['data']['message'] : err['message']);
            }

        } catch (err) {
            console.debug(err);
            btn.disabled = false;
            btn.innerHTML = 'Process';
            showToast("error", "->" + err);
        }

        btn.disabled = false
    }

    async function processUnstake(btn) {
        try {
            event.preventDefault();
            btn.disabled = true;

            let finalAmount = document.getElementById('yourunstakeamount').value;

            console.debug(finalAmount)

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
            let txn;
            // let gasPrice = await signer.provider.getGasPrice()
            btn.innerHTML = 'Processing...';
            txn = await buyContractInst.withdraw(usdtAmount, 3);
            showToast("info", "Confirming transaction.. Please Don't refresh the page!!!");

            document.getElementById('unstake_transaction_hash').value = txn.hash ? txn.hash : txn;

            document.getElementById("unstake-process-form").submit();
        } catch (err) {
            btn.disabled = false;
            btn.innerHTML = 'Process';
            showToast("warning", err['data'] ? err['data']['message'] : err['reason'] ? err['reason'] : err['message']);
        }

        }
</script>

<script type="text/javascript">
    async function processWithdraw(btn) {
        try {
            event.preventDefault();
            btn.disabled = true;

            let finalAmount = document.getElementById('yourfinalamount').value;

            console.debug(finalAmount)

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
            let txn;
            // let gasPrice = await signer.provider.getGasPrice()
            btn.innerHTML = 'Claiming...';
            txn = await buyContractInst.withdraw(usdtAmount, 3);
            showToast("info", "Confirming transaction.. Please Don't refresh the page!!!");

            document.getElementById('unstake_transaction_hash').value = txn.hash ? txn.hash : txn;

            document.getElementById("unstake-process-form").submit();
        } catch (err) {
            btn.disabled = false;
            btn.innerHTML = 'Process';
            showToast("warning", err['data'] ? err['data']['message'] : err['reason'] ? err['reason'] : err['message']);
        }
    }
</script>
@endsection