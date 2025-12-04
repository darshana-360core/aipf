@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<section class="w-full p-3 md:p-5 mx-auto max-w-[1400px]">
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-5">
        <div class="cols-span-1 xl:col-span-1"></div>
        <!-- Network Choose -->
        <div id="networkChoose" class="cols-span-1 xl:col-span-2 rankingboxbg relative border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
            <div class="w-full">
                <h3 class="font-semibold text-xl md:text-2xl mb-4">Choose Network</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div onclick="chooseCoin('evm', 'eth')" class="boxbgsvg relative cursor-pointer border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
                        <div class="flex items-center space-x-3 w-full gap-1">
                            <img src={{ asset('assets/images/coin-icon/eth.png') }} width="64" height="48" alt="ETH" class="w-16 h-auto">
                            <div class="w-full">
                                <h3 class="text-base mb-2 opacity-75 leading-none">ETH</h3>
                            </div>
                        </div>
                    </div>
                    <div onclick="chooseCoin('evm', 'bsc')" class="boxbgsvg relative cursor-pointer border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
                        <div class="flex items-center space-x-3 w-full gap-1">
                            <img src={{ asset('assets/images/coin-icon/bsc.png') }} width="64" height="48" alt="BSC" class="w-16 h-auto">
                            <div class="w-full">
                                <h3 class="text-base mb-2 opacity-75 leading-none">BSC</h3>
                            </div>
                        </div>
                    </div>
                    <div onclick="chooseCoin('evm', 'polygon')" class="boxbgsvg relative cursor-pointer border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
                        <div class="flex items-center space-x-3 w-full gap-1">
                            <img src={{ asset('assets/images/coin-icon/polygone.png') }} width="64" height="48" alt="POLYGON" class="w-16 h-auto">
                            <div class="w-full">
                                <h3 class="text-base mb-2 opacity-75 leading-none">POLYGON</h3>
                            </div>
                        </div>
                    </div>
                    <div onclick="chooseCoin('trc', 'tron')" class="boxbgsvg relative cursor-pointer border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
                        <div class="flex items-center space-x-3 w-full gap-1">
                            <img src={{ asset('assets/images/coin-icon/trc.png') }} width="64" height="48" alt="TRC" class="w-16 h-auto">
                            <div class="w-full">
                                <h3 class="text-base mb-2 opacity-75 leading-none">TRC</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Coin Choose -->
        <div id="coinChoose" style="display: none;" class="cols-span-1 xl:col-span-2 rankingboxbg relative border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
            <div class="w-full">
                <h3 class="font-semibold text-xl md:text-2xl mb-4 flex items-center justify-start gap-2">
                    <span onclick="backScreen(1, 'networkChoose', 'coinChoose');">
                        <svg class="p-1.5 w-7 h-7 min-w-7 min-h-7 border border-white border-opacity-80 rounded-full cursor-pointer" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M768 903.232l-50.432 56.768L256 512l461.568-448 50.432 56.768L364.928 512z" fill="#ffffff" />
                        </svg>
                    </span> Choose Coin
                </h3>
                <div class="w-full flex-1 mt-4 text-center mx-auto mt-8">
                    <div class="relative space-y-5">
                        <!-- Select option -->
                        <select id="coinSelect" onchange="selectCoinChain('USDT');" class="border border-white border-opacity-15 p-3 rounded outline-none shadow-none bg-transparent w-full block text-base selectbox">
                            <option value="" disabled selected>Select an option</option>
                            <option class="text-black" id="usdtToken" value="USDT">USDT</option>
                        </select>
                        <!-- Name -->
                        <input type="text" id="coin_amount" class=" border border-white border-opacity-15 p-3 rounded outline-none shadow-none bg-transparent w-full block text-base" placeholder="Enter your amount">
                    </div>

                    <!-- button start -->
                    <div class="flex items-center justify-center mt-6 relative group">
                        <button onclick="choosePaymentOption()" class="w-full relative inline-block p-px font-semibold leading-none text-white cursor-pointer rounded-sm">
                            <span class="absolute inset-0 rounded-sm bg-gradient-to-r from-teal-400 via-blue-500 to-purple-500 p-[2px]"></span>
                            <span class="relative z-10 block px-6 py-3 rounded-sm">
                                <div class="relative z-10 flex items-center space-x-2 justify-center">
                                    <span class="transition-all duration-500 group-hover:translate-x-1">Continue</span>
                                    <svg class="w-6 h-6 transition-transform duration-500 group-hover:translate-x-1" data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path clip-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" fill-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </span>
                        </button>
                    </div>
                    <!-- button end -->
                </div>
            </div>
        </div>
        <!-- Coin Choose -->
        <div id="paymentChoose" style="display: none;" class="cols-span-1 xl:col-span-2 max-w-md mx-auto">
            <h3 class="font-semibold text-xl md:text-2xl mb-4 flex items-center justify-start gap-2">EVM QR Code</h3>
            <div class="rankingboxbg relative border border-[#2b2b2f] p-4 rounded-lg max-w-md mx-auto w-full">
                <h3 class="text-white pb-3 font-medium text-xl block text-center"><span class="uppercase" id="chainSelected"></span> Chain</h3>
                <div class="w-full flex-1 text-center mx-auto space-y-4">
                    <div id="paymentEVM">
                        {!! $data['evmqrCode'] !!}
                    </div>
                    <div id="paymentTRC">
                        {!! $data['trcqrCode'] !!}
                    </div>
                    <div class="boxbgsvg1 bg-white bg-opacity-20 relative p-4 rounded-lg flex items-center justify-between">
                        <div class="flex items-center space-x-3 w-full">
                            <div class="w-full text-left">
                                <h3 class="text-base mb-2 leading-none">Address :</h3>
                                <div class="bg-white bg-opacity-10 px-2 py-0.5 leading-none rounded flex items-center justify-between">
                                    <span id="copyOgEvmAddress" class="text-xs truncate text-ellipsis overflow-hidden">{{$data['evm_address']}}</span>
                                    <span class="text-xs truncate text-ellipsis overflow-hidden" id="evmtokenAddress">{{$data['evm_address']}}</span>
                                    <span class="text-xs truncate text-ellipsis overflow-hidden" id="trctokenAddress">{{$data['trc_address']}}</span>
                                    <button onclick="copyOgEvmAddress(); showToast('success', 'Copied to clipboard!')" class="ml-2 p-1 border-l border-white border-opacity-20">
                                        <svg class="w-6 h-6 min-w-6 min-h-6 ml-2" viewBox="0 0 1024 1024">
                                            <path fill="#ffffff" d="M768 832a128 128 0 0 1-128 128H192A128 128 0 0 1 64 832V384a128 128 0 0 1 128-128v64a64 64 0 0 0-64 64v448a64 64 0 0 0 64 64h448a64 64 0 0 0 64-64h64z" />
                                            <path fill="#ffffff" d="M384 128a64 64 0 0 0-64 64v448a64 64 0 0 0 64 64h448a64 64 0 0 0 64-64V192a64 64 0 0 0-64-64H384zm0-64h448a128 128 0 0 1 128 128v448a128 128 0 0 1-128 128H384a128 128 0 0 1-128-128V192A128 128 0 0 1 384 64z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="boxbgsvg1 bg-white bg-opacity-20 relative p-4 rounded-lg flex items-center justify-between">
                        <div class="flex items-center space-x-3 w-full">
                            <div class="w-full text-left">
                                <h3 class="text-base mb-2 leading-none">Amount :</h3>
                                <div class="bg-white bg-opacity-10 px-2 py-0.5 leading-none rounded flex items-center justify-between">
                                    <span id="copyAmount" class="text-xs text-xs truncate text-ellipsis overflow-hidden"><span id="coin-amount-text"></span><span id="coin-amount-text-trc"></span></< /span>
                                        <button onclick="copyAmount(); showToast('success', 'Copied to clipboard!')" class="ml-2 p-1 border-l border-white border-opacity-20">
                                            <svg class="w-6 h-6 min-w-6 min-h-6 ml-2" viewBox="0 0 1024 1024">
                                                <path fill="#ffffff" d="M768 832a128 128 0 0 1-128 128H192A128 128 0 0 1 64 832V384a128 128 0 0 1 128-128v64a64 64 0 0 0-64 64v448a64 64 0 0 0 64 64h448a64 64 0 0 0 64-64h64z" />
                                                <path fill="#ffffff" d="M384 128a64 64 0 0 0-64 64v448a64 64 0 0 0 64 64h448a64 64 0 0 0 64-64V192a64 64 0 0 0-64-64H384zm0-64h448a128 128 0 0 1 128 128v448a128 128 0 0 1-128 128H384a128 128 0 0 1-128-128V192A128 128 0 0 1 384 64z" />
                                            </svg>
                                        </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 rounded-xl w-full mx-auto border border-[#2b2b2f] bg-black relative boxbgsvg1 space-y-4 mt-5">
                <h3 class="font-semibold text-xl md:text-2xl mb-4">Disclaimer</h3>
                <div class="boxbgsvg relative border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
                    <div class="flex items-center space-x-3 w-full gap-1">
                        <div class="text-2xl flex items-center justify-center w-12 h-12 min-w-12 min-h-12 rounded-full border border-white border-opacity-15 bg-white bg-opacity-10 text-center">1</div>
                        <div class="w-full">
                            <h3 class="text-base mb-2 opacity-75 leading-none">Activate Package Usage : Only the top-up balance can be used for activating packages.</h3>
                        </div>
                    </div>
                </div>
                <div class="boxbgsvg relative border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
                    <div class="flex items-center space-x-3 w-full gap-1">
                        <div class="text-2xl flex items-center justify-center w-12 h-12 min-w-12 min-h-12 rounded-full border border-white border-opacity-15 bg-white bg-opacity-10 text-center">2</div>
                        <div class="w-full">
                            <h3 class="text-base mb-2 opacity-75 leading-none">Exclusive Use of Top-Up Balance : The top-up balance is not applicable for any other purposes.</h3>
                        </div>
                    </div>
                </div>
                <div class="boxbgsvg relative border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
                    <div class="flex items-center space-x-3 w-full gap-1">
                        <div class="text-2xl flex items-center justify-center w-12 h-12 min-w-12 min-h-12 rounded-full border border-white border-opacity-15 bg-white bg-opacity-10 text-center">3</div>
                        <div class="w-full">
                            <h3 class="text-base mb-2 opacity-75 leading-none">Top-Up Wallet Balance: Select and verify the blockchain network before adding balance to the top-up wallet.</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cols-span-1 xl:col-span-1"></div>
    </div>
</section>
@endsection

@section('script')
<script>
    let selectedNetwork = '';
    let selectedCoin = '';
    let selectedChain = '';
    let ethUsdt = "0xdac17f958d2ee523a2206206994597c13d831ec7";
    let ethUsdc = "0xa0b86991c6218b36c1d19d4a2e9eb0ce3606eb48";
    let bscUsdt = "0x55d398326f99059ff775485246999027b3197955";
    let bscUsdc = "0x8ac76a51cc950d9822d68b83fe1ad97b32cd580d";
    let polUsdt = "0xc2132d05d31c914a87c6611c10748aeb04b58e8f";
    let polUsdc = "0x2791bca1f2de4661ed88a30c99a7a9449aa84174";
    let trcUsdt = "TXYZopYRdj2D9XRtbG411XZZ3kM5VkAeBf";

    function copyOgEvmAddress() {
        const linkElement = document.getElementById("copyOgEvmAddress");
        if (!linkElement) {
            console.error("Referral link element not found!");
            return;
        }
        const link = linkElement.innerText;
        navigator.clipboard.writeText(link).catch(() => {
            console.error("Failed to copy text!");
        });
    }

    function copyAmount() {
        const linkElement = document.getElementById("copyAmount");
        if (!linkElement) {
            console.error("Referral link element not found!");
            return;
        }
        const link = linkElement.innerText;
        navigator.clipboard.writeText(link).catch(() => {
            console.error("Failed to copy text!");
        });
    }

    function chooseCoin(network, chain) {
        document.getElementById("coinSelect").value = "USDT";
        selectCoinChain("USDT");
        selectedNetwork = network;
        selectedChain = chain;
        document.getElementById('networkChoose').style.display = "None";
        document.getElementById('coinChoose').style.display = "Block";
    }

    function selectCoinChain(coin) {
        selectedCoin = coin;
    }
    let minamount = 10;

    function choosePaymentOption() {
        let amount = document.getElementById("coin_amount").value;
        if (amount < minamount) {
            toastr.error("Minimum package amount is " + minamount);
            return false;
        }

        if (selectedNetwork == "evm") {
            document.getElementById("paymentEVM").style.display = "block";
            document.getElementById("paymentTRC").style.display = "none";
        } else {
            document.getElementById("paymentTRC").style.display = "block";
            document.getElementById("paymentEVM").style.display = "none";
        }

        document.getElementById('chainSelected').innerHTML = selectedChain;

        if (selectedChain == "eth") {
            if (selectedCoin == "USDT") {
                document.getElementById('evmtokenAddress').innerHTML = selectedCoin + " - " + ethUsdt
            } else {
                document.getElementById('evmtokenAddress').innerHTML = selectedCoin + " - " + ethUsdc
            }
        }

        if (selectedChain == "bsc") {
            if (selectedCoin == "USDT") {
                document.getElementById('evmtokenAddress').innerHTML = selectedCoin + " - " + bscUsdt
            } else {
                document.getElementById('evmtokenAddress').innerHTML = selectedCoin + " - " + bscUsdc
            }
        }

        if (selectedChain == "polygon") {
            if (selectedCoin == "USDT") {
                document.getElementById('evmtokenAddress').innerHTML = selectedCoin + " - " + polUsdt
            } else {
                document.getElementById('evmtokenAddress').innerHTML = selectedCoin + " - " + polUsdc
            }
        }

        if (selectedChain == "tron") {
            if (selectedCoin == "USDT") {
                document.getElementById('trctokenAddress').innerHTML = selectedCoin + " - " + trcUsdt
            }
        }

        let fees = 0;

        document.getElementById("coin-amount-text").innerHTML = parseInt(amount) + fees;
        document.getElementById("coin-amount-text-trc").innerHTML = parseInt(amount) + fees;

        storePackage9Pay(amount, fees, selectedChain);
    }

    function backScreen(level, bd, hd) {
        document.getElementById(bd).style.display = "block";
        document.getElementById(hd).style.display = "none";
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        // Function to call the AJAX request every 10 seconds

        function checkPackageStatus() {
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                url: '{{route("fajaxActivatePackage")}}', // The URL of the function to call
                type: 'GET', // HTTP method (GET or POST)
                dataType: 'json', // Expect a JSON response
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Add the CSRF token here
                },
                success: function(response) {
                    if (response.status_code === 1) {
                        // Show Toastr notification
                        toastr.success(response.message);

                        // Redirect to the check package transaction route after 2 seconds
                        setTimeout(function() {
                            window.location.href = '{{route("packages")}}';
                        }, 2000);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error); // Log any errors
                }
            });
        }

        // Call the function every 10 seconds
        setInterval(checkPackageStatus, 10000);
    });
</script>

<script type="text/javascript">
    function storePackage9Pay(amount, fees_amount, chain) {
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: '{{route("fajaxStorePackage")}}', // API endpoint
            type: 'POST', // HTTP method
            data: {
                amount: amount,
                fees_amount: fees_amount,
                chain: chain
            }, // Data to send in the request
            headers: {
                'X-CSRF-TOKEN': csrfToken // Add the CSRF token here
            },
            success: function(response) { // Success callback
                // console.log('Form submitted successfully:', response);
                window.location.href = "{{route('topup9pay')}}";
            },
            error: function(xhr, status, error) { // Error callback
                console.error('Error:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
            }
        });

    }
</script>
@endsection