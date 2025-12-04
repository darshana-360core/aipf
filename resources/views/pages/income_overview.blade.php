@extends('layouts.app')

@section('title', 'Income Overview')

@section('content')
<section class="w-full p-3 md:p-5 mx-auto max-w-[1400px]">
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
    <x-stat-box
        title="Stake Bonus"
        valuesDolur="${{ number_format($data['user']['roi_income'] * $data['rtxPrice'], 3) }}"
        :value="number_format($data['user']['roi_income'], 3) . ' RTX'"
        bgColor="#FAD85D"
        borderColor="#FAD85D"
        imageSrc="{{ asset('assets/images/income-icons/profit-sharing.webp') }}" />

    <x-stat-box
        title="Level Bonus"
        valuesDolur="${{ number_format($data['user']['level_income'] * $data['rtxPrice'], 3) }}"
        :value="number_format($data['user']['level_income'], 3) . ' RTX'"
        bgColor="#ffa0b7"
        borderColor="#ffa0b7"
        imageSrc="{{ asset('assets/images/income-icons/level-income.webp') }}" />

    <x-stat-box
        title="Upline Bonus"
        valuesDolur="${{ number_format($data['user']['direct_income'] * $data['rtxPrice'], 3) }}"
        :value="number_format($data['user']['direct_income'], 3) . ' RTX'"
        bgColor="#F2A0FF"
        borderColor="#F2A0FF"
        imageSrc="{{ asset('assets/images/income-icons/rank-income.webp') }}" />

    <x-stat-box
        title="Star Bonus"
        valuesDolur="${{ number_format($data['user']['rank_bonus'] * $data['rtxPrice'], 3) }}"
        :value="number_format($data['user']['rank_bonus'], 3) . ' RTX'"
        bgColor="#aea0ff"
        borderColor="#aea0ff"
        imageSrc="{{ asset('assets/images/income-icons/leadership.webp') }}" />

    <x-stat-box
        title="Club Bonus"
        valuesDolur="${{ number_format($data['user']['club_bonus'] * $data['rtxPrice'], 3) }}"
        :value="number_format($data['user']['club_bonus'], 3) . ' RTX'"
        bgColor="#ffe1a0"
        borderColor="#ffe1a0"
        imageSrc="{{ asset('assets/images/income-icons/ib-income.webp') }}" />

    <x-stat-box
        title="Reward Bonus"
        valuesDolur="${{ number_format($data['user']['reward_bonus'] * $data['rtxPrice'], 3) }}"
        :value="number_format($data['user']['reward_bonus'], 3) . ' RTX'"
        bgColor="#a0ffe4"
        borderColor="#a0ffe4"
        imageSrc="{{ asset('assets/images/icons/reward-bonus.webp') }}?v={{time()}}" />

    <x-stat-box
        title="Daily Pool Bonus"
        valuesDolur="${{ number_format($data['dailyPoolWinners'] * $data['rtxPrice'], 3) }}"
        :value="number_format($data['dailyPoolWinners'], 3) . ' RTX'"
        bgColor="#8bc34a"
        borderColor="#8bc34a"
        imageSrc="{{ asset('assets/images/icons/daily-pool.webp') }}?v={{time()}}" />

    <x-stat-box
        title="Monthly Pool Bonus"
        valuesDolur="${{ number_format($data['monthlyPoolWinners'] * $data['rtxPrice'], 3) }}"
        :value="number_format($data['monthlyPoolWinners'], 3) . ' RTX'"
        bgColor="#ffa0e7"
        borderColor="#ffa0e7"
        imageSrc="{{ asset('assets/images/icons/monthly-pool.webp') }}" />

    <x-stat-box
        title="Total Income"
        valuesDolur="${{ number_format(($data['user']['direct_income'] + $data['user']['roi_income'] + $data['user']['level_income'] + $data['user']['rank_bonus'] + $data['user']['royalty'] + $data['user']['reward_bonus'] + $data['user']['club_bonus']) * $data['rtxPrice'], 3) }}"
        :value="number_format(($data['user']['direct_income'] + $data['user']['roi_income'] + $data['user']['level_income'] + $data['user']['rank_bonus'] + $data['user']['royalty'] + $data['user']['reward_bonus'] + $data['user']['club_bonus']), 3) . ' RTX'"
        bgColor="#03a9f4"
        borderColor="#03a9f4"
        imageSrc="{{ asset('assets/images/income-icons/total-invest.webp') }}" />
</div>


    <div class="p-4 rounded-xl mx-auto relative w-full h-full my-10 bg-gradient-to-t from-[#6b3fb9] to-indigo-500 border border-[#bd97ff]">
        <form method="POST" action="{{route('fincomeOverview')}}">
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

    <div class="w-full p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl">
        <div class="mb-4 border-b-2 border-[#322751]">
            <ul class="incomeOverview_tab flex flex-nowrap -mb-px text-sm font-medium text-center overflow-auto" data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-tab-1" data-tabs-target="#tab-1" type="button" role="tab" aria-controls="tab-1" aria-selected="false">Stake Bonus</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-tab-2" data-tabs-target="#tab-2" type="button" role="tab" aria-controls="tab-2" aria-selected="false">Level Bonus</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-tab-3" data-tabs-target="#tab-3" type="button" role="tab" aria-controls="tab-3" aria-selected="false">Upline Bonus</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-tab-4" data-tabs-target="#tab-4" type="button" role="tab" aria-controls="tab-4" aria-selected="false">Star Bonus</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-tab-5" data-tabs-target="#tab-5" type="button" role="tab" aria-controls="tab-5" aria-selected="false">Club Bonus</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-tab-6" data-tabs-target="#tab-6" type="button" role="tab" aria-controls="tab-6" aria-selected="false">Reward Bonus</button>
                </li>
            </ul>
        </div>
        <div id="default-tab-content">
            <div class="" id="tab-1" role="tabpanel" aria-labelledby="table-tab-1">
                <div class="overflow-x-auto">
                    <table id="tabledata1" class="w-full text-left border-collapse" style="padding-top: 15px;">
                        <thead>
                            <tr class="bg-white bg-opacity-10 text-white">
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting">Sr.</th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="text-nowrap w-full block">Amount</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="text-nowrap w-full block">Tag</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="w-full block text-end">Date</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $srNo = 1;
                            @endphp
                            @if(isset($data['earningLogs']))
                            @foreach ($data['earningLogs'] as $key => $value)
                            @if($value['tag'] == "ROI")
                            <tr class="border-b border-white/5 hover:bg-[#34333a]/20">
                                <td class="text-nowrap px-4 py-2">{{$srNo++}}</td>
                                <td class="text-nowrap px-4 py-2 flex items-center justify-start gap-2"><span class="min-w-[50px]">{{ number_format($value['amount'], 3) }}</span> <b>-</b> <span class="min-w-[50px]">{{ number_format($value['refrence'],3)}}</span></td>
                                @if($value['refrence_id'] == 1)
                                    <td class="text-nowrap px-4 py-2">Stake Bonus</td>
                                @elseif($value['refrence_id'] == 2)
                                    <td class="text-nowrap px-4 py-2">LP Bonus</td>
                                @else
                                    <td class="text-nowrap px-4 py-2">Stable Bonus</td>
                                @endif
                                <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">{{ \Carbon\Carbon::parse($value['created_on'], 'UTC')->setTimezone('Europe/London')->format('d-m H:i') }}</td>

                            </tr>
                            @endif
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="hidden" id="tab-2" role="tabpanel" aria-labelledby="table-tab-2">
                <div class="overflow-x-auto">
                    <table id="tabledata2" class="w-full text-left border-collapse" style="padding-top: 15px;">
                        <thead>
                            <tr class="bg-white bg-opacity-10 text-white">
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting">Sr.</th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="text-nowrap w-full block text-center">Amount</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting text-end"><span class="w-full block text-end">Date</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting text-end"><span class="w-full block text-end">View All</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($data['levelEarningLogs']))
                            @foreach ($data['levelEarningLogs'] as $key => $value)
                            <tr>
                                <td class="text-nowrap px-4 py-2">{{$key + 1}}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ number_format($value['amount'], 3) }}</td>
                                <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">{{ \Carbon\Carbon::parse($value['created_on'], 'UTC')->setTimezone('Europe/London')->format('d-m H:i') }}</td>
                                <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]"><a href="{{route('flevelIncomeOverview')}}?start_date={{ date('d-m-Y', strtotime($value['created_on'])) }}&end_date={{ date('d-m-Y', strtotime($value['created_on'])) }}">View</a></td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="hidden" id="tab-3" role="tabpanel" aria-labelledby="table-tab-3">
                <div class="overflow-x-auto">
                    <table id="tabledata3" class="w-full text-left border-collapse" style="padding-top: 15px;">
                        <thead>
                            <tr class="bg-white bg-opacity-10 text-white">
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting">Sr.</th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="text-nowrap w-full block text-center">Amount</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="text-nowrap w-full block text-center">Tag</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting text-end"><span class="w-full block text-end">Date</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $srNo = 1;
                            @endphp
                            @if(isset($data['earningLogs']))
                            @foreach ($data['earningLogs'] as $key => $value)
                            @if($value['tag'] == "UPLINE-BONUS")
                            <tr>
                                <td class="text-nowrap px-4 py-2">{{$srNo++}}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ number_format($value['amount'], 3) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['tag'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">{{ \Carbon\Carbon::parse($value['created_on'], 'UTC')->setTimezone('Europe/London')->format('d-m H:i') }}</td>
                            </tr>
                            @endif
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="hidden" id="tab-4" role="tabpanel" aria-labelledby="table-tab-4">
                <div class="overflow-x-auto">
                    <table id="tabledata4" class="w-full text-left border-collapse" style="padding-top: 15px;">
                        <thead>
                            <tr class="bg-white bg-opacity-10 text-white">
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting">Sr.</th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="text-nowrap w-full block text-center">Amount</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="text-nowrap w-full block text-center">Tag</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="text-nowrap w-full block text-center">Rank</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting text-end"><span class="w-full block text-end">Date</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $srNo = 1;
                            @endphp
                            @if(isset($data['earningLogs']))
                            @foreach ($data['earningLogs'] as $key => $value)
                            @if($value['tag'] == "STAR-BONUS")
                            <tr>
                                <td class="text-nowrap px-4 py-2">{{$srNo++}}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ number_format($value['amount'], 3) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['tag'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['refrence'] }} Star</td>
                                <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">{{ \Carbon\Carbon::parse($value['created_on'], 'UTC')->setTimezone('Europe/London')->format('d-m H:i') }}</td>
                            </tr>
                            @endif
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="hidden" id="tab-5" role="tabpanel" aria-labelledby="table-tab-5">
                <div class="overflow-x-auto">
                    <table id="tabledata5" class="w-full text-left border-collapse" style="padding-top: 15px;">
                        <thead>
                            <tr class="bg-white bg-opacity-10 text-white">
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting">Sr.</th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="text-nowrap w-full block text-center">Amount</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="text-nowrap w-full block text-center">Tag</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="text-nowrap w-full block text-center">Club</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting text-end"><span class="w-full block text-end">Date</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $srNo = 1;
                            @endphp
                            @if(isset($data['earningLogs']))
                            @foreach ($data['earningLogs'] as $key => $value)
                            @if($value['tag'] == "CLUB-BONUS")
                            <tr>
                                <td class="text-nowrap px-4 py-2">{{$srNo++}}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ number_format($value['amount'], 3) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['tag'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['refrence'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">{{ \Carbon\Carbon::parse($value['created_on'], 'UTC')->setTimezone('Europe/London')->format('d-m H:i') }}</td>
                            </tr>
                            @endif
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="hidden" id="tab-6" role="tabpanel" aria-labelledby="table-tab-6">
                <div class="overflow-x-auto">
                    <table id="tabledata6" class="w-full text-left border-collapse" style="padding-top: 15px;">
                        <thead>
                            <tr class="bg-white bg-opacity-10 text-white">
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting">Sr.</th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="text-nowrap w-full block text-center">Amount</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="text-nowrap w-full block text-center">Tag</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="text-nowrap w-full block text-center">Rank</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting text-end"><span class="w-full block text-end">Date</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $srNo = 1;
                            @endphp
                            @if(isset($data['earningLogs']))
                            @foreach ($data['earningLogs'] as $key => $value)
                            @if($value['tag'] == "REWARD-BONUS")
                            <tr>
                                <td class="text-nowrap px-4 py-2">{{$srNo++}}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ number_format(($value['amount'] * $value['refrence']), 3) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['tag'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">Star {{ $value['refrence_id'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">{{ \Carbon\Carbon::parse($value['created_on'], 'UTC')->setTimezone('Europe/London')->format('d-m H:i') }}</td>
                            </tr>
                            @endif
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection