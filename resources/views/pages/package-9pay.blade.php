@extends('layouts.app')

@section('title', 'Package 9 Pay')

@section('content')
<section class="w-full p-3 md:p-5 mx-auto max-w-[1400px]">
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-5">
        <div class="cols-span-1 xl:col-span-1"></div>
        <!-- Coin Choose -->
        <div id="paymentChoose" class="cols-span-1 xl:col-span-2 max-w-md mx-auto">
            <h3 class="font-semibold text-xl md:text-2xl mb-4 flex items-center justify-start gap-2">EVM QR Code</h3>
            <div class="rankingboxbg relative border border-[#2b2b2f] p-4 rounded-lg max-w-md mx-auto w-full">
                <h3 class="text-white pb-3 font-medium text-xl block text-center"><span class="uppercase">eth</span> Chain</h3>
                <div class="w-full flex-1 text-center mx-auto space-y-4">
                    <div class="qrcodebpx">
                        @if($data['chain'] == "tron")
                        {!! $data['trcqrCode'] !!}
                        @else
                        {!! $data['evmqrCode'] !!}
                        @endif
                    </div>
                    @if(!empty($data['received_amount']))
                    <div class="boxbgsvg1 bg-white bg-opacity-20 relative p-4 rounded-lg flex items-center justify-between">
                        <div class="flex items-center space-x-3 w-full">
                            <div class="w-full text-left">
                                <h3 class="text-base mb-2 leading-none">Received Amount :</h3>
                                <div class="bg-white bg-opacity-10 px-2 py-0.5 leading-none rounded flex items-center justify-between">
                                    <span class="text-base truncate text-ellipsis overflow-hidden">{{$data['received_amount']}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="boxbgsvg1 bg-white bg-opacity-20 relative p-4 rounded-lg flex items-center justify-between">
                        <div class="flex items-center space-x-3 w-full">
                            <div class="w-full text-left">
                                <h3 class="text-base mb-2 leading-none">Address :</h3>
                                <div class="bg-white bg-opacity-10 px-2 py-0.5 leading-none rounded flex items-center justify-between">
                                    @if($data['chain'] == "tron")
                                    <span id="copyOgEvmAddress" class="text-xs truncate text-ellipsis overflow-hidden">{{$data['trc_address']}}</span>
                                    @else
                                    <span id="copyOgEvmAddress" class="text-xs truncate text-ellipsis overflow-hidden">{{$data['evm_address']}}</span>
                                    @endif
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
                                    <span id="copyAmount" class="text-xs text-xs truncate text-ellipsis overflow-hidden">{{$data['amount'] + $data['fees_amount']}}</span>
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
                    @if(empty($data['received_amount']))
                    <a href="{{route('fcancelPayTransaction')}}"><button class="py-3 px-6 button-primary text-white tracking-wider rounded-xl transition duration-200 w-28 mb-3 mx-auto">Cancel</button></a>
                    @endif
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
<script type="text/javascript">
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
    $(document).ready(function() {
        // Function to call the AJAX request every 10 seconds
        function checkPackageStatus() {
            $.ajax({
                url: '{{route("fajaxActivatePackage")}}', // The URL of the function to call
                type: 'GET', // HTTP method (GET or POST)
                dataType: 'json', // Expect a JSON response
                success: function(response) {
                    if (response.status_code === 1) {
                        // Show Toastr notification
                        toastr.success('Package activated successfully! Redirecting...');

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
@endsection