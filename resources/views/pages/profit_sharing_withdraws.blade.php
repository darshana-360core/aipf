@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<section class="w-full p-3 md:p-5 mx-auto max-w-[1400px]">
    <h2 class="bg-orange-500 relative rankinginfo4 text-white rounded-sm p-3 text-lg font-normal leading-none mb-5 flex items-center gap-2">
        <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 17V11" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
            <circle cx="1" cy="1" r="1" transform="matrix(1 0 0 -1 11 9)" fill="#ffffff" />
            <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        Due to polygon congestion, withdrawals are slowly processed.
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
        <div class="boxbgsvg relative border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
            <div class="flex items-center space-x-3 w-full gap-1">
                <img src={{ asset('assets/images/income-icons/profit-sharing.webp') }} width="64" height="48" alt="Logo" class="w-12 h-auto">
                <div class="w-full">
                    <h3 class="text-base mb-1 opacity-75 leading-none flex items-start justify-between">Profit Sharing</h3>
                    <span class="text-xl font-bold">0.00</span>
                </div>
            </div>
        </div>
        <div class="boxbgsvg relative border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
            <div class="flex items-center space-x-3 w-full gap-1">
                <img src={{ asset('assets/images/income-icons/total-invest.webp') }} width="64" height="48" alt="Logo" class="w-12 h-auto">
                <div class="w-full">
                    <h3 class="text-base mb-1 opacity-75 leading-none flex items-start justify-between">Total Income</h3>
                    <span class="text-xl font-bold">21,058.00</span>
                </div>
            </div>
        </div>
        <div class="boxbgsvg relative border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
            <div class="flex items-center space-x-3 w-full gap-1">
                <img src={{ asset('assets/images/icons/total-withdraw-icon.webp') }} width="64" height="48" alt="Logo" class="w-12 h-auto">
                <div class="w-full">
                    <h3 class="text-base mb-1 opacity-75 leading-none flex items-start justify-between">Total Withdraw</h3>
                    <span class="text-xl font-bold">98,058.00</span>
                </div>
            </div>
        </div>
        <div class="boxbgsvg relative border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
            <div class="flex items-center space-x-3 w-full gap-1">
                <img src={{ asset('assets/images/icons/total-income-icon.webp') }} width="64" height="48" alt="Logo" class="w-12 h-auto">
                <div class="w-full">
                    <h3 class="text-base mb-1 opacity-75 leading-none flex items-start justify-between">Available balance</h3>
                    <span class="text-xl font-bold">00</span>
                </div>
            </div>
        </div>
        <div class="boxbgsvg relative border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
            <div class="flex items-center space-x-3 w-full gap-1">
                <img src={{ asset('assets/images/icons/mt5-balance.webp') }} width="64" height="48" alt="Logo" class="w-12 h-auto">
                <div class="w-full">
                    <h3 class="text-base mb-1 opacity-75 leading-none flex items-start justify-between">Pending Balance</h3>
                    <span class="text-xl font-bold">85,522.52</span>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl mt-10">
        <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 mb-4">
            <button data-dialog-target="dialog" class="border-0 rounded-sm relative rankinginfo3 px-3 py-2 text-sm sm:text-base leading-none uppercase">Withdraw</button>
            <!-- <button class="border-0 rounded-sm relative rankinginfo3 px-3 py-2 text-sm sm:text-base leading-none uppercase">Reinvest</button> -->
            <a href="{{ url('/activation-pin') }}" class="border-0 rounded-sm relative rankinginfo3 px-3 py-2 text-sm sm:text-base leading-none uppercase">Transfer Balance</a>
        </div>
        <div class="overflow-x-auto">
            <table id="withdrawalsTable" class="w-full text-left border-collapse" style="padding-top: 15px;">
                <thead>
                    <tr class="bg-white bg-opacity-10 text-white">
                        <th class="px-4 py-2">Sr.</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Queue</th>
                        <th class="px-4 py-2">Transaction ID</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $withdrawalsData = [
                    ['amount' => '2500.75', 'status' => 'Complete', 'queue' => 'Processed', 'transactionid' => 'TXN-1A2B3C4D', 'date' => '02-01-2025 10:15 AM'],
                    ['amount' => '4800.50', 'status' => 'Pending', 'queue' => 'In Queue', 'transactionid' => 'TXN-5E6F7G8H', 'date' => '15-12-2024 09:30 PM'],
                    ['amount' => '3000.00', 'status' => 'Cancelled', 'queue' => 'Failed', 'transactionid' => 'TXN-9I0J1K2L', 'date' => '10-12-2024 04:45 PM'],
                    ['amount' => '5200.58', 'status' => 'Complete', 'queue' => 'Processed', 'transactionid' => 'TXN-3M4N5O6P', 'date' => '13-12-2024 11:59 AM'],
                    ['amount' => '6100.99', 'status' => 'Pending', 'queue' => 'In Queue', 'transactionid' => 'TXN-7Q8R9S0T', 'date' => '05-01-2025 02:10 PM'],
                    ['amount' => '7500.35', 'status' => 'Complete', 'queue' => 'Processed', 'transactionid' => 'TXN-1U2V3W4X', 'date' => '08-01-2025 06:25 AM'],
                    ['amount' => '8900.75', 'status' => 'Cancelled', 'queue' => 'Failed', 'transactionid' => 'TXN-5Y6Z7A8B', 'date' => '28-12-2024 08:40 PM'],
                    ['amount' => '3200.20', 'status' => 'Pending', 'queue' => 'In Queue', 'transactionid' => 'TXN-9C0D1E2F', 'date' => '19-12-2024 12:30 PM'],
                    ['amount' => '9900.88', 'status' => 'Complete', 'queue' => 'Processed', 'transactionid' => 'TXN-3G4H5I6J', 'date' => '31-12-2024 07:15 PM'],
                    ['amount' => '4100.45', 'status' => 'Cancelled', 'queue' => 'Failed', 'transactionid' => 'TXN-7K8L9M0N', 'date' => '14-01-2025 05:50 AM'],
                    ];
                    @endphp

                    @foreach ($withdrawalsData as $index => $withdrawals)
                    @php
                    // Set colors based on status
                    $statusColor = $withdrawals['status'] === 'Complete' ? 'text-green-400'
                    : ($withdrawals['status'] === 'Pending' ? 'text-yellow-400'
                    : 'text-red-400');

                    // Set colors based on status
                    $queueColor = $withdrawals['queue'] === 'Processed' ? 'text-green-400'
                    : ($withdrawals['queue'] === 'In Queue' ? 'text-yellow-400'
                    : 'text-red-400');

                    @endphp
                    <tr>
                        <td class="text-nowrap mr-3 px-4 py-2 flex items-center">
                            <span>{{ $index + 1 }}</span>
                        </td>
                        <td class="text-nowrap px-4 py-2">{{ $withdrawals['amount'] }}</td>
                        <td class="text-nowrap px-4 py-2 {{ $statusColor }}">{{ $withdrawals['status'] }}</td>
                        <td class="text-nowrap px-4 py-2 {{ $queueColor }}">{{ $withdrawals['queue'] }}</td>
                        <td class="text-nowrap px-4 py-2">{{ $withdrawals['transactionid'] }}</td>
                        <td class="text-nowrap px-4 py-2 text-[#30b8f5]">{{ $withdrawals['date'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
<div data-dialog-backdrop="dialog" data-dialog-backdrop-close="true" class="pointer-events-none fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black bg-opacity-60 opacity-0 backdrop-blur-sm transition-opacity duration-300 overflow-auto p-2">
    <div data-dialog="dialog" class="text-white relative text-white m-4 p-4 w-full max-w-xl rounded-lg bg-black shadow-sm border border-[#2b2b2f]" style="max-height: calc(100% - 0px);">
        <div class="flex items-start justify-between">
            <div class="flex shrink-0 items-center pb-4 text-xl font-medium">
                Withdraw form
            </div>
            <button data-ripple-dark="true" data-dialog-close="true" class="relative h-8 w-8 bg-white bg-opacity-10 flex items-center justify-center select-none rounded-lg text-center" type="button">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="relative border-t border-[#2b2b2f] py-4 leading-normal font-light">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-2 gap-5 mb-5">
                <div class="boxbgsvg relative border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
                    <div class="flex items-center space-x-3 w-full gap-1">
                        <div class="text-2xl flex items-center justify-center w-12 h-12 min-w-12 min-h-12 rounded-full border border-white border-opacity-15 bg-white bg-opacity-10 text-center">1</div>
                        <div class="w-full">
                            <h3 class="text-base mb-2 opacity-75 leading-none">Available balance</h3>
                            <span class="text-base font-semibold">$6,369.427</span>
                        </div>
                    </div>
                </div>
                <div class="boxbgsvg relative border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
                    <div class="flex items-center space-x-3 w-full gap-1">
                        <div class="text-2xl flex items-center justify-center w-12 h-12 min-w-12 min-h-12 rounded-full border border-white border-opacity-15 bg-white bg-opacity-10 text-center">2</div>
                        <div class="w-full">
                            <h3 class="text-base mb-2 opacity-75 leading-none">Pending Balance</h3>
                            <span class="text-base font-semibold">$0</span>
                        </div>
                    </div>
                </div>
            </div>
            <form class="relative">
                <!-- usdt -->
                <div class="relative">
                    <label for="usdt" class="block text-xs text-white text-opacity-70 font-medium mb-2">Withdraw In</label>
                    <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-30 p-3 rounded gap-3 bg-black bg-opacity-50">
                        <div class="inline-flex items-center">
                            <label class="relative flex items-center cursor-pointer" for="usdt">
                                <input id="usdt" name="usdt" type="radio" class="peer h-5 w-5 cursor-pointer appearance-none rounded-full border border-slate-300 checked:border-slate-400 transition-all">
                                <span class="absolute bg-white w-3 h-3 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                </span>
                            </label>
                            <label class="ml-2 text-white cursor-pointer text-sm uppercase" for="usdt">usdt</label>
                        </div>
                    </div>
                </div>
                <!-- amount -->
                <div class="relative">
                    <label for="amount" class="block text-xs text-white text-opacity-70 font-medium mb-2">Enter Amount</label>
                    <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-30 p-3 rounded gap-3 bg-black bg-opacity-50">
                        <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none">
                            <path d="M21 6V3.50519C21 2.92196 20.3109 2.61251 19.875 2.99999C19.2334 3.57029 18.2666 3.57029 17.625 2.99999C16.9834 2.42969 16.0166 2.42969 15.375 2.99999C14.7334 3.57029 13.7666 3.57029 13.125 2.99999C12.4834 2.42969 11.5166 2.42969 10.875 2.99999C10.2334 3.57029 9.26659 3.57029 8.625 2.99999C7.98341 2.42969 7.01659 2.42969 6.375 2.99999C5.73341 3.57029 4.76659 3.57029 4.125 2.99999C3.68909 2.61251 3 2.92196 3 3.50519V14M21 10V20.495C21 21.0782 20.3109 21.3876 19.875 21.0002C19.2334 20.4299 18.2666 20.4299 17.625 21.0002C16.9834 21.5705 16.0166 21.5705 15.375 21.0002C14.7334 20.4299 13.7666 20.4299 13.125 21.0002C12.4834 21.5705 11.5166 21.5705 10.875 21.0002C10.2334 20.4299 9.26659 20.4299 8.625 21.0002C7.98341 21.5705 7.01659 21.5705 6.375 21.0002C5.73341 20.4299 4.76659 20.4299 4.125 21.0002C3.68909 21.3876 3 21.0782 3 20.495V18" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7.5 15.5H11.5M16.5 15.5H14.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M16.5 12H12.5M7.5 12H9.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7.5 8.5H16.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        <input type="text" name="amount" id="amount" placeholder="Enter Amount  (min withdraw $10)" required="required" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base">
                    </div>
                </div>
                <!-- Admin Fees -->
                <div class="relative">
                    <label for="adminfees" class="block text-xs text-white text-opacity-70 font-medium mb-2">Admin Fees 5 %</label>
                    <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-30 p-3 rounded gap-3 bg-black bg-opacity-50">
                        <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none">
                            <path d="M21 6V3.50519C21 2.92196 20.3109 2.61251 19.875 2.99999C19.2334 3.57029 18.2666 3.57029 17.625 2.99999C16.9834 2.42969 16.0166 2.42969 15.375 2.99999C14.7334 3.57029 13.7666 3.57029 13.125 2.99999C12.4834 2.42969 11.5166 2.42969 10.875 2.99999C10.2334 3.57029 9.26659 3.57029 8.625 2.99999C7.98341 2.42969 7.01659 2.42969 6.375 2.99999C5.73341 3.57029 4.76659 3.57029 4.125 2.99999C3.68909 2.61251 3 2.92196 3 3.50519V14M21 10V20.495C21 21.0782 20.3109 21.3876 19.875 21.0002C19.2334 20.4299 18.2666 20.4299 17.625 21.0002C16.9834 21.5705 16.0166 21.5705 15.375 21.0002C14.7334 20.4299 13.7666 20.4299 13.125 21.0002C12.4834 21.5705 11.5166 21.5705 10.875 21.0002C10.2334 20.4299 9.26659 20.4299 8.625 21.0002C7.98341 21.5705 7.01659 21.5705 6.375 21.0002C5.73341 20.4299 4.76659 20.4299 4.125 21.0002C3.68909 21.3876 3 21.0782 3 20.495V18" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7.5 15.5H11.5M16.5 15.5H14.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M16.5 12H12.5M7.5 12H9.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7.5 8.5H16.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        <input type="text" name="adminfees" id="adminfees" placeholder="0" value="0" required="required" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base">
                    </div>
                </div>
                <!-- Your final Amount -->
                <div class="relative">
                    <label for="yourfinalamount" class="block text-xs text-white text-opacity-70 font-medium mb-2">Your final Amount</label>
                    <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-30 p-3 rounded gap-3 bg-black bg-opacity-50">
                        <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none">
                            <path d="M21 6V3.50519C21 2.92196 20.3109 2.61251 19.875 2.99999C19.2334 3.57029 18.2666 3.57029 17.625 2.99999C16.9834 2.42969 16.0166 2.42969 15.375 2.99999C14.7334 3.57029 13.7666 3.57029 13.125 2.99999C12.4834 2.42969 11.5166 2.42969 10.875 2.99999C10.2334 3.57029 9.26659 3.57029 8.625 2.99999C7.98341 2.42969 7.01659 2.42969 6.375 2.99999C5.73341 3.57029 4.76659 3.57029 4.125 2.99999C3.68909 2.61251 3 2.92196 3 3.50519V14M21 10V20.495C21 21.0782 20.3109 21.3876 19.875 21.0002C19.2334 20.4299 18.2666 20.4299 17.625 21.0002C16.9834 21.5705 16.0166 21.5705 15.375 21.0002C14.7334 20.4299 13.7666 20.4299 13.125 21.0002C12.4834 21.5705 11.5166 21.5705 10.875 21.0002C10.2334 20.4299 9.26659 20.4299 8.625 21.0002C7.98341 21.5705 7.01659 21.5705 6.375 21.0002C5.73341 20.4299 4.76659 20.4299 4.125 21.0002C3.68909 21.3876 3 21.0782 3 20.495V18" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7.5 15.5H11.5M16.5 15.5H14.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M16.5 12H12.5M7.5 12H9.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7.5 8.5H16.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        <input type="text" name="yourfinalamount" id="yourfinalamount" placeholder="Your final Amount" value="0" required="required" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base">
                    </div>
                </div>


                <!-- button start -->
                <div class="flex items-center justify-center mt-8 relative group">
                    <button class="w-full relative inline-block p-px font-semibold leading-none text-white cursor-pointer rounded-sm">
                        <span class="absolute inset-0 rounded-sm bg-gradient-to-r from-teal-400 via-blue-500 to-purple-500 p-[2px]"></span>
                        <span class="relative z-10 block px-6 py-3 rounded-sm">
                            <div class="relative z-10 flex items-center space-x-2 justify-center">
                                <span class="transition-all duration-500 group-hover:translate-x-1">Withdraw </span>
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