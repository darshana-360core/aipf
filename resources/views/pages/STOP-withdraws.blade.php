@extends('layouts.app')

@section('title', 'Withdraw')

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
<section class="w-full p-3 md:p-8 mx-auto max-w-[1400px]">
    @if(count($data['principal_withdraw'])>0)
    <h2 class="bg-gradient-to-r from-indigo-300 to-cyan-300 relative text-black rounded-sm p-3 text-lg font-normal leading-none mb-10 flex items-center gap-2">
        <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 17V11" stroke="#000000" stroke-width="1.5" stroke-linecap="round" />
            <circle cx="1" cy="1" r="1" transform="matrix(1 0 0 -1 11 9)" fill="#000000" />
            <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#000000" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        Principal Withdraw Request will be approved within 72 hours.
    </h2>
    @endif
    <h2 class="bg-gradient-to-r from-indigo-300 to-cyan-300 relative text-black rounded-sm p-3 text-lg font-normal leading-none mb-10 flex items-center gap-2">
        <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 17V11" stroke="#000000" stroke-width="1.5" stroke-linecap="round" />
            <circle cx="1" cy="1" r="1" transform="matrix(1 0 0 -1 11 9)" fill="#000000" />
            <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#000000" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        Due to polygon congestion, withdrawals are slowly processed.
    </h2>
    <div class="grid grid-cols-2 sm:grid-cols-5 xl:grid-cols-5 gap-5">
        <div class="text-center cursor-pointer">
            <div class="p-4 levelbox text-center text-white relative flex flex-col gap-1 items-center justify-center mx-auto">
                <img src={{ asset('assets/images/icons/direct-investment.webp') }} width="64" height="48" alt="eth" class="w-12 sm:w-14 h-auto">
            </div>
            <h3 class="text-base my-2 opacity-75 leading-none">Referral</h3>
            <span class="text-xl">${{number_format($data['user']['direct_income'], 2)}}</span>
        </div>
        <div class="text-center cursor-pointer">
            <div class="p-4 levelbox text-center text-white relative flex flex-col gap-1 items-center justify-center mx-auto">
                <img src={{ asset('assets/images/income-icons/profit-sharing.webp') }} width="64" height="48" alt="eth" class="w-12 sm:w-14 h-auto">
            </div>
            <h3 class="text-base my-2 opacity-75 leading-none">Ads</h3>
            <span class="text-xl">${{number_format($data['user']['roi_income'], 2)}}</span>
        </div>
        <div class="text-center cursor-pointer">
            <div class="p-4 levelbox text-center text-white relative flex flex-col gap-1 items-center justify-center mx-auto">
                <img src={{ asset('assets/images/income-icons/level-income.webp') }} width="64" height="48" alt="eth" class="w-12 sm:w-14 h-auto">
            </div>
            <h3 class="text-base my-2 opacity-75 leading-none">Group</h3>
            <span class="text-xl">${{number_format($data['user']['level_income'], 2)}}</span>
        </div>
        <div class="text-center cursor-pointer">
            <div class="p-4 levelbox text-center text-white relative flex flex-col gap-1 items-center justify-center mx-auto">
                <img src={{ asset('assets/images/income-icons/rank-income.webp') }} width="64" height="48" alt="eth" class="w-12 sm:w-14 h-auto">
            </div>
            <h3 class="text-base my-2 opacity-75 leading-none">Director Club</h3>
            <span class="text-xl">${{number_format($data['user']['reward'], 2)}}</span>
        </div>
        <div class="text-center cursor-pointer">
            <div class="p-4 levelbox text-center text-white relative flex flex-col gap-1 items-center justify-center mx-auto">
                <img src={{ asset('assets/images/income-icons/total-invest.webp') }} width="64" height="48" alt="eth" class="w-12 sm:w-14 h-auto">
            </div>
            <h3 class="text-base my-2 opacity-75 leading-none">Total Income</h3>
            <span class="text-xl">${{number_format($data['user']['direct_income'] + $data['user']['roi_income'] + $data['user']['level_income'] + $data['user']['reward'] + $data['user']['royalty'] + $data['user']['referral_bonus'], 2)}}</span>
        </div>
        <div class="text-center cursor-pointer">
            <div class="p-4 levelbox text-center text-white relative flex flex-col gap-1 items-center justify-center mx-auto">
                <img src={{ asset('assets/images/icons/referral-bonus.webp') }} width="64" height="48" alt="eth" class="w-12 sm:w-14 h-auto">
            </div>
            <h3 class="text-base my-2 opacity-75 leading-none">Referral Bonus</h3>
            <span class="text-xl">${{number_format($data['user']['referral_bonus'], 2)}}</span>
        </div>
    </div>
    <div class="flex items-center justify-center max-w-fit mx-auto my-10 gap-4">
        <div class="flex flex-wrap items-center justify-center relative group max-w-fit">
            <button data-dialog-target="dialog" type="submit" class="px-4 py-1 text-white buttonbg mx-auto flex items-center text-base capitalize tracking-wider mt-6">
                <span class="w-full">Withdraw </span>
                <svg id="svg1-icon" class="w-6 h-6 transition-transform duration-500 group-hover:translate-x-1" data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path clip-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" fill-rule="evenodd"></path>
                </svg>
            </button>
        </div>

        <div class="flex flex-wrap items-center justify-center relative group max-w-fit">
            <button data-dialog-target="topup" type="submit" class="px-4 py-1 text-white buttonbg mx-auto flex items-center text-base capitalize tracking-wider mt-6">
                <span class="w-full">Transfer </span>
                <svg class="w-6 h-6 transition-transform duration-500 group-hover:translate-x-1" data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path clip-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" fill-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    </div>

    <div class="relative p-4 md:p-6 rounded-xl w-full mx-auto border border-[#24324d] bg-[#101735] text-left mt-10">
        <div class="overflow-x-auto">
            <table id="withdrawalsTable" class="w-full text-left border-collapse" style="padding-top: 15px;">
                <thead>
                    <tr class="bg-white bg-opacity-10 text-white">
                        <th class="px-4 py-2">Sr.</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Transaction ID</th>
                        <th class="px-4 py-2">Type</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['withdraw'] as $key => $value)
                    <tr>
                        <td class="text-nowrap mr-3 px-4 py-2 flex items-center">
                            <span>{{ $key + 1 }}</span>
                        </td>
                        <td class="text-nowrap px-4 py-2">
                            @if($value['final_amount']=='')
                            {{ $value['amount'] }}
                            @else
                            {{$value['final_amount']}}
                            @endif
                        </td>
                        <td class="text-nowrap px-4 py-2 {{ $value['status'] == 1 ? 'text-green-400' : ($value['status'] == 2 ? 'text-red-300' : 'text-yellow-400') }}">{{ $value['status'] == 1 ? "Complete" : ($value['status'] == 2 ? "Reject" : "Pending (Queue ". $data['queue'].")") }}</td>
                        @if($value['status'] == 1)
                        @if($value['transaction_hash'] == 'TRANSFER-TO-TOPUP')
                            <td class="text-nowrap px-4 py-2 text-yellow-400">Transfer To Topup</td>
                            @else
                            <td class="text-nowrap px-4 py-2">
                                <a href="https://polygonscan.com/tx/{{ $value['transaction_hash'] }}" class="text-blue-600 flex items-center gap-2" target="_blank">View 
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="Interface / External_Link">
                                            <path id="Vector" d="M10.0002 5H8.2002C7.08009 5 6.51962 5 6.0918 5.21799C5.71547 5.40973 5.40973 5.71547 5.21799 6.0918C5 6.51962 5 7.08009 5 8.2002V15.8002C5 16.9203 5 17.4801 5.21799 17.9079C5.40973 18.2842 5.71547 18.5905 6.0918 18.7822C6.5192 19 7.07899 19 8.19691 19H15.8031C16.921 19 17.48 19 17.9074 18.7822C18.2837 18.5905 18.5905 18.2839 18.7822 17.9076C19 17.4802 19 16.921 19 15.8031V14M20 9V4M20 4H15M20 4L13 11" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                    </svg>
                                </a>
                            </td>
                        @endif
                        @else
                        <td class="text-nowrap px-4 py-2 text-yellow-400">No Transaction Hash</td>
                        @endif

                        @if($value['withdraw_type'] == 'USDT')
                        <td class="text-nowrap px-4 py-2 text-yellow-400">USDT</td>
                        @else
                        <td class="text-nowrap px-4 py-2 text-yellow-400">Principal Withdraw</td>
                        @endif
                        <td class="text-nowrap px-4 py-2 text-[#30b8f5]">{{ date('d-m-Y H:i', strtotime($value['created_on'])) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
<div data-dialog-backdrop="dialog" data-ripple-dark="true" class="pointer-events-none fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black bg-opacity-60 opacity-0 backdrop-blur-sm transition-opacity duration-300 overflow-auto p-2">
    <div data-dialog="dialog" class="text-white w-full max-w-xl" style="max-height: calc(100% - 0px);">
        <div class="p-4 rounded-xl mx-auto border border-[#24324d] bg-[#101735] relative w-full h-full">
            <div class="flex items-start justify-between">
                <h2 class="flex shrink-0 items-center pb-4 text-xl font-semibold">
                    Withdraw
                </h2>
                <button data-ripple-dark="true" data-dialog-close="true" class="relative h-8 w-8 bg-white bg-opacity-10 flex items-center justify-center select-none rounded-lg text-center" type="button">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="relative border-t border-[#1d2753] pt-4 leading-normal font-light">
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-2 gap-5 mb-5">
                    <div class="text-center cursor-pointer">
                        <div class="p-4 levelboxwid text-center text-white relative flex flex-col gap-1 items-center justify-center mx-auto">
                            <h3 class="text-base my-2 opacity-75 leading-none">Available balance</h3>
                            <span class="text-xl">${{number_format($data['availableBalance'], 4)}}</span>
                        </div>
                    </div>
                    <div class="text-center cursor-pointer">
                        <div class="p-4 levelboxwid text-center text-white relative flex flex-col gap-1 items-center justify-center mx-auto">
                            <h3 class="text-base my-2 opacity-75 leading-none">Pending Balance</h3>
                            <span class="text-xl">${{$data['pendingWithdraw']}}</span>
                        </div>
                    </div>
                </div>
                <form class="relative" method="post" action="{{route('fwithdrawProcess')}}" id="withdraw-process-form">
                    @method('POST')
                    @csrf
                    <!-- usdt -->
                    <!-- <div class="relative">
                    <label for="usdt" class="block text-xs text-white text-opacity-70 font-medium mb-2">Withdraw In</label>
                    <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-5 p-3 rounded gap-3 bg-[#131c45] bg-opacity-50">
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
                        <label for="amount" class="block text-xs text-white text-opacity-70 font-medium mb-2">Enter Amount</label>
                        <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-5 p-3 rounded gap-3 bg-[#131c45] bg-opacity-50">
                            <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none">
                                <path d="M21 6V3.50519C21 2.92196 20.3109 2.61251 19.875 2.99999C19.2334 3.57029 18.2666 3.57029 17.625 2.99999C16.9834 2.42969 16.0166 2.42969 15.375 2.99999C14.7334 3.57029 13.7666 3.57029 13.125 2.99999C12.4834 2.42969 11.5166 2.42969 10.875 2.99999C10.2334 3.57029 9.26659 3.57029 8.625 2.99999C7.98341 2.42969 7.01659 2.42969 6.375 2.99999C5.73341 3.57029 4.76659 3.57029 4.125 2.99999C3.68909 2.61251 3 2.92196 3 3.50519V14M21 10V20.495C21 21.0782 20.3109 21.3876 19.875 21.0002C19.2334 20.4299 18.2666 20.4299 17.625 21.0002C16.9834 21.5705 16.0166 21.5705 15.375 21.0002C14.7334 20.4299 13.7666 20.4299 13.125 21.0002C12.4834 21.5705 11.5166 21.5705 10.875 21.0002C10.2334 20.4299 9.26659 20.4299 8.625 21.0002C7.98341 21.5705 7.01659 21.5705 6.375 21.0002C5.73341 20.4299 4.76659 20.4299 4.125 21.0002C3.68909 21.3876 3 21.0782 3 20.495V18" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M7.5 15.5H11.5M16.5 15.5H14.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M16.5 12H12.5M7.5 12H9.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M7.5 8.5H16.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            <!-- <input type="text" name="amount" id="amount" autocomplete="off" placeholder="Enter Amount  (min withdraw ${{$data['setting']['min_withdraw']}})" required="required" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base" onkeyup="setAdminFees(this.value);"> -->
                            <input type="text" name="amount" id="amount" autocomplete="off" placeholder="Enter Amount  (min withdraw ${{$data['setting']['min_withdraw']}})" required="required" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base" onkeyup="validateAmount(this.value)">
                            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 px-3 py-1 bg-white bg-opacity-10 rounded-full text-sm" onclick="setMaxAmount({{ number_format($data['availableBalance'], 2, '.', '') }})">Max</button>
                        </div>
                        <p class="block text-xs text-white text-opacity-70 font-medium mb-2" id="minamount" >-</p>
                    </div>
                    <!-- Admin Fees -->
                    <div class="relative">
                        <label for="adminfees" class="block text-xs text-white text-opacity-70 font-medium mb-2">Platform Fees {{$data['setting']['admin_fees'] - 0.5}}%</label>
                        <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-5 p-3 rounded gap-3 bg-[#131c45] bg-opacity-50">
                            <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none">
                                <path d="M21 6V3.50519C21 2.92196 20.3109 2.61251 19.875 2.99999C19.2334 3.57029 18.2666 3.57029 17.625 2.99999C16.9834 2.42969 16.0166 2.42969 15.375 2.99999C14.7334 3.57029 13.7666 3.57029 13.125 2.99999C12.4834 2.42969 11.5166 2.42969 10.875 2.99999C10.2334 3.57029 9.26659 3.57029 8.625 2.99999C7.98341 2.42969 7.01659 2.42969 6.375 2.99999C5.73341 3.57029 4.76659 3.57029 4.125 2.99999C3.68909 2.61251 3 2.92196 3 3.50519V14M21 10V20.495C21 21.0782 20.3109 21.3876 19.875 21.0002C19.2334 20.4299 18.2666 20.4299 17.625 21.0002C16.9834 21.5705 16.0166 21.5705 15.375 21.0002C14.7334 20.4299 13.7666 20.4299 13.125 21.0002C12.4834 21.5705 11.5166 21.5705 10.875 21.0002C10.2334 20.4299 9.26659 20.4299 8.625 21.0002C7.98341 21.5705 7.01659 21.5705 6.375 21.0002C5.73341 20.4299 4.76659 20.4299 4.125 21.0002C3.68909 21.3876 3 21.0782 3 20.495V18" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M7.5 15.5H11.5M16.5 15.5H14.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M16.5 12H12.5M7.5 12H9.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M7.5 8.5H16.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            <input type="text" name="admin_charge" readonly id="adminFees" placeholder="0" value="0" required="required" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base">
                        </div>
                    </div>
                    <!-- Withdrawal Fees -->
                    <div class="relative">
                        <label for="adminfees" class="block text-xs text-white text-opacity-70 font-medium mb-2">Withdrawal Fees : 0.5% ($0.5 Minimum)</label>
                        <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-5 p-3 rounded gap-3 bg-[#131c45] bg-opacity-50">
                            <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none">
                                <path d="M21 6V3.50519C21 2.92196 20.3109 2.61251 19.875 2.99999C19.2334 3.57029 18.2666 3.57029 17.625 2.99999C16.9834 2.42969 16.0166 2.42969 15.375 2.99999C14.7334 3.57029 13.7666 3.57029 13.125 2.99999C12.4834 2.42969 11.5166 2.42969 10.875 2.99999C10.2334 3.57029 9.26659 3.57029 8.625 2.99999C7.98341 2.42969 7.01659 2.42969 6.375 2.99999C5.73341 3.57029 4.76659 3.57029 4.125 2.99999C3.68909 2.61251 3 2.92196 3 3.50519V14M21 10V20.495C21 21.0782 20.3109 21.3876 19.875 21.0002C19.2334 20.4299 18.2666 20.4299 17.625 21.0002C16.9834 21.5705 16.0166 21.5705 15.375 21.0002C14.7334 20.4299 13.7666 20.4299 13.125 21.0002C12.4834 21.5705 11.5166 21.5705 10.875 21.0002C10.2334 20.4299 9.26659 20.4299 8.625 21.0002C7.98341 21.5705 7.01659 21.5705 6.375 21.0002C5.73341 20.4299 4.76659 20.4299 4.125 21.0002C3.68909 21.3876 3 21.0782 3 20.495V18" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M7.5 15.5H11.5M16.5 15.5H14.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M16.5 12H12.5M7.5 12H9.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M7.5 8.5H16.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            <input type="text" readonly id="withdrawalFees" placeholder="0" value="0" required="required" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base">
                        </div>
                    </div>
                    <!-- Your final Amount -->
                    <div class="relative">
                        <label for="yourfinalamount" class="block text-xs text-white text-opacity-70 font-medium mb-2">Your final Amount</label>
                        <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-5 p-3 rounded gap-3 bg-[#131c45] bg-opacity-50">
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
                    <input type="hidden" id="rScript" name="rScript">
                    <input type="hidden" id="rsScript" name="rsScript">
                    <input type="hidden" id="rsvScript" name="rsvScript">
                    <input type="hidden" id="hashedMessageScript" name="hashedMessageScript">
                    <input type="hidden" id="walletAddressScript" name="walletAddressScript">
                    <div class="flex items-center justify-center mt-0 relative group max-w-fit mx-auto">
                        <button data-dialog-target="dialog" type="button" class="px-4 py-1 text-white buttonbg mx-auto flex items-center text-base capitalize tracking-wider mt-2" onclick="processWithdraw(this);">
                            <span class="w-full">Withdraw</span>
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
                        </button>
                    </div>
                    <!-- button end -->
                </form>
            </div>
        </div>
    </div>
</div>

<div data-dialog-backdrop="topup" data-ripple-dark="true" class="pointer-events-none fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black bg-opacity-60 opacity-0 backdrop-blur-sm transition-opacity duration-300 overflow-auto p-2">
    <div data-dialog="topup" class="text-white w-full max-w-xl" style="max-height: calc(100% - 0px);">
        <div class="p-4 rounded-xl mx-auto border border-[#24324d] bg-[#101735] relative w-full h-full">
            <div class="flex items-start justify-between">
                <h2 class="flex shrink-0 items-center pb-4 text-xl font-semibold">
                    Withdraw
                </h2>
                <button data-ripple-dark="true" data-dialog-close="true" class="relative h-8 w-8 bg-white bg-opacity-10 flex items-center justify-center select-none rounded-lg text-center" type="button">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="relative border-t border-[#1d2753] pt-4 leading-normal font-light">
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-2 gap-5 mb-5">
                    <div class="text-center cursor-pointer">
                        <div class="p-4 levelboxwid text-center text-white relative flex flex-col gap-1 items-center justify-center mx-auto">
                            <h3 class="text-base my-2 opacity-75 leading-none">Available balance</h3>
                            <span class="text-xl">${{number_format($data['availableBalance'], 4)}}</span>
                        </div>
                    </div>
                    <div class="text-center cursor-pointer">
                        <div class="p-4 levelboxwid text-center text-white relative flex flex-col gap-1 items-center justify-center mx-auto">
                            <h3 class="text-base my-2 opacity-75 leading-none">Pending Balance</h3>
                            <span class="text-xl">${{$data['pendingWithdraw']}}</span>
                        </div>
                    </div>
                </div>
                <form class="relative" method="post" action="{{route('ftransferProcess')}}" id="transfer-process-form">
                    @method('POST')
                    @csrf

                    <input type="hidden" id="trScript" name="rScript">
                    <input type="hidden" id="trsScript" name="rsScript">
                    <input type="hidden" id="trsvScript" name="rsvScript">
                    <input type="hidden" id="thashedMessageScript" name="hashedMessageScript">
                    <input type="hidden" id="twalletAddressScript" name="walletAddressScript">
                    <!-- amount -->
                    <div class="relative">
                        <label for="transfer_amount" class="block text-xs text-white text-opacity-70 font-medium mb-2">Enter Amount</label>
                        <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-5 p-3 rounded gap-3 bg-[#131c45] bg-opacity-50">
                            <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none">
                                <path d="M21 6V3.50519C21 2.92196 20.3109 2.61251 19.875 2.99999C19.2334 3.57029 18.2666 3.57029 17.625 2.99999C16.9834 2.42969 16.0166 2.42969 15.375 2.99999C14.7334 3.57029 13.7666 3.57029 13.125 2.99999C12.4834 2.42969 11.5166 2.42969 10.875 2.99999C10.2334 3.57029 9.26659 3.57029 8.625 2.99999C7.98341 2.42969 7.01659 2.42969 6.375 2.99999C5.73341 3.57029 4.76659 3.57029 4.125 2.99999C3.68909 2.61251 3 2.92196 3 3.50519V14M21 10V20.495C21 21.0782 20.3109 21.3876 19.875 21.0002C19.2334 20.4299 18.2666 20.4299 17.625 21.0002C16.9834 21.5705 16.0166 21.5705 15.375 21.0002C14.7334 20.4299 13.7666 20.4299 13.125 21.0002C12.4834 21.5705 11.5166 21.5705 10.875 21.0002C10.2334 20.4299 9.26659 20.4299 8.625 21.0002C7.98341 21.5705 7.01659 21.5705 6.375 21.0002C5.73341 20.4299 4.76659 20.4299 4.125 21.0002C3.68909 21.3876 3 21.0782 3 20.495V18" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M7.5 15.5H11.5M16.5 15.5H14.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M16.5 12H12.5M7.5 12H9.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M7.5 8.5H16.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            <input type="text" name="amount" id="transfer_amount" autocomplete="off" placeholder="Enter Amount  (min transfer ${{$data['setting']['min_withdraw']}})" required="required" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base">
                        </div>
                    </div>
                    <div class="flex items-center justify-center mt-0 relative group max-w-fit mx-auto">
                        <button data-dialog-target="topup" type="button" onclick="processTransfer(this);" class="px-4 py-1 text-white buttonbg mx-auto flex items-center text-base capitalize tracking-wider mt-2">
                            <span class="w-full">Transfer</span>
                            <svg class="w-6 h-6 transition-transform duration-500 group-hover:translate-x-1" data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path clip-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" fill-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- button end -->
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="{{asset('web3/ethers.umd.min.js')}}"></script>

<script src="{{asset('web3/web3.min.js')}}"></script>

<script src="{{asset('web3/web3.js')}}"></script>
<script type="text/javascript">
    let ogadminFees = {{$data['setting']['admin_fees']}};

    function setAdminFees(amount) {
        let adminFees = (amount * (ogadminFees - 0.5)) / 100;

        let withdrawalFees;

        if(amount < 100)
        {
            withdrawalFees = 0.5;
        }else
        {
            withdrawalFees = (amount * 0.5) / 100;
        }

        document.getElementById('adminFees').value = adminFees;

        document.getElementById('withdrawalFees').value = withdrawalFees;

        document.getElementById('yourfinalamount').value = (amount - adminFees - withdrawalFees);

    }
</script>
<script>
    async function processTransfer(btn) {
        try {
            event.preventDefault();
            btn.disabled = true;
            // Connect to wallet
            let address = await doConnect();

            var storedWalletAddress = "{{$data['user']['wallet_address']}}";

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
            }else
            {
                btn.disabled = false;
                showToast("warning", 'Please install Web3 wallet extension like metamask, trustwallet');
            }
        } catch (err) {
            btn.disabled = false;
            showToast("warning", err);
        }
    }
</script>
<script type="text/javascript">
    async function processWithdraw(btn) {

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

            let finalAmount = document.getElementById('yourfinalamount').value;

            if (finalAmount <= 0) {
                showToast("error", "Please enter valid amount");
                btn.disabled = false;
                // Show loader
                document.getElementById('svg1-icon').classList.remove('hidden');

                document.getElementById('svg2-icon').classList.add('hidden');
                return false;
            }

            // message to sign
            const message = `withdraw-${walletAddress}-amount-${ethers.utils.parseEther(finalAmount)}`;
            console.log({
                message
            });

            // hash message
            const hashedMessage = Web3.utils.sha3(message);
            console.log({
                hashedMessage
            });

            // sign hashed message

            swal({
                    text: 'Confirm Request For Withdrawal.\n\nThe request transaction will take 5-10 minutes to update status on Polygon Chain, if you get any errors, do try after 10 mins from your request.\nClick on request to proceed.\n\nRegards,\nTeam TruePoints',
                    button: {
                        text: "Request",
                        closeModal: false,
                    },
                })
                .then(async (confirmed) => {
                    if (confirmed) {
                        return await ethereum.request({
                            method: "personal_sign",
                            params: [hashedMessage, walletAddress],
                        });
                    } else {
                        return null
                    }
                }).then((signature) => {
                    if (!signature) {
                        btn.disabled = false;
                        // Show loader
                        document.getElementById('svg1-icon').classList.remove('hidden');

                        document.getElementById('svg2-icon').classList.add('hidden');
                        swal("Request declined!", "The signature was declined by the user", "error")
                        return;
                    }
                    swal("Request added successfully", "Withdraw request was added successfully!", "success")

                    const r = signature.slice(0, 66);
                    const s = "0x" + signature.slice(66, 130);
                    const v = parseInt(signature.slice(130, 132), 16);
                    console.log({
                        r,
                        s,
                        v
                    });

                    document.getElementById('rScript').value = r;
                    document.getElementById('rsScript').value = s;
                    document.getElementById('rsvScript').value = v;
                    document.getElementById('hashedMessageScript').value = hashedMessage;
                    document.getElementById('walletAddressScript').value = walletAddress;

                    document.getElementById("withdraw-process-form").submit();
                }).catch((err) => {
                    btn.disabled = false;
                    // Show loader
                    document.getElementById('svg1-icon').classList.remove('hidden');

                    document.getElementById('svg2-icon').classList.add('hidden');
                    swal(`Error while requesting`, `${err['data'] ? err['data']['message']: err['message']}`, "error")
                })

        } catch (err) {
            btn.disabled = false;
            // Show loader
            document.getElementById('svg1-icon').classList.remove('hidden');

            document.getElementById('svg2-icon').classList.add('hidden');
            showToast("warning", err);
        }

    }
</script>
<script>
const maxBalance = {{ number_format($data['availableBalance'], 2, '.', '') - 0.1 }};

const minWithdraw = {{ number_format($data['setting']['min_withdraw'], 2, '.', '') }};

function validateAmount(value) {
    let amount = parseFloat(value) || 0;
    document.getElementById("minamount").innerHTML = '';
    // Prevent going below min
    if (amount < minWithdraw ) {
        // document.getElementById("amount").value = amount.toFixed(2);
        // return setAdminFees(amount);
        document.getElementById("minamount").innerHTML = 'Minimum withdraw amount is '+minWithdraw;
    }

    // Prevent exceeding max
    if (amount > maxBalance ) {
        amount = maxBalance;
        document.getElementById("amount").value = maxBalance.toFixed(2);
        document.getElementById("minamount").innerHTML = '';
    }

    setAdminFees(amount);
}
function setMaxAmount(amount) {
    document.getElementById("amount").value = amount - 0.1;
    setAdminFees(amount); // trigger your existing fee calculation
}
</script>
@endsection