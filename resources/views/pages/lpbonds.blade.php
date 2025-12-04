@extends('layouts.app')

@section('title', 'LP Bonds')

@section('content')
<section class="grid grid-cols-1 gap-5 mt-5">
    @if(isset($data['confirmTransactionWindow']))
        <div class="data-card container mx-auto">
            <div class="p-3 md:p-6 rounded-md border border-[#1d2753] bg-gradient-to-t from-[#265e8c] via-[#255480] to-[#243f82] relative shadow-inner w-full mx-auto">
                <div class="border-0 border-white rounded-xl">
                    <div class="relative text-center p-3 md:p-3 shadow-inner">
                        <div class="card-data text-l md:text-xl  font-semibold text-white">System has found transaction for stake LP bond. Please verify transaction to activate. </div>
                        <div class="text-lg text-white mx-auto my-3">Stake Amount ${{$data['pending_package_amount']}}</div>
                        <div class="break-words card-data text-l md:text-xl font-semibold text-white">Transaction Hash : {{ substr($data['pending_transaction_hash'], 0, 4) }} ... {{ substr($data['pending_transaction_hash'], -4) }} <i class="las la-copy cursor-pointer" onclick="copyTransactionHash('{{$data['pending_transaction_hash']}}');"></i></div>


                        <div class="flex items-center justify-center my-4 relative group">
                            <a id="transactionStatusLink" class="mb-5 mt-2 block text-center" href="{{route('check_package_transaction')}}">
                                <button class="px-4 py-1 text-white buttonbg mx-auto flex items-center text-base capitalize tracking-wider" type="button">
                                    <span class="relative z-10 block px-6 py-3 rounded-sm">
                                        <div class="relative z-10 flex items-center space-x-2 justify-center">
                                            <span class="transition-all duration-500 group-hover:translate-x-1">Verify Transaction</span>
                                            <svg class="w-6 h-6 transition-transform duration-500 group-hover:translate-x-1" data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path clip-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" fill-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </span>
                                </button>
                            </a>
                        </div>
                        <h3 class="data-des text-base text-white">Your transaction is in process it will take 2-3 minutes to process please wait. </h3>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="w-full p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl">
            <h2 class='text-lg'>LP Bonds Staking</h2>
            <p class='text-sm text-gray-400 mb-4'>Earn higher rewards by staking LP tokens</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 mt-5">
                <!-- <x-item-box
                    imageSrc=""
                    title="Total Staked"
                    :values="number_format($data['total_staked_amount'], 3).' RTX'"
                    flex="flex-col"
                    imgHide="hidden"
                    bgColor="[#171531]" /> -->

                <x-item-box
                    imageSrc=""
                    title="Your Staked in LP"
                    :values="number_format($data['staked_amount'], 3) .' RTX'"
                    flex="flex-col"
                    imgHide="hidden"
                    bgColor="[#171531]" />

                <x-item-box
                    imageSrc=""
                    title="Compounded Stake"
                    :values="number_format(($data['compound_amount'] - $data['total_unstake_amount']), 3) .' RTX'"
                    flex="flex-col"
                    imgHide="hidden"
                    bgColor="[#171531]" />

                <x-item-box
                    imageSrc=""
                    title="Generated ROI"
                    :values="number_format($data['generated_roi'], 3) . ' RTX'"
                    flex="flex-col"
                    imgHide="hidden"
                    bgColor="[#171531]" />
            </div>
            <div x-data="{ activeTab: 'stake' }" class="w-full">

                <!-- Tabs -->
                <div class="flex items-center justify-center space-x-4 border-b border-[#322751] mb-4 mt-6">
                    <button
                        @click="activeTab = 'stake'"
                        :class="activeTab === 'stake'
                    ? 'text-[#8688ff] border-b-2 border-[#c29023] bg-gradient-to-r from-[#ffcd60] to-[#9564ff] bg-clip-text text-transparent'
                    : 'text-gray-400 hover:text-white'"
                        class="px-4 py-2 text-lg md:text-xl font-medium rounded-t-md uppercase">
                        Stake
                    </button>
                    <button
                        @click="activeTab = 'unstake'"
                        :class="activeTab === 'unstake'
                    ? 'text-[#8688ff] border-b-2 border-[#c29023] bg-gradient-to-r from-[#ffcd60] to-[#9564ff] bg-clip-text text-transparent'
                    : 'text-gray-400 hover:text-white'"
                        class="px-4 py-2 text-lg md:text-xl font-medium rounded-t-md uppercase">
                        Unstake
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="text-sm text-gray-300">
                    <div x-show="activeTab === 'stake'" x-transition>
                        @include('components.stake-lp')
                    </div>
                    <div x-show="activeTab === 'unstake'" x-transition>
                        @include('components.unstake-lp')
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection