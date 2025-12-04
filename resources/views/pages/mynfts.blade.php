@extends('layouts.app')

@section('title', 'Login')

@section('content')
<section class="w-full p-3 md:p-8 mx-auto max-w-[1400px]">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($data['nfts'] as $key => $value)
        <div class="relative p-4 md:p-6 rounded-xl w-full mx-auto border border-[#24324d] bg-[#101735] text-left">
            <img src={{ asset('assets/images/nfts/1.webp') }} width="350" height="350" alt="Logo" class="w-full h-auto rounded-xl">
            <h3 class="text-base md:text-xl leading-none flex items-start justify-center capitalize my-3 text-center mt-5">NFT ${{$value['amount']}}</h3>
            <!-- Skate Button Start-->
            <div class="flex flex-col gap-2 mb-3 max-w-full text-left w-full">
                <h3 class="text-sm sm:text-base opacity-75 leading-none flex items-center justify-between py-3 border-b border-white border-opacity-25">Token Id : <span class="text-white font-bold">{{$value['tokenId']}}</span></h3>
                <div class="w-full">
                    <h3 class="text-base leading-none my-1">Nft Address :</h3>
                    <div class="bg-white bg-opacity-5 px-2 py-0.5 leading-none rounded flex items-center justify-between">
                        <span id="referral-link" class="text-xs text-xs truncate text-ellipsis overflow-hidden">{{$value['nftAddress']}}</span>
                        <button onclick="copyText('{{$value['nftAddress']}}'); showToast('success', 'Copied to clipboard!')" class="ml-2 p-1 border-l border-white border-opacity-20">
                            <svg class="w-6 h-6 min-w-6 min-h-6 ml-2" viewBox="0 0 1024 1024">
                                <path fill="#ffffff" d="M768 832a128 128 0 0 1-128 128H192A128 128 0 0 1 64 832V384a128 128 0 0 1 128-128v64a64 64 0 0 0-64 64v448a64 64 0 0 0 64 64h448a64 64 0 0 0 64-64h64z"></path>
                                <path fill="#ffffff" d="M384 128a64 64 0 0 0-64 64v448a64 64 0 0 0 64 64h448a64 64 0 0 0 64-64V192a64 64 0 0 0-64-64H384zm0-64h448a128 128 0 0 1 128 128v448a128 128 0 0 1-128 128H384a128 128 0 0 1-128-128V192A128 128 0 0 1 384 64z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="w-full">
                    <h3 class="text-base leading-none my-1">Transaction Hash :</h3>
                    <div class="bg-white bg-opacity-5 px-2 py-0.5 leading-none rounded flex items-center justify-between">
                        <span id="referral-link" class="text-xs text-xs truncate text-ellipsis overflow-hidden">{{$value['nftTransactionHash']}}</span>
                        <button onclick="copyText('{{$value['nftTransactionHash']}}'); showToast('success', 'Copied to clipboard!')" class="ml-2 p-1 border-l border-white border-opacity-20">
                            <svg class="w-6 h-6 min-w-6 min-h-6 ml-2" viewBox="0 0 1024 1024">
                                <path fill="#ffffff" d="M768 832a128 128 0 0 1-128 128H192A128 128 0 0 1 64 832V384a128 128 0 0 1 128-128v64a64 64 0 0 0-64 64v448a64 64 0 0 0 64 64h448a64 64 0 0 0 64-64h64z"></path>
                                <path fill="#ffffff" d="M384 128a64 64 0 0 0-64 64v448a64 64 0 0 0 64 64h448a64 64 0 0 0 64-64V192a64 64 0 0 0-64-64H384zm0-64h448a128 128 0 0 1 128 128v448a128 128 0 0 1-128 128H384a128 128 0 0 1-128-128V192A128 128 0 0 1 384 64z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <a href="javascript:void(0);" onclick="importNFT('{{$value['nftAddress']}}', {{$value['tokenId']}});" class="px-4 py-1 text-white buttonbg mx-auto flex items-center text-base capitalize tracking-wider mt-6">
                    <span class="w-full">Import</span>
                    <svg id="svg1-icon" class="w-6 h-6 transition-transform duration-500 group-hover:translate-x-1" data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path clip-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" fill-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
            <!-- Skate Button End -->
        </div>
        @endforeach

    </div>
        @if(count($data['nfts']) == 0)
            <h3 class="text-base md:text-xl leading-none flex items-start justify-center mx-auto capitalize my-3 text-center mt-5">NO NFT'S FOUND</h3>
        @endif

    <!-- button Topup Balance start -->

</section>
<script type="text/javascript">
    function copyText(Text) {
        navigator.clipboard.writeText(Text).catch(() => {
            console.error("Failed to copy text!");
        });
    }
</script>
@endsection

@section('script')


<script src="{{asset('web3/ethers.umd.min.js')}}"></script>

<script src="{{asset('web3/web3.min.js')}}"></script>

<script src="{{asset('web3/web3.js')}}"></script>
<script type="text/javascript">
    async function importNFT(nft, tokenId) {
        var walletAddress = await doConnect();
        try {
            await window.ethereum.request({
                method: 'wallet_watchAsset',
                params: {
                    type: 'ERC721', // This currently won't work in MetaMask
                    options: {
                        address: nft,
                        tokenId: tokenId.toString(),
                        symbol: 'Doodles',
                        image: "{{ asset('assets/images/nfts/1.webp') }}",
                        decimals: 0,
                    },
                },
            });
        } catch (e) {
            showToast("warning", e.data ? e.data.message : e.message);
        }
    }
</script>
@endsection