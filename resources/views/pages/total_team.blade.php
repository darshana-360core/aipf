@extends('layouts.app')

@section('title', 'My Team')

@section('content')
<section class="w-full mx-auto max-w-[1400px] space-y-4 md:space-y-6 mt-3 md:mt-5">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex-1 min-w-0">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white mb-1 sm:mb-2">My Team</h1>
            <p class="text-sm sm:text-base text-gray-400">Manage and track your network growth &amp; investments</p>
        </div>
        <button class="flex items-center gap-2 px-3 sm:px-4 py-2 bg-[#0BF4C8] text-black rounded-lg hover:bg-[#09d4b0] transition-colors font-semibold disabled:opacity-50 text-sm sm:text-base whitespace-nowrap">
            <svg class="w-4 h-4 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            <span class="hidden sm:inline">Refresh Data</span><span class="sm:hidden">Refresh</span>
        </button>
    </div>

    <div class="mt-4 sm:mt-6 pt-3 sm:pt-4 border-t border-[#322751]">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between text-sm gap-2">
            <span class="text-gray-400">Network Growth</span>
            <div class="flex flex-wrap items-center gap-2">
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div><span class="text-green-500 text-xs sm:text-sm">Multi-Level</span>
                </div><span class="text-gray-600">•</span>
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 bg-[#0BF4C8] rounded-full"></div><span class="text-[#0BF4C8] text-xs sm:text-sm">Active Network</span>
                </div>
            </div>
        </div>
    </div>
    <div class="p-4 rounded-xl mx-auto relative w-full h-full my-10 bg-gradient-to-t from-[#6b3fb9] to-indigo-500 border border-[#bd97ff]">
        <form method="POST" action="{{route('fmy_team')}}">
            @method('POST')
            @csrf
            <div id="date-range-picker" date-rangepicker class="flex flex-wrap sm:flex-nowrap gap-2 items-center justify-center text-white">
                <div class="w-full relative flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-black bg-opacity-0">
                    <svg class="w-7 h-7 min-w-7 min-h-7" fill="currentColor"><path fill="currentColor" d="M20.77 12.364s.85-3.51 0-4.7c-.85-1.188-1.188-1.98-3.057-2.547s-1.188-.454-2.547-.396c-1.36.058-2.492.793-2.492 1.19c0 0-.85.056-1.188.396c-.34.34-.906 1.924-.906 2.32s.283 3.06.566 3.625l-.337.114c-.284 3.283 1.13 3.68 1.13 3.68c.51 3.058 1.02 1.756 1.02 2.548s-.51.51-.51.51s-.452 1.245-1.584 1.698c-1.132.452-7.416 2.886-7.927 3.396c-.512.51-.454 2.888-.454 2.888h26.947s.06-2.377-.452-2.888c-.51-.51-6.795-2.944-7.927-3.396c-1.132-.453-1.584-1.698-1.584-1.698s-.51.282-.51-.51s.51.51 1.02-2.548c0 0 1.413-.397 1.13-3.68h-.34z"/></svg>

                    <input id="datepicker-range-start" @if(isset($data['wallet_address'])) value="{{$data['wallet_address']}}" @endif placeholder="Enter Wallet Address" name="wallet_address" type="text" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base" autocomplete="off">
                </div>
                <button type="submit"><svg class="w-12 h-12 min-w-12 min-h-12 cursor-pointer bg-white bg-opacity-10 border border-white border-opacity-20 p-2 rounded-lg ml-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg></button>
            </div>
        </form>
    </div>
    <div>
        <h2 class="text-lg sm:text-xl font-semibold text-white mb-3">Team Members</h2>
        <div class="grid grid-cols-1 xl:grid-cols-1 gap-5 mt-4">
            <div class="cols-span-1 md:col-span-1 grid grid-cols-1">
                <div class="w-full p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse" style="padding-top: 15px;">
                            <thead>
                                <tr class="bg-white bg-opacity-10 text-white">
                                    <th class="px-4 py-3 bg-[#34333a]">Sr.</th>
                                    <th class="px-4 py-3 bg-[#34333a]">Stake</th>
                                    <th class="px-4 py-3 bg-[#34333a]">Stake($)</th>
                                    <th class="px-4 py-3 bg-[#34333a]">Member Code</th>
                                    <th class="px-4 py-3 bg-[#34333a]">Sponsor</th>
                                    <th class="px-4 py-3 bg-[#34333a]">Activation Date</th>
                                    <th class="px-4 py-3 bg-[#34333a]">Rank</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($data['data']) == 0)
                                    <tr class="border-b border-white/5 hover:bg-[#34333a]/20">
                                        <td colspan="7" class="text-center mt-3 mb-3 font-bold text-m py-4 rounded-lg">No Data Found</td>
                                    </tr>
                                @endif
                                @php
                                    $sr = ($data['data']->currentPage() - 1) * $data['data']->perPage() + 1;
                                @endphp

                                @foreach ($data['data'] as $value)
                                    <tr class="border-b border-white/5 hover:bg-[#34333a]/20">
                                        <td class="px-4 py-4 text-sm text-gray-400">{{ $sr++ }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-400">{{ number_format($value['totalPackage'], 3) }} RTX</td>
                                        <td class="px-4 py-4 text-sm text-gray-400">${{ number_format($data['rtxPrice'] * $value['totalPackage'], 2) }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-400">{{ substr($value['wallet_address'], 0, 6) }}...{{ substr($value['wallet_address'], -6) }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-400">{{ $value['sponser_code'] }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-400">
                                            @if($value['currentPackageDate'] != '-')
                                                {{ \Carbon\Carbon::parse($value['currentPackageDate'], 'UTC')->setTimezone('Europe/London')->format('d-m H:i') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-400">{{ $value['rank'] == 0 ? "No Rank" : $value['rank'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-6">
                            {{ $data['data']->links('pagination::tailwind') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
