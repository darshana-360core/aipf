@extends('layouts.app')

@section('title', 'Claim Bonus')

@section('style')
<style type="text/css">
    .swal-button {
        background-color: #a855f7 !important;
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
    }
</style>
@endsection
@section('content')
<section class="w-full p-3 md:p-5 mx-auto max-w-[1400px]">
    <!-- <h2 class="bg-blue-500 relative rankinginfo4 text-white rounded-sm p-3 text-lg font-normal leading-none mb-5 flex items-center gap-2">
        <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 17V11" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
            <circle cx="1" cy="1" r="1" transform="matrix(1 0 0 -1 11 9)" fill="#ffffff" />
            <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        Due to polygon congestion, withdrawals are slowly processed.
    </h2> -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
      <!--  <x-stat-box
            title="Stake Bonus"
            valuesDolur="${{ number_format($data['stake_bonus'] * $data['rtxPrice'], 3) }}"
            :value="number_format($data['stake_bonus'], 3) . ' RTX'"
            bgColor="#ffe1a0"
            borderColor="#ffe1a0"
            imageSrc="{{ asset('assets/images/icons/reward-bonus.webp') }}" />-->

        <x-stat-box
            title="Upline Bonus"
            valuesDolur="${{ number_format($data['user']['direct_income'] * $data['rtxPrice'], 3) }}"
            :value="number_format($data['user']['direct_income'], 3) . ' RTX'"
            bgColor="#ffa0b7"
            borderColor="#ffa0b7"
            imageSrc="{{ asset('assets/images/income-icons/rank-income.webp') }}" />

        <x-stat-box
            title="Level Income"
            valuesDolur="${{ number_format($data['user']['level_income'] * $data['rtxPrice'], 3) }}"
            :value="number_format($data['user']['level_income'], 3) . ' RTX'"
            bgColor="#F2A0FF"
            borderColor="#F2A0FF"
            imageSrc="{{ asset('assets/images/income-icons/level-income.webp') }}" />

        <x-stat-box
            title="Star Bonus"
            valuesDolur="${{ number_format($data['user']['rank_bonus'] * $data['rtxPrice'], 3) }}"
            :value="number_format($data['user']['rank_bonus'], 3) . ' RTX'"
            bgColor="#FAD85D"
            borderColor="#FAD85D"
            imageSrc="{{ asset('assets/images/income-icons/rank-income.webp') }}" />

        <x-stat-box
            title="Club Bonus"
            valuesDolur="${{ number_format($data['user']['club_bonus'] * $data['rtxPrice'], 3) }}"
            :value="number_format($data['user']['club_bonus'], 3) . ' RTX'"
            bgColor="#aea0ff"
            borderColor="#aea0ff"
            imageSrc="{{ asset('assets/images/income-icons/leadership.webp') }}" />

        <x-stat-box
            title="Daily Pool Bonus"
            valuesDolur="${{ number_format($data['dailyPoolWinners'] * $data['rtxPrice'], 3) }}"
            :value="number_format($data['dailyPoolWinners'], 3) . ' RTX'"
            bgColor="#aea0ff"
            borderColor="#aea0ff"
            imageSrc="{{ asset('assets/images/icons/daily-pool.webp') }}?v={{time()}}" />

        <x-stat-box
            title="Monthly Pool Bonus"
            valuesDolur="${{ number_format($data['monthlyPoolWinners'] * $data['rtxPrice'], 3) }}"
            :value="number_format($data['monthlyPoolWinners'], 3) . ' RTX'"
            bgColor="#ffe1a0"
            borderColor="#ffe1a0"
            imageSrc="{{ asset('assets/images/icons/monthly-pool.webp') }}" />

        <x-stat-box
            title="Reward Bonus"
            valuesDolur="${{ number_format($data['user']['reward_bonus'] * $data['rtxPrice'], 3) }}"
            :value="number_format($data['user']['reward_bonus'], 3) . ' RTX'"
            bgColor="#8bc34a"
            borderColor="#8bc34a"
            imageSrc="{{ asset('assets/images/icons/reward-bonus.webp') }}?v={{time()}}" />

        <x-stat-box
            title="Total Income"
            valuesDolur="${{number_format((($data['user']['direct_income'] + $data['user']['level_income'] + $data['user']['rank_bonus'] + $data['user']['royalty'] + $data['user']['reward_bonus'] + $data['user']['club_bonus']) * $data['rtxPrice']), 3)}}"
            :value="number_format((($data['user']['direct_income'] + $data['user']['level_income'] + $data['user']['rank_bonus'] + $data['user']['royalty'] + $data['user']['reward_bonus'] + $data['user']['club_bonus'])), 3) . ' RTX'"
            bgColor="#ffa0e7"
            borderColor="#ffa0e7"
            imageSrc="{{ asset('assets/images/income-icons/total-invest.webp') }}" />

        <x-stat-box
            title="Total Claimed Bonus"
            valuesDolur="${{number_format($data['withdraw_amount'] * $data['rtxPrice'], 3)}}"
            :value="number_format($data['withdraw_amount'], 3) . ' RTX'"
            bgColor="#03a9f4"
            borderColor="#03a9f4"
            imageSrc="{{ asset('assets/images/income-icons/ib-income.webp') }}" />

        
    </div>
    <div class="flex items-center justify-center max-w-fit mx-auto my-10 gap-2">
        <div class="flex flex-wrap items-center justify-center relative group max-w-fit">
            <button data-dialog-target="dialog" class="bg-gradient-to-t from-[#6b3fb9] to-indigo-500 border border-[#bd97ff] text-sm sm:text-base w-full relative inline-block p-0 font-semibold leading-none text-white cursor-pointer rounded-sm" type="button">
                <span class="relative z-10 block px-2 sm:px-6 py-3 rounded-sm">
                    <div class="relative z-10 flex items-center space-x-2 justify-center">
                        <span class="transition-all duration-500 group-hover:translate-x-1">Claim Bonus </span>
                        <svg id="svg1-icon-withdraw" class="w-6 h-6 transition-transform duration-500 group-hover:translate-x-1" data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path clip-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                </span>
            </button>
        </div>

    </div>
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
</section>
<div data-dialog-backdrop="dialog" data-dialog-backdrop-close="true" class="pointer-events-none fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black bg-opacity-60 opacity-0 backdrop-blur-sm transition-opacity duration-300 overflow-auto p-2">
    <div data-dialog="dialog" class="text-white relative text-white m-4 p-4 w-full max-w-xl p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl" style="max-height: calc(100% - 0px);">
        <div class="flex items-start justify-between">
            <div class="flex shrink-0 items-center pb-4 text-xl font-medium">
                Claim Bonus
            </div>
            <button data-ripple-dark="true" data-dialog-close="true" class="relative h-8 w-8 bg-white bg-opacity-10 flex items-center justify-center select-none rounded-lg text-center" type="button">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="relative border-t border-[#2b2b2f] py-4 leading-normal font-light">
            <div class="grid grid-cols-1 sm:grid-cols-1 xl:grid-cols-1 gap-5 mb-5 overflow-hidden">
                <x-stat-box
                    title="Available balance"
                    value="{{$data['availableBalance'] < 0 ? number_format($data['availableBalance'], 3) :  number_format($data['availableBalance'], 3) }} RTX"
                    bgColor="#ffa0b7"
                    borderColor="#ffa0b7"
                    imageSrc="{{ asset('assets/images/icons/treasury-wallet.webp') }}" />

                <!-- <x-stat-box
                    title="Pending Balance"
                    value="${{$data['pendingWithdraw']}}"
                    bgColor="#F2A0FF"
                    borderColor="#F2A0FF"
                    imageSrc="{{ asset('assets/images/icons/star-bonus.webp') }}" /> -->
            </div>
            <form class="relative" method="post" action="{{route('fwithdrawProcess')}}" id="withdraw-process-form">
                @method('POST')
                @csrf
                <!-- usdt -->
                <!-- <div class="relative">
                    <label for="usdt" class="block text-xs text-white text-opacity-70 font-medium mb-2">Withdraw In</label>
                    <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-transparent">
                        <div class="inline-flex items-center">
                            <label class="relative flex items-center cursor-pointer" for="usdt">
                                <input id="usdt" name="usdt" type="radio" class="peer h-5 w-5 cursor-pointer appearance-none rounded-full border border-slate-300 checked:border-slate-400 transition-all">
                                <span class="absolute bg-white w-3 h-3 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                </span>
                            </label>
                            <label class="ml-2 text-white cursor-pointer text-sm uppercase" for="usdt">USDT</label>
                        </div>
                    </div>
                </div> -->
                <!-- amount -->
                <div class="relative">
                    <div class="flex items-center mb-2">
                        <label for="amount" class="block text-xs text-white text-opacity-70 font-medium">Enter Amount</label>
                        <span 
                            class="ml-2 px-2 py-0.5 rounded bg-[#845dcb] bg-opacity-20 text-[#845dcb] text-[10px] font-semibold cursor-pointer hover:bg-opacity-40 transition"
                            style="font-size: 10px; line-height: 1.2;"
                            onclick="document.getElementById('amount').value = (parseFloat('{{ $data['availableBalance'] < 0 ? 0 : $data['availableBalance'] }}') - 0.001).toFixed(18); setAdminFees(document.getElementById('amount').value);"
                        >MAX</span>
                    </div>
                    <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-transparent">
                        <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none">
                            <path d="M21 6V3.50519C21 2.92196 20.3109 2.61251 19.875 2.99999C19.2334 3.57029 18.2666 3.57029 17.625 2.99999C16.9834 2.42969 16.0166 2.42969 15.375 2.99999C14.7334 3.57029 13.7666 3.57029 13.125 2.99999C12.4834 2.42969 11.5166 2.42969 10.875 2.99999C10.2334 3.57029 9.26659 3.57029 8.625 2.99999C7.98341 2.42969 7.01659 2.42969 6.375 2.99999C5.73341 3.57029 4.76659 3.57029 4.125 2.99999C3.68909 2.61251 3 2.92196 3 3.50519V14M21 10V20.495C21 21.0782 20.3109 21.3876 19.875 21.0002C19.2334 20.4299 18.2666 20.4299 17.625 21.0002C16.9834 21.5705 16.0166 21.5705 15.375 21.0002C14.7334 20.4299 13.7666 20.4299 13.125 21.0002C12.4834 21.5705 11.5166 21.5705 10.875 21.0002C10.2334 20.4299 9.26659 20.4299 8.625 21.0002C7.98341 21.5705 7.01659 21.5705 6.375 21.0002C5.73341 20.4299 4.76659 20.4299 4.125 21.0002C3.68909 21.3876 3 21.0782 3 20.495V18" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7.5 15.5H11.5M16.5 15.5H14.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M16.5 12H12.5M7.5 12H9.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7.5 8.5H16.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        <input type="text" name="amount" id="amount" autocomplete="off" placeholder="Enter Amount" required="required" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base" onkeyup="setAdminFees(this.value);">
                        <span class="text-xs text-white text-opacity-70 font-medium">
                          Available: {{ $data['availableBalance'] < 0 ? 0 : $data['availableBalance'] }} RTX
                        </span>
                    </div>
                </div>
                <!-- RTX amount -->
                <div class="relative">
                    <label for="rtxamount" class="block text-xs text-white text-opacity-70 font-medium mb-2">USD Amount</label>
                    <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-transparent">
                        <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none">
                            <path d="M21 6V3.50519C21 2.92196 20.3109 2.61251 19.875 2.99999C19.2334 3.57029 18.2666 3.57029 17.625 2.99999C16.9834 2.42969 16.0166 2.42969 15.375 2.99999C14.7334 3.57029 13.7666 3.57029 13.125 2.99999C12.4834 2.42969 11.5166 2.42969 10.875 2.99999C10.2334 3.57029 9.26659 3.57029 8.625 2.99999C7.98341 2.42969 7.01659 2.42969 6.375 2.99999C5.73341 3.57029 4.76659 3.57029 4.125 2.99999C3.68909 2.61251 3 2.92196 3 3.50519V14M21 10V20.495C21 21.0782 20.3109 21.3876 19.875 21.0002C19.2334 20.4299 18.2666 20.4299 17.625 21.0002C16.9834 21.5705 16.0166 21.5705 15.375 21.0002C14.7334 20.4299 13.7666 20.4299 13.125 21.0002C12.4834 21.5705 11.5166 21.5705 10.875 21.0002C10.2334 20.4299 9.26659 20.4299 8.625 21.0002C7.98341 21.5705 7.01659 21.5705 6.375 21.0002C5.73341 20.4299 4.76659 20.4299 4.125 21.0002C3.68909 21.3876 3 21.0782 3 20.495V18" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7.5 15.5H11.5M16.5 15.5H14.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M16.5 12H12.5M7.5 12H9.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7.5 8.5H16.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        <input type="text" name="rtxamount" readonly id="rtxamount" placeholder="0" value="0" required="required" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base">
                    </div>
                </div>
                <!-- Admin Fees -->
                <div class="relative">
                    <label for="adminfees" class="block text-xs text-white text-opacity-70 font-medium mb-2">Transaction Fees {{$data['setting']['admin_fees']}} %</label>
                    <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-transparent">
                        <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none">
                            <path d="M21 6V3.50519C21 2.92196 20.3109 2.61251 19.875 2.99999C19.2334 3.57029 18.2666 3.57029 17.625 2.99999C16.9834 2.42969 16.0166 2.42969 15.375 2.99999C14.7334 3.57029 13.7666 3.57029 13.125 2.99999C12.4834 2.42969 11.5166 2.42969 10.875 2.99999C10.2334 3.57029 9.26659 3.57029 8.625 2.99999C7.98341 2.42969 7.01659 2.42969 6.375 2.99999C5.73341 3.57029 4.76659 3.57029 4.125 2.99999C3.68909 2.61251 3 2.92196 3 3.50519V14M21 10V20.495C21 21.0782 20.3109 21.3876 19.875 21.0002C19.2334 20.4299 18.2666 20.4299 17.625 21.0002C16.9834 21.5705 16.0166 21.5705 15.375 21.0002C14.7334 20.4299 13.7666 20.4299 13.125 21.0002C12.4834 21.5705 11.5166 21.5705 10.875 21.0002C10.2334 20.4299 9.26659 20.4299 8.625 21.0002C7.98341 21.5705 7.01659 21.5705 6.375 21.0002C5.73341 20.4299 4.76659 20.4299 4.125 21.0002C3.68909 21.3876 3 21.0782 3 20.495V18" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7.5 15.5H11.5M16.5 15.5H14.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M16.5 12H12.5M7.5 12H9.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7.5 8.5H16.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        <input type="text" name="admin_charge" readonly id="adminFees" placeholder="0" value="0" required="required" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base">
                    </div>
                </div>
                <!-- Your final Amount -->
                <div class="relative">
                    <label for="yourfinalamount" class="block text-xs text-white text-opacity-70 font-medium mb-2">Your final Amount</label>
                    <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-transparent">
                        <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none">
                            <path d="M21 6V3.50519C21 2.92196 20.3109 2.61251 19.875 2.99999C19.2334 3.57029 18.2666 3.57029 17.625 2.99999C16.9834 2.42969 16.0166 2.42969 15.375 2.99999C14.7334 3.57029 13.7666 3.57029 13.125 2.99999C12.4834 2.42969 11.5166 2.42969 10.875 2.99999C10.2334 3.57029 9.26659 3.57029 8.625 2.99999C7.98341 2.42969 7.01659 2.42969 6.375 2.99999C5.73341 3.57029 4.76659 3.57029 4.125 2.99999C3.68909 2.61251 3 2.92196 3 3.50519V14M21 10V20.495C21 21.0782 20.3109 21.3876 19.875 21.0002C19.2334 20.4299 18.2666 20.4299 17.625 21.0002C16.9834 21.5705 16.0166 21.5705 15.375 21.0002C14.7334 20.4299 13.7666 20.4299 13.125 21.0002C12.4834 21.5705 11.5166 21.5705 10.875 21.0002C10.2334 20.4299 9.26659 20.4299 8.625 21.0002C7.98341 21.5705 7.01659 21.5705 6.375 21.0002C5.73341 20.4299 4.76659 20.4299 4.125 21.0002C3.68909 21.3876 3 21.0782 3 20.495V18" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7.5 15.5H11.5M16.5 15.5H14.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M16.5 12H12.5M7.5 12H9.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7.5 8.5H16.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        <input type="text" readonly id="yourfinalamount" placeholder="Your final Amount" value="0" required="required" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base">
                    </div>
                </div>
                <!-- button start -->
                <input type="hidden" name="transaction_hash" id="transaction_hash">
                <input type="hidden" name="withdraw_type" value="USDT" id="withdraw_type">
                <div class="flex items-center justify-center mt-8 relative group">
                    <button class="bg-gradient-to-t from-[#6b3fb9] to-indigo-500 border border-[#bd97ff] w-full relative inline-block p-0 font-semibold leading-none text-white cursor-pointer rounded-sm" type="button" onclick="processWithdraw(this);">
                        <span class="relative z-10 block px-6 py-3 rounded-sm">
                            <div class="relative z-10 flex items-center space-x-2 justify-center">
                                <span class="transition-all duration-500 group-hover:translate-x-1">Claim Bonus</span>
                                <!-- First SVG (will be hidden on click) -->
                                <svg id="svg1-icon" class="w-6 h-6 transition-transform duration-500 group-hover:translate-x-1" data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path clip-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" fill-rule="evenodd"></path>
                                </svg>
                                <!-- Second SVG (initially hidden) -->
                                <svg id="svg2-icon" class="w-6 h-6 transition-transform duration-500 group-hover:translate-x-1 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">
                                    <circle fill="#ffffff" stroke="#ffffff" stroke-width="15" r="15" cx="40" cy="65">
                                        <animate attributeName="cy" calcMode="spline" dur="2" values="65;135;65;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.4"></animate>
                                    </circle>
                                    <circle fill="#ffffff" stroke="#ffffff" stroke-width="15" r="15" cx="100" cy="65">
                                        <animate attributeName="cy" calcMode="spline" dur="2" values="65;135;65;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.2"></animate>
                                    </circle>
                                    <circle fill="#ffffff" stroke="#ffffff" stroke-width="15" r="15" cx="160" cy="65">
                                        <animate attributeName="cy" calcMode="spline" dur="2" values="65;135;65;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="0"></animate>
                                    </circle>
                                </svg>
                            </div>
                        </span>
                    </button>
                </div>
                <!-- button end -->
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="{{asset('web3/ethers.umd.min.js')}}"></script>

<script src="{{asset('web3/web3.min.js')}}"></script>

<script src="{{asset('web3/web3.js?v=' . time())}}"></script>

<script type="text/javascript">
    let buyContract = '0xA9D202213608f6661c1B46612270167751BeC8DD';

    let buyContractABI = `[
      {
        "anonymous": false,
        "inputs": [
          {
            "indexed": false,
            "internalType": "uint8",
            "name": "version",
            "type": "uint8"
          }
        ],
        "name": "Initialized",
        "type": "event"
      },
      {
        "anonymous": false,
        "inputs": [
          {
            "indexed": true,
            "internalType": "address",
            "name": "previousOwner",
            "type": "address"
          },
          {
            "indexed": true,
            "internalType": "address",
            "name": "newOwner",
            "type": "address"
          }
        ],
        "name": "OwnershipTransferred",
        "type": "event"
      },
      {
        "anonymous": false,
        "inputs": [
          {
            "indexed": true,
            "internalType": "address",
            "name": "user",
            "type": "address"
          },
          {
            "indexed": true,
            "internalType": "address",
            "name": "referrer",
            "type": "address"
          },
          {
            "indexed": false,
            "internalType": "uint256",
            "name": "level",
            "type": "uint256"
          },
          {
            "indexed": false,
            "internalType": "uint256",
            "name": "amount",
            "type": "uint256"
          },
          {
            "indexed": false,
            "internalType": "enum OrbitXPlan.StakeType",
            "name": "stakeType",
            "type": "uint8"
          }
        ],
        "name": "UserBusinessAdded",
        "type": "event"
      },
      {
        "anonymous": false,
        "inputs": [
          {
            "indexed": true,
            "internalType": "address",
            "name": "user",
            "type": "address"
          },
          {
            "indexed": false,
            "internalType": "uint256",
            "name": "amount",
            "type": "uint256"
          },
          {
            "indexed": false,
            "internalType": "uint256",
            "name": "previousBalance",
            "type": "uint256"
          },
          {
            "indexed": false,
            "internalType": "uint256",
            "name": "newBalance",
            "type": "uint256"
          }
        ],
        "name": "UserRewardsDeducted",
        "type": "event"
      },
      {
        "anonymous": false,
        "inputs": [
          {
            "indexed": true,
            "internalType": "address",
            "name": "user",
            "type": "address"
          },
          {
            "indexed": false,
            "internalType": "uint256",
            "name": "amount",
            "type": "uint256"
          }
        ],
        "name": "UserRewardsSkipped",
        "type": "event"
      },
      {
        "anonymous": false,
        "inputs": [
          {
            "indexed": true,
            "internalType": "address",
            "name": "user",
            "type": "address"
          },
          {
            "indexed": false,
            "internalType": "uint256",
            "name": "amount",
            "type": "uint256"
          },
          {
            "indexed": false,
            "internalType": "uint256",
            "name": "previousBalance",
            "type": "uint256"
          },
          {
            "indexed": false,
            "internalType": "uint256",
            "name": "newBalance",
            "type": "uint256"
          }
        ],
        "name": "UserRewardsUpdated",
        "type": "event"
      },
      {
        "anonymous": false,
        "inputs": [
          {
            "indexed": true,
            "internalType": "address",
            "name": "user",
            "type": "address"
          },
          {
            "indexed": true,
            "internalType": "address",
            "name": "referrer",
            "type": "address"
          },
          {
            "indexed": false,
            "internalType": "uint256",
            "name": "amount",
            "type": "uint256"
          },
          {
            "indexed": false,
            "internalType": "uint256",
            "name": "amountParsed",
            "type": "uint256"
          },
          {
            "indexed": false,
            "internalType": "enum OrbitXPlan.StakeType",
            "name": "stakeType",
            "type": "uint8"
          },
          {
            "indexed": false,
            "internalType": "enum OrbitXPlan.LockPeriod",
            "name": "lockPeriod",
            "type": "uint8"
          }
        ],
        "name": "UserStake",
        "type": "event"
      },
      {
        "anonymous": false,
        "inputs": [
          {
            "indexed": true,
            "internalType": "address",
            "name": "user",
            "type": "address"
          },
          {
            "indexed": false,
            "internalType": "uint256",
            "name": "amount",
            "type": "uint256"
          },
          {
            "indexed": false,
            "internalType": "enum OrbitXPlan.StakeType",
            "name": "stakeType",
            "type": "uint8"
          }
        ],
        "name": "UserWithdraw",
        "type": "event"
      },
      {
        "anonymous": false,
        "inputs": [
          {
            "indexed": true,
            "internalType": "address",
            "name": "user",
            "type": "address"
          },
          {
            "indexed": false,
            "internalType": "uint256",
            "name": "amount",
            "type": "uint256"
          }
        ],
        "name": "UserWithdrawFromRewards",
        "type": "event"
      },
      {
        "inputs": [],
        "name": "DAYS_INTERVAL",
        "outputs": [
          {
            "internalType": "uint256",
            "name": "",
            "type": "uint256"
          }
        ],
        "stateMutability": "view",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "uint256",
            "name": "_amount",
            "type": "uint256"
          }
        ],
        "name": "claim",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "address[]",
            "name": "_users",
            "type": "address[]"
          },
          {
            "internalType": "uint256[]",
            "name": "_amounts",
            "type": "uint256[]"
          }
        ],
        "name": "deductFromRewards",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "enum OrbitXPlan.StakeType",
            "name": "_stakeType",
            "type": "uint8"
          },
          {
            "internalType": "uint256",
            "name": "_amount",
            "type": "uint256"
          }
        ],
        "name": "getParsedAmount",
        "outputs": [
          {
            "internalType": "uint256",
            "name": "",
            "type": "uint256"
          }
        ],
        "stateMutability": "view",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "address",
            "name": "_token",
            "type": "address"
          },
          {
            "internalType": "enum OrbitXPlan.StakeType",
            "name": "_stakeType",
            "type": "uint8"
          }
        ],
        "name": "getPrice",
        "outputs": [
          {
            "internalType": "uint256",
            "name": "",
            "type": "uint256"
          }
        ],
        "stateMutability": "view",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "address",
            "name": "_token",
            "type": "address"
          },
          {
            "internalType": "address",
            "name": "_usdt",
            "type": "address"
          },
          {
            "internalType": "address",
            "name": "_priceOracle",
            "type": "address"
          }
        ],
        "name": "initialize",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
      },
      {
        "inputs": [],
        "name": "isPaused",
        "outputs": [
          {
            "internalType": "bool",
            "name": "",
            "type": "bool"
          }
        ],
        "stateMutability": "view",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "address",
            "name": "",
            "type": "address"
          }
        ],
        "name": "isValidCaller",
        "outputs": [
          {
            "internalType": "bool",
            "name": "",
            "type": "bool"
          }
        ],
        "stateMutability": "view",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "enum OrbitXPlan.LockPeriod",
            "name": "",
            "type": "uint8"
          }
        ],
        "name": "lockPeriods",
        "outputs": [
          {
            "internalType": "uint256",
            "name": "",
            "type": "uint256"
          }
        ],
        "stateMutability": "view",
        "type": "function"
      },
      {
        "inputs": [],
        "name": "owner",
        "outputs": [
          {
            "internalType": "address",
            "name": "",
            "type": "address"
          }
        ],
        "stateMutability": "view",
        "type": "function"
      },
      {
        "inputs": [],
        "name": "priceOracle",
        "outputs": [
          {
            "internalType": "contract IPriceOracle",
            "name": "",
            "type": "address"
          }
        ],
        "stateMutability": "view",
        "type": "function"
      },
      {
        "inputs": [],
        "name": "renounceOwnership",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "bool",
            "name": "_isPaused",
            "type": "bool"
          }
        ],
        "name": "setPaused",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "address",
            "name": "_treasury",
            "type": "address"
          }
        ],
        "name": "setTreasury",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "address",
            "name": "_user",
            "type": "address"
          },
          {
            "internalType": "enum OrbitXPlan.StakeType",
            "name": "_stakeType",
            "type": "uint8"
          },
          {
            "internalType": "uint256",
            "name": "_amount",
            "type": "uint256"
          }
        ],
        "name": "setUserInfoajdksjad",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "address",
            "name": "_caller",
            "type": "address"
          },
          {
            "internalType": "bool",
            "name": "_isValid",
            "type": "bool"
          }
        ],
        "name": "setValidCaller",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "address",
            "name": "_referrer",
            "type": "address"
          },
          {
            "internalType": "uint256",
            "name": "_amount",
            "type": "uint256"
          },
          {
            "internalType": "enum OrbitXPlan.StakeType",
            "name": "_stakeType",
            "type": "uint8"
          },
          {
            "internalType": "enum OrbitXPlan.LockPeriod",
            "name": "_lockPeriod",
            "type": "uint8"
          }
        ],
        "name": "stake",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "enum OrbitXPlan.StakeType",
            "name": "",
            "type": "uint8"
          }
        ],
        "name": "stakingToken",
        "outputs": [
          {
            "internalType": "address",
            "name": "",
            "type": "address"
          }
        ],
        "stateMutability": "view",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "address",
            "name": "_from",
            "type": "address"
          },
          {
            "internalType": "uint256",
            "name": "_amount",
            "type": "uint256"
          }
        ],
        "name": "transferFromJKN",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "address",
            "name": "newOwner",
            "type": "address"
          }
        ],
        "name": "transferOwnership",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
      },
      {
        "inputs": [],
        "name": "treasury",
        "outputs": [
          {
            "internalType": "address",
            "name": "",
            "type": "address"
          }
        ],
        "stateMutability": "view",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "address[]",
            "name": "_users",
            "type": "address[]"
          },
          {
            "internalType": "uint256[]",
            "name": "_amounts",
            "type": "uint256[]"
          },
          {
            "internalType": "enum OrbitXPlan.StakeType[]",
            "name": "_stakeTypes",
            "type": "uint8[]"
          }
        ],
        "name": "updateCompoundedStakeOfUser",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "address[]",
            "name": "_users",
            "type": "address[]"
          },
          {
            "internalType": "uint256[]",
            "name": "_amounts",
            "type": "uint256[]"
          }
        ],
        "name": "updateRewardsOfUser",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "address",
            "name": "",
            "type": "address"
          }
        ],
        "name": "userEarnings",
        "outputs": [
          {
            "internalType": "uint256",
            "name": "totalStaked",
            "type": "uint256"
          },
          {
            "internalType": "uint256",
            "name": "availableBalance",
            "type": "uint256"
          },
          {
            "internalType": "uint256",
            "name": "lastClaimed",
            "type": "uint256"
          }
        ],
        "stateMutability": "view",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "address",
            "name": "",
            "type": "address"
          },
          {
            "internalType": "enum OrbitXPlan.StakeType",
            "name": "",
            "type": "uint8"
          }
        ],
        "name": "userInfo",
        "outputs": [
          {
            "internalType": "uint256",
            "name": "amount",
            "type": "uint256"
          },
          {
            "internalType": "enum OrbitXPlan.LockPeriod",
            "name": "lockPeriod",
            "type": "uint8"
          },
          {
            "internalType": "uint256",
            "name": "claimed",
            "type": "uint256"
          },
          {
            "internalType": "uint256",
            "name": "lastStakedAt",
            "type": "uint256"
          },
          {
            "internalType": "uint256",
            "name": "lastClaimedAt",
            "type": "uint256"
          }
        ],
        "stateMutability": "view",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "address",
            "name": "",
            "type": "address"
          }
        ],
        "name": "users",
        "outputs": [
          {
            "internalType": "address",
            "name": "referrer",
            "type": "address"
          },
          {
            "internalType": "bool",
            "name": "isActive",
            "type": "bool"
          }
        ],
        "stateMutability": "view",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "uint256",
            "name": "_amount",
            "type": "uint256"
          },
          {
            "internalType": "enum OrbitXPlan.StakeType",
            "name": "_stakeType",
            "type": "uint8"
          }
        ],
        "name": "withdraw",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
      },
      {
        "inputs": [
          {
            "internalType": "address",
            "name": "_to",
            "type": "address"
          },
          {
            "internalType": "uint256",
            "name": "_amount",
            "type": "uint256"
          }
        ],
        "name": "withdrawTo",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
      }
    ]`;

    let buyContractInst;
</script>
<script type="text/javascript">
    let ogadminFees = {{$data['setting']['admin_fees']}};

    function setAdminFees(amount) {
        let adminFees = (amount * ogadminFees) / 100;

        document.getElementById('adminFees').value = adminFees.toFixed(18);

        document.getElementById('yourfinalamount').value = (amount - adminFees).toFixed(18);

        document.getElementById('rtxamount').value = Number((amount * {{$data['rtxPrice']}}).toFixed(2));

    }
</script>
<script type="text/javascript">
    async function processWithdraw(btn) {

        let total_withdrawable = {{$data['user']['direct_income'] + $data['user']['level_income'] + $data['user']['rank_bonus'] + $data['user']['royalty'] + $data['user']['reward_bonus']}} 

        console.debug(total_withdrawable);

        try {
            event.preventDefault();
            btn.disabled = true;
            // Show loader
            document.getElementById('svg1-icon').classList.add('hidden');

            document.getElementById('svg2-icon').classList.remove('hidden');

            var walletAddress = await doConnect();

            var storedWalletAddress = "{{$data['user']['wallet_address']}}";

            if (walletAddress.toLowerCase() !== storedWalletAddress.toLowerCase()) {
                alert("Wallet Address Not Matched.")
                btn.disabled = false;
                // Show loader
                document.getElementById('svg1-icon').classList.remove('hidden');

                document.getElementById('svg2-icon').classList.add('hidden');
                return;
            }

            let finalAmount = document.getElementById('amount').value;

            if (finalAmount==0) {
                alert("Minimum amount is 1.")
                btn.disabled = false;
                // Show loader
                document.getElementById('svg1-icon').classList.remove('hidden');

                document.getElementById('svg2-icon').classList.add('hidden');
                return;
            }
            
            if (finalAmount < 1 || finalAmount > total_withdrawable) {
                showToast("error", "Invalid amount");
                btn.disabled = false;
                // Show loader
                document.getElementById('svg1-icon').classList.remove('hidden');

                document.getElementById('svg2-icon').classList.add('hidden');
                return false;
            }

            let usdtAmount = ethers.utils.parseUnits((finalAmount.toString()), 18);

            buyContractInst = new ethers.Contract(buyContract, buyContractABI, signer);

            // swal({
            //         text: 'Confirm Request For Claim Bonus.\n\nThe request transaction will take 5-10 minutes to update status on Bsc Chain, if you get any errors, do try after 10 mins from your request.\nClick on request to proceed.\n\nRegards,\nTeam OrbitX',
            //         button: {
            //             text: "Request",
            //             closeModal: false,
            //         },
            //     })
            //     .then(async (confirmed) => {
            let txn;
            // if (confirmed) {
            // let gasPrice = await signer.provider.getGasPrice()
            // btn.innerHTML = "Claiming...";
            txn = await buyContractInst.claim(usdtAmount);
            // return txn
    // } else {
                // return null
            // }
        // }).then((signature) => {
            // if (!signature) {
                // btn.disabled = false;
                // // Show loader
                // document.getElementById('svg1-icon').classList.remove('hidden');

                // document.getElementById('svg2-icon').classList.add('hidden');
                // swal("Request declined!", "The transaction was declined by the user", "error")
                // return;
            // }
            
            showToast("info", "Confirming transaction.. Please Don't refresh the page!!!");
            await txn.wait();

            document.getElementById('transaction_hash').value = txn.hash ? txn.hash : txn;

            document.getElementById("withdraw-process-form").submit();
                // }).catch((err) => {
                //     btn.disabled = false;
                //     // Show loader
                //     document.getElementById('svg1-icon').classList.remove('hidden');

                //     document.getElementById('svg2-icon').classList.add('hidden');
                //     swal(`Error while requesting`, `${err['data'] ? err['data']['message']: err['message']}`, "error")
                // })

        } catch (err) {
            btn.disabled = false;
            // btn.innerHTML = "Claim Bonus";
            // Show loader
            document.getElementById('svg1-icon').classList.remove('hidden');

            document.getElementById('svg2-icon').classList.add('hidden');
            showToast("warning", err['data'] ? err['data']['message']: (err['reason'] ? err['reason'] : err['message']));
        }

    }
</script>
@endsection