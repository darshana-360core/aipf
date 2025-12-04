@extends('layouts.app')

@section('title', 'Pool Rewards')

@section('content')
<!-- Flatpickr CSS -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> -->

<section class="grid grid-cols-1 gap-5 mt-5">
    <div class="w-full p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-3 mb-6">
                <div class="w-2 h-12 bg-gradient-to-b from-blue-400 to-purple-600 rounded-full"></div>
                <h1 class="text-4xl md:text-5xl font-bold text-white">Pool Rewards</h1>
                <div class="w-2 h-12 bg-gradient-to-b from-purple-600 to-pink-600 rounded-full"></div>
            </div>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Participate in our revolutionary reward distribution system powered by transaction fees
            </p>

            <div class="mt-4 inline-flex items-center gap-2 bg-gray-800/50 rounded-full px-4 py-2 text-sm text-gray-400">
                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                Live contract data
            </div>
        </div>

        <!-- Overview Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 overflow-hidden">
            <x-stat-box
                title="Burning"
                value="3%"
                bgColor="#0BF4C8"
                borderColor="#0BF4C8"
                imageSrc="{{ asset('assets/images/icons/marketvalue.webp') }}" />

            <x-stat-box
                title="Pool Allocation"
                value="3%"
                bgColor="#FAD85D"
                borderColor="#FAD85D"
                imageSrc="{{ asset('assets/images/icons/totalsupply.webp') }}" />

            <x-stat-box
                title="Total Transaction Fees"
                value="6%"
                bgColor="#F2A0FF"
                borderColor="#F2A0FF"
                imageSrc="{{ asset('assets/images/icons/rtxprice.webp') }}" />
        </div>

        <!-- Pool Rewards Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 to-cyan-600 border border-white/20 rounded-3xl p-6 shadow-2xl">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-1">Daily Pool</h3>
                        <p class="text-white/80 text-sm">Distributed to 11 members daily</p>
                    </div>
                    <div class="w-16 h-16 bg-white rounded-full">
                        <img src="{{ asset('assets/images/icons/marketvalue.webp') }}" alt="Daily Pool" class="object-contain filter drop-shadow-lg" />
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-white/80 text-sm">Current Pool</span>
                            <span class="text-white font-semibold">{{$data['daily_pool']}} RTX</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-white/80 text-sm">Your Collected</span>
                            <span class="text-green-300 font-semibold">{{$data['claim_daily_pool_amount']}} RTX</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden bg-gradient-to-br from-purple-600 to-pink-600 border border-white/20 rounded-3xl p-6 shadow-2xl">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-1">Monthly Pool</h3>
                        <p class="text-white/80 text-sm">Best monthly performer</p>
                    </div>
                    <div class="w-16 h-16 bg-white rounded-full">
                        <img src="{{ asset('assets/images/icons/totalsupply.webp') }}" alt="Monthly Pool" class="object-contain filter drop-shadow-lg" />
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-white/80 text-sm">Current Pool</span>
                            <span class="text-white font-semibold">{{$data['monthly_pool']}} RTX</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-white/80 text-sm">Your Collected</span>
                            <span class="text-green-300 font-semibold">{{$data['claim_monthly_pool_amount']}} RTX</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="text-lg sm:text-xl font-semibold text-center items-center justify-between text-white mb-4">Pool Overview</h2>
        <div class="w-full p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl">
            <div class="p-4 rounded-xl mx-auto relative w-full h-auto my-10 bg-gradient-to-t from-[#6b3fb9] to-indigo-500 border border-[#bd97ff]">
            <form method="POST" action="{{route('pool-rewards')}}">
                @method('POST')
                @csrf
                <div id="date-range-picker" date-rangepicker class="flex flex-wrap sm:flex-nowrap gap-2 items-center justify-center text-white">
                    <div class="w-full relative flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-black bg-opacity-0">
                        <svg class="w-7 h-7 min-w-7 min-h-7" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                        <input id="datepicker-range-start" @if(isset($data['start_date'])) value="{{$data['start_date']}}" @endif placeholder="Select date start" name="start_date" type="text" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base" autocomplete="off">
                    </div>
                    <span class="mx-4 hidden sm:block">TO</span>
                    <div class="w-full relative flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-black bg-opacity-0">
                        <svg class="w-7 h-7 min-w-7 min-h-7" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                        <input id="datepicker-range-end" @if(isset($data['end_date'])) value="{{$data['end_date']}}" @endif placeholder="Select date end" name="end_date" type="text" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base" autocomplete="off">
                    </div>
                    <button type="submit"><svg class="w-12 h-12 min-w-12 min-h-12 cursor-pointer bg-white bg-opacity-10 border border-white border-opacity-20 p-2 rounded-lg ml-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg></button>
                </div>
            </form>
        </div>
            <div class="mb-4 border-b-2 border-[#322751]">
                <ul class="incomeOverview_tab flex flex-nowrap justify-center -mb-px text-sm font-medium text-center overflow-auto" data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-total_directs" data-tabs-target="#total_directs" type="button" role="tab" aria-controls="total_directs" aria-selected="false">Daily Pool</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-active_directs" data-tabs-target="#active_directs" type="button" role="tab" aria-controls="active_directs" aria-selected="false">Monthly Pool</button>
                    </li>
                </ul>
            </div>
            <div id="default-tab-content">
                <div class="hidden" id="total_directs" role="tabpanel" aria-labelledby="table-total_directs">
                    <div class="overflow-x-auto">
                        <table id="dailyPool1" class="w-full text-left border-collapse" style="padding-top: 15px;">
                            <thead>
                                <tr class="bg-white bg-opacity-10 text-white">
                                    <th class="px-4 py-2">Sr.</th>
                                    <!-- <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">User Id</span></th> -->
                                    <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Wallet Address</span></th>
                                    <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Amount</span></th>
                                    <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Date</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($data['daily_data']))
                                    @foreach ($data['daily_data'] as $key => $value)
                                    <tr>
                                        <td class="text-nowrap px-4 py-2">{{ $key + 1 }}</td>
                                        <td class="text-nowrap px-4 py-2 text-center">{{ $value['wallet_address'] }}</td>
                                        <td class="text-nowrap px-4 py-2 text-center">{{ round($value['dailyPool'], 3) }}</td>
                                        <td class="text-nowrap px-4 py-2 text-center">{{ date('d-m-Y', strtotime($value['created_on'])) }}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="hidden" id="active_directs" role="tabpanel" aria-labelledby="table-active_directs">
                    <div class="overflow-x-auto">
                        <table id="monthlyPool1" class="w-full text-left border-collapse" style="padding-top: 15px;">
                            <thead>
                                <tr class="bg-white bg-opacity-10 text-white">
                                    <th class="px-4 py-2">Sr.</th>
                                    <!-- <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">User Id</span></th> -->
                                    <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Wallet Address</span></th>
                                    <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Amount</span></th>
                                    <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Stake Amount</span></th>
                                    <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Date</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($data['monthly_data']))
                                @foreach ($data['monthly_data'] as $key => $value)
                                <tr>
                                    <td class="text-nowrap px-4 py-2">{{ $key + 1 }}</td>
                                    <td class="text-nowrap px-4 py-2 text-center">{{ $value['wallet_address'] }}</td>
                                    <td class="text-nowrap px-4 py-2 text-center">{{ round($value['monthlyPool'], 3) }}</td>
                                    <td class="text-nowrap px-4 py-2 text-center">{{ round($value['refrence'], 3) }}</td>
                                    <td class="text-nowrap px-4 py-2 text-center">{{ date('d-m-Y', strtotime($value['created_on'])) }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Fee Mechanism -->
        <div class="hidden bg-gradient-to-br from-gray-800/50 via-gray-700/50 to-gray-800/50 border border-gray-600/30 rounded-3xl p-4 md:p-5 backdrop-blur-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white">Transaction Fee Utilization</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-red-500/20 to-red-600/20 border border-red-500/30 rounded-2xl p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.5-7 0 0 .5 2 2.5 2S16 3 16 3s1 2 1.657 2.343A8 8 0 0117.657 18.657z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-white">3%</div>
                            <div class="text-red-200 text-sm">goes to Burning</div>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm">
                        Reducing the circulation supply of $RTX increases scarcity and supports the minting, enhancing the value of the entire ecosystem and stability of RTX token.
                    </p>
                </div>

                <div class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 border border-blue-500/30 rounded-2xl p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-white">2.0%</div>
                            <div class="text-blue-200 text-sm">goes to Daily Pool</div>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm">
                        Daily pool reward enhances and boosts users' participation and active community, giving them opportunity to earn daily rewards from pool to 11 members of community.
                    </p>
                </div>

                <div class="bg-gradient-to-br from-purple-500/20 to-purple-600/20 border border-purple-500/30 rounded-2xl p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-white">1%</div>
                            <div class="text-purple-200 text-sm">goes to Monthly Pool</div>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm">
                        RTX rewards from transaction fees of 1% from total 6% transaction fees are secured and provided to the best person who performs monthly in the Orbit Community.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
    @section('script')
    <script>
        $(document).ready(function () {
            // table
            if ($.fn.DataTable.isDataTable("#dailyPool1,#monthlyPool1")) {
                $("#dailyPool1,#monthlyPool1").DataTable().destroy(); // Destroy existing DataTable instance
            }

            // Monthly Pool: 31 records
            $("#monthlyPool1").DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "lengthMenu": [10, 25, 31, 50], // Include 31 to let user show all
                "pageLength": 31, // Still default to 10
                "info": true
            });

            // Daily Pool: 11 records
            $("#dailyPool1").DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "lengthMenu": [5, 10, 11, 25], // Include 11 to show all
                "pageLength": 11,
                "info": true
            });
        });
    </script>
    @endsection
@endsection