@extends('layouts.app')

@section('title', 'Activate Package (USDT)')

@section('content')
<section class="w-full p-3 md:p-5 mx-auto max-w-[1400px]">
    <div class="grid grid-cols-1 gap-5 relative z-10">
        <div class="grid grid-cols-1 xl:grid-cols-4">
            <div class="cols-span-1 xl:col-span-1"></div>
            <div class="cols-span-1 xl:col-span-2 grid-cols-1 grid">
                <div class="p-4 rounded-xl w-full mx-auto border border-[#2b2b2f] bg-black relative boxbgsvg1">
                    <h3 class="font-bold text-xl md:text-2xl mb-4">Transfer Balance</h3>
                    <form class="relative">
                        <!-- Enter user id -->
                        <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-30 p-3 rounded gap-3 bg-black bg-opacity-50">
                            <svg class="w-6 h-6 min-w-6 min-h-6" fill="#ffffff" viewBox="0 0 24 24">
                                <path d="M12 1.2A4.8 4.8 0 1 0 16.8 6 4.805 4.805 0 0 0 12 1.2zm0 8.6A3.8 3.8 0 1 1 15.8 6 3.804 3.804 0 0 1 12 9.8zM20 22H4v-4.5A5.506 5.506 0 0 1 9.5 12h5a5.506 5.506 0 0 1 5.5 5.5zM5 21h14v-3.5a4.505 4.505 0 0 0-4.5-4.5h-5A4.505 4.505 0 0 0 5 17.5z" />
                                <path fill="none" d="M0 0h24v24H0z" />
                            </svg>
                            <select class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base selectbox">
                                <option value="" disabled selected>Select your country</option>
                                <option value="us">United States</option>
                                <option value="uk">United Kingdom</option>
                                <option value="in">India</option>
                                <option value="de">Germany</option>
                                <option value="fr">France</option>
                            </select>
                        </div>

                        <!-- amount -->
                        <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-30 p-3 rounded gap-3 bg-black bg-opacity-50">
                            <svg class="w-6 h-6 min-w-6 min-h-6" viewBox="0 0 24 24" fill="none">
                                <path d="M21 6V3.50519C21 2.92196 20.3109 2.61251 19.875 2.99999C19.2334 3.57029 18.2666 3.57029 17.625 2.99999C16.9834 2.42969 16.0166 2.42969 15.375 2.99999C14.7334 3.57029 13.7666 3.57029 13.125 2.99999C12.4834 2.42969 11.5166 2.42969 10.875 2.99999C10.2334 3.57029 9.26659 3.57029 8.625 2.99999C7.98341 2.42969 7.01659 2.42969 6.375 2.99999C5.73341 3.57029 4.76659 3.57029 4.125 2.99999C3.68909 2.61251 3 2.92196 3 3.50519V14M21 10V20.495C21 21.0782 20.3109 21.3876 19.875 21.0002C19.2334 20.4299 18.2666 20.4299 17.625 21.0002C16.9834 21.5705 16.0166 21.5705 15.375 21.0002C14.7334 20.4299 13.7666 20.4299 13.125 21.0002C12.4834 21.5705 11.5166 21.5705 10.875 21.0002C10.2334 20.4299 9.26659 20.4299 8.625 21.0002C7.98341 21.5705 7.01659 21.5705 6.375 21.0002C5.73341 20.4299 4.76659 20.4299 4.125 21.0002C3.68909 21.3876 3 21.0782 3 20.495V18" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M7.5 15.5H11.5M16.5 15.5H14.5" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M16.5 12H12.5M7.5 12H9.5" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M7.5 8.5H16.5" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            <select class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base selectbox">
                                <option value="" disabled selected>Select your country</option>
                                <option value="us">United States</option>
                                <option value="uk">United Kingdom</option>
                                <option value="in">India</option>
                                <option value="de">Germany</option>
                                <option value="fr">France</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between">
                            <span style="color: white;">Available Balance</span>
                            <span style="color: white;" class="text-right min-w-[100px]" id="amountInUsdt">25,897.427</span>
                        </div>
                        <!-- button start -->
                        <div class="flex items-center justify-center mt-8 relative group">
                            <button class="w-full relative inline-block p-px font-semibold leading-none text-white cursor-pointer rounded-sm">
                                <span class="absolute inset-0 rounded-sm bg-gradient-to-r from-teal-400 via-blue-500 to-purple-500 p-[2px]"></span>
                                <span class="relative z-10 block px-6 py-3 rounded-sm">
                                    <div class="relative z-10 flex items-center space-x-2 justify-center">
                                        <span class="transition-all duration-500 group-hover:translate-x-1">Transfer</span>
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
            <div class="cols-span-1 xl:col-span-1"></div>
        </div>
        <div class="grid grid-cols-1 gap-5 mt-4">
            <div class="grid-cols-1 grid gap-5">
                <div class="p-4 rounded-xl w-full mx-auto border border-[#2b2b2f] bg-black relative boxbgsvg1 space-y-4">
                    <div class="overflow-x-auto">
                        <table id="withdrawalsTable" class="w-full text-left border-collapse" style="padding-top: 15px;">
                            <thead>
                                <tr class="bg-white bg-opacity-10 text-white">
                                    <th class="px-4 py-2">User Id.</th>
                                    <th class="px-4 py-2">Amount</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Used By</th>
                                    <th class="px-4 py-2">Transfer Type</th>
                                    <th class="px-4 py-2">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $withdrawalsData = [
                                ['userid' => 'admin','amount' => '2500.75', 'status' => 'Complete', 'usedby' => '0', 'transfertype' => 'TXN-1A2B3C4D', 'date' => '02-01-2025 10:15 AM'],
                                ['userid' => 'admin','amount' => '4800.50', 'status' => 'Pending', 'usedby' => '0', 'transfertype' => 'TXN-5E6F7G8H', 'date' => '15-12-2024 09:30 PM'],
                                ['userid' => 'admin','amount' => '3000.00', 'status' => 'Cancelled', 'usedby' => '0', 'transfertype' => 'TXN-9I0J1K2L', 'date' => '10-12-2024 04:45 PM'],
                                ['userid' => 'admin','amount' => '5200.58', 'status' => 'Complete', 'usedby' => '0', 'transfertype' => 'TXN-3M4N5O6P', 'date' => '13-12-2024 11:59 AM'],
                                ['userid' => 'admin','amount' => '6100.99', 'status' => 'Pending', 'usedby' => '0', 'transfertype' => 'TXN-7Q8R9S0T', 'date' => '05-01-2025 02:10 PM'],
                                ['userid' => 'admin','amount' => '7500.35', 'status' => 'Complete', 'usedby' => '0', 'transfertype' => 'TXN-1U2V3W4X', 'date' => '08-01-2025 06:25 AM'],
                                ['userid' => 'admin','amount' => '8900.75', 'status' => 'Cancelled', 'usedby' => '0', 'transfertype' => 'TXN-5Y6Z7A8B', 'date' => '28-12-2024 08:40 PM'],
                                ['userid' => 'admin','amount' => '3200.20', 'status' => 'Pending', 'usedby' => '0', 'transfertype' => 'TXN-9C0D1E2F', 'date' => '19-12-2024 12:30 PM'],
                                ['userid' => 'admin','amount' => '9900.88', 'status' => 'Complete', 'usedby' => '0', 'transfertype' => 'TXN-3G4H5I6J', 'date' => '31-12-2024 07:15 PM'],
                                ['userid' => 'admin','amount' => '4100.45', 'status' => 'Cancelled', 'usedby' => '0', 'transfertype' => 'TXN-7K8L9M0N', 'date' => '14-01-2025 05:50 AM'],
                                ];
                                @endphp

                                @foreach ($withdrawalsData as $index => $withdrawals)
                                @php
                                // Set colors based on status
                                $statusColor = $withdrawals['status'] === 'Complete' ? 'text-green-400'
                                : ($withdrawals['status'] === 'Pending' ? 'text-yellow-400'
                                : 'text-red-400');


                                @endphp
                                <tr>
                                    <td class="text-nowrap mr-3 px-4 py-2 flex items-center">{{ $withdrawals['userid'] }}</td>
                                    <td class="text-nowrap px-4 py-2">{{ $withdrawals['amount'] }}</td>
                                    <td class="text-nowrap px-4 py-2 {{ $statusColor }}">{{ $withdrawals['status'] }}</td>
                                    <td class="text-nowrap px-4 py-2">{{ $withdrawals['usedby'] }}</td>
                                    <td class="text-nowrap px-4 py-2">{{ $withdrawals['transfertype'] }}</td>
                                    <td class="text-nowrap px-4 py-2 text-[#30b8f5]">{{ $withdrawals['date'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection