@extends('layouts.app')

@section('title', 'Income Overview')

@section('content')
<section class="w-full p-3 md:p-8 mx-auto max-w-[1400px]">
    <div class="grid grid-cols-2 sm:grid-cols-5 xl:grid-cols-5 gap-5">
        <!-- <div class="text-center cursor-pointer">
            <div class="p-4 levelbox text-center text-white relative flex flex-col gap-1 items-center justify-center mx-auto">
                <img src={{ asset('assets/images/icons/direct-investment.webp') }} width="64" height="48" alt="eth" class="w-12 sm:w-14 h-auto">
            </div>
            <h3 class="text-base my-2 opacity-75 leading-none">Referral</h3>
            <span class="text-xl">${{number_format($data['user']['direct_income'], 2)}}</span>
        </div> -->
        <div class="text-center cursor-pointer">
            <div class="p-4 levelbox text-center text-white relative flex flex-col gap-1 items-center justify-center mx-auto">
                <img src={{ asset('assets/images/income-icons/profit-sharing.webp') }} width="64" height="48" alt="eth" class="w-12 sm:w-14 h-auto">
            </div>
            <h3 class="text-base my-2 opacity-75 leading-none">Ads</h3>
            <span class="text-xl">${{ number_format($data['user']['direct_income'] + $data['user']['roi_income'], 2) }}/${{$data['roi_capping']}}</span>
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

    <div class="w-full p-4 md:p-6 rounded-xl mx-auto border border-[#2396b9] bg-[#101735] text-left p-4 rounded-xl bg-gradient-to-t from-[#265e8c] via-[#255480] to-[#243f82] overflow-hidden relative my-10">
        <form method="POST" action="{{route('fincomeOverview')}}">
            @method('POST')
            @csrf
            <div id="date-range-picker" {{-- date-rangepicker --}} class="flex flex-wrap sm:flex-nowrap gap-2 items-center justify-center text-white">
                <div class="w-full relative flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-black bg-opacity-0">
                    <svg class="w-7 h-7 min-w-7 min-h-7" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                    <input id="datepicker-range-start" @if(isset($data['start_date'])) value="{{$data['start_date']}}" @endif placeholder="Select date start" {{-- type="name" --}} name="start_date" type="date" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base" autocomplete="off">
                </div>
                <span class="mx-4 hidden sm:block">TO</span>
                <div class="w-full relative flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-black bg-opacity-0">
                    <svg class="w-7 h-7 min-w-7 min-h-7" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                    <input id="datepicker-range-end" @if(isset($data['end_date'])) value="{{$data['end_date']}}" @endif placeholder="Select date end" name="end_date" {{-- type="name" --}} type="date" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base" autocomplete="off">
                </div>
                <div class="relative   flex items-center justify-between border border-white border-opacity-5 p-3 rounded  bg-[#131c45] bg-opacity-50"  id="level-select" style="display: none;">
              
                <select class=" border-white border-opacity-15 outline-none shadow-none bg-transparent   text-base selectbox" name="level">
                    <option value="" disabled {{ empty($data['level']) ? 'selected' : '' }}>Select Level</option>

                    @for ($i = 1; $i <= 15; $i++)
                        @php
                            $levelValue = 'LEVEL' . $i . '-ROI';
                        @endphp
                        <option value="{{ $levelValue }}" {{ (isset($data['level']) && $data['level'] === $levelValue) ? 'selected' : '' }}>
                            Level {{ $i }}
                        </option>
                    @endfor
                </select>
                </div>
                <button type="submit"><svg class="w-12 h-12 min-w-12 min-h-12 cursor-pointer bg-white bg-opacity-10 border border-white border-opacity-20 p-2 rounded-lg ml-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg></button>
            </div>
        </form>
    </div>

    <div class="p-4 rounded-xl mx-auto border border-[#24324d] bg-[#101735] relative w-full h-full">
        <div class="mb-4 border-b-2 border-[#1d2753]">
            <ul class="incomeOverview_tab flex flex-nowrap -mb-px text-sm font-medium text-center overflow-auto" data-tabs-toggle="#default-tab-content" role="tablist">
                <!-- <li class="me-2" role="presentation">
                    <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-tab-0" data-tabs-target="#tab-0" type="button" role="tab" aria-controls="tab-0" aria-selected="false">Referral Income</button>
                </li> -->
                <li class="me-2" role="presentation">
                    <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-tab-1" data-tabs-target="#tab-1" type="button" role="tab" aria-controls="tab-1" aria-selected="false">Ads Income</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-tab-2" data-tabs-target="#tab-2" type="button" role="tab" aria-controls="tab-2" aria-selected="false">Group Income</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-tab-3" data-tabs-target="#tab-3" type="button" role="tab" aria-controls="tab-3" aria-selected="false">Director Club</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-tab-4" data-tabs-target="#tab-4" type="button" role="tab" aria-controls="tab-4" aria-selected="false">Referral Bonus</button>
                </li>
            </ul>
        </div>
        <div id="default-tab-content">
            <div class="hidden" id="tab-0" role="tabpanel" aria-labelledby="table-tab-0">
                <div class="overflow-x-auto">
                    <table id="tabledata0" class="w-full text-left border-collapse" style="padding-top: 15px;">
                        <thead>
                            <tr class="bg-white bg-opacity-10 text-white">
                                <th class="px-4 py-2">Sr.</th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Amount</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Tag</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Ads Viewed</span></th>
                                <th class="px-4 py-2 text-end"><span class="w-full block text-end">Date</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $srno = 1;
                            @endphp
                            @if(isset($data['earningLogs']))
                            @foreach ($data['earningLogs'] as $key => $value)
                            @if($value['tag'] == "REFERRAL")
                            <tr>
                                <td class="text-nowrap px-4 py-2">{{$srno++}}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ number_format($value['amount'], 2) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['tag'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['refrence'] / 0.25 }}</td>
                                <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">{{ date('d-m-Y', strtotime($value['created_on'])) }}</td>
                            </tr>
                            @endif
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="hidden" id="tab-1" role="tabpanel" aria-labelledby="table-tab-1">
                <div class="overflow-x-auto">
                    <table id="tabledata1" class="w-full text-left border-collapse" style="padding-top: 15px;">
                        <thead>
                            <tr class="bg-white bg-opacity-10 text-white">
                                <th class="px-4 py-2">Sr.</th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Tag</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Amount</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Package Amount</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Ads Viewed</span></th>
                                <th class="px-4 py-2 text-end"><span class="w-full block text-end">Date</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $srno = 1;
                                $totalAdsIncome = 0;
                            @endphp
                            @if(isset($data['earningLogs']))
                            @foreach ($data['earningLogs'] as $key => $value)
                            @if($value['tag'] == "ROI" || $value['tag'] == "REFERRAL")
                            <tr>
                                <td class="text-nowrap px-4 py-2">{{$srno++}}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['tag'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ number_format($value['amount'], 2) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">
                                    @if($value['tag'] == "ROI")
                                            {{ $data['userPlans'][$value['refrence_id']]}}
                                    @endif
                                </td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['refrence'] / 0.25 }}</td>
                                <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">{{ date('d-m-Y', strtotime($value['created_on'])) }}</td>
                            </tr>
                                @php 
                                    $totalAdsIncome += $value['amount'];
                                @endphp
                            @endif
                            @endforeach
                            @endif

                            @if($totalAdsIncome > 0)
                                <tr>
                                    <td class="text-nowrap px-4 py-2">{{$srno++}}</td>
                                    <td class="text-nowrap px-4 py-2 text-center">TOTAL</td>
                                    <td class="text-nowrap px-4 py-2 text-center">{{ $totalAdsIncome }}</td>
                                    <td class="text-nowrap px-4 py-2 text-center">-</td>
                                    <td class="text-nowrap px-4 py-2 text-center">-</td>
                                    <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">TOTAL</td>
                                </tr>
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
                                <th class="px-4 py-2">Sr.</th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Tag</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Amount</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Package Amount</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Referral Code</span></th>
                                <th class="px-4 py-2 text-end"><span class="w-full block text-end">Date</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $srno = 1;
                                $totalLevelIncome = 0;
                            @endphp
                            @if(isset($data['levelEarningLogs']))
                            @foreach ($data['levelEarningLogs'] as $key => $value)
                            <tr>
                                <td class="text-nowrap px-4 py-2">{{$srno++}}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['tag'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ number_format($value['amount'], 2) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $data['userPlans'][$value['refrence_id']]}}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['refrence'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">{{ date('d-m-Y', strtotime($value['created_on'])) }}</td>
                            </tr>
                            @php 
                                $totalLevelIncome += $value['amount'];
                            @endphp
                            @endforeach
                            @endif

                            @if($totalLevelIncome > 0)
                                <tr>
                                    <td class="text-nowrap px-4 py-2">{{$srno++}}</td>
                                    <td class="text-nowrap px-4 py-2 text-center">TOTAL</td>
                                    <td class="text-nowrap px-4 py-2 text-center">{{ $totalLevelIncome }}</td>
                                    <td class="text-nowrap px-4 py-2 text-center">-</td>
                                    <td class="text-nowrap px-4 py-2 text-center">-</td>
                                    <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">TOTAL</td>
                                </tr>
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
                                <th class="px-4 py-2">Sr.</th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Tag</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Amount</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Rank</span></th>
                                <th class="px-4 py-2 text-end"><span class="w-full block text-end">Date</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $srno = 1;
                                $totalRoyalIncome = 0;
                            @endphp
                            @if(isset($data['earningLogs']))
                            @foreach ($data['earningLogs'] as $key => $value)
                            @if($value['tag'] == "ROYALTY")
                            <tr>
                                <td class="text-nowrap px-4 py-2">{{$srno}}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['tag'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ number_format($value['amount'], 2) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['refrence'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">{{ date('d-m-Y', strtotime($value['created_on'])) }}</td>
                            </tr>
                            @php 
                                $totalRoyalIncome += $value['amount'];
                            @endphp
                            @endif
                            @endforeach
                            @endif

                            @if($totalRoyalIncome > 0)
                                <tr>
                                    <td class="text-nowrap px-4 py-2">{{$srno++}}</td>
                                    <td class="text-nowrap px-4 py-2 text-center">TOTAL</td>
                                    <td class="text-nowrap px-4 py-2 text-center">{{ $totalRoyalIncome }}</td>
                                    <td class="text-nowrap px-4 py-2 text-center">-</td>
                                    <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">TOTAL</td>
                                </tr>
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
                                <th class="px-4 py-2">Sr.</th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Tag</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Amount</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Rank</span></th>
                                <th class="px-4 py-2 text-end"><span class="w-full block text-end">Date</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $srno = 1;
                                $totalRankIncome = 0;
                            @endphp
                            @if(isset($data['earningLogs']))
                            @foreach ($data['earningLogs'] as $key => $value)
                            @if($value['tag'] == "REFERRAL-BONUS")
                            <tr>
                                <td class="text-nowrap px-4 py-2">{{$srno}}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['tag'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ number_format($value['amount'], 2) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['refrence'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">{{ date('d-m-Y', strtotime($value['created_on'])) }}</td>
                            </tr>
                                @php 
                                    $totalRankIncome += $value['amount'];
                                @endphp
                            @endif
                            @endforeach
                            @endif

                            @if($totalRankIncome > 0)
                                <tr>
                                    <td class="text-nowrap px-4 py-2">{{$srno++}}</td>
                                    <td class="text-nowrap px-4 py-2 text-center">TOTAL</td>
                                    <td class="text-nowrap px-4 py-2 text-center">{{ $totalRankIncome }}</td>
                                    <td class="text-nowrap px-4 py-2 text-center">-</td>
                                    <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">TOTAL</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- <div class="hidden" id="tab-4" role="tabpanel" aria-labelledby="table-tab-4">
                <div class="overflow-x-auto">
                    <table id="tabledata4" class="w-full text-left border-collapse" style="padding-top: 15px;">
                        <thead>
                            <tr class="bg-white bg-opacity-10 text-white">
                                <th class="px-4 py-2">Sr.</th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Tag</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Amount</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Rank</span></th>
                                <th class="px-4 py-2 text-end"><span class="w-full block text-end">Date</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            php
                                $srno = 1;
                                $totalRankIncome = 0;
                            endphp
                            if(isset($data['earningLogs']))
                            foreach ($data['earningLogs'] as $key => $value)
                            if($value['tag'] == "RANK-BONUS")
                            <tr>
                                <td class="text-nowrap px-4 py-2">{{$srno}}</td>
                                {{--<td class="text-nowrap px-4 py-2 text-center">{{ $value['tag'] }}</td>--}}
                                {{--<td class="text-nowrap px-4 py-2 text-center">{{ number_format($value['amount'], 2) }}</td>--}}
                                {{--<td class="text-nowrap px-4 py-2 text-center">{{ $value['refrence'] }}</td>--}}
                                {{--<td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">{{ date('d-m-Y', strtotime($value['created_on'])) }}</td>--}}
                            </tr>
                                php 
                                    {{--$totalRankIncome += $value['amount'];--}}
                                endphp
                            endif
                            endforeach
                            endif

                            if($totalRankIncome > 0)
                                <tr>
                                    <td class="text-nowrap px-4 py-2">{{$srno++}}</td>
                                    <td class="text-nowrap px-4 py-2 text-center">TOTAL</td>
                                    <td class="text-nowrap px-4 py-2 text-center">{{ $totalRankIncome }}</td>
                                    <td class="text-nowrap px-4 py-2 text-center">-</td>
                                    <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">TOTAL</td>
                                </tr>
                            endif
                        </tbody>
                    </table>
                </div>
            </div> -->
        </div>
    </div>
</section>
<script>
    document.getElementById('datepicker-range-start').addEventListener('click', function () {
        this.showPicker && this.showPicker(); // Works in most modern browsers
    });
    document.getElementById('datepicker-range-end').addEventListener('click', function () {
        this.showPicker && this.showPicker(); // Works in most modern browsers
    });
         document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('[data-tabs-target]');
        const groupDateRange = document.getElementById('level-select');

        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                // Check if the clicked tab targets "#tab-2"
                if (tab.getAttribute('data-tabs-target') === '#tab-2') {
                    groupDateRange.style.display = 'block';
                } else {
                    groupDateRange.style.display = 'none';
                }
            });
        });

        // Optional: show on page load if tab-2 is already active
        const activeTab = document.querySelector('[aria-selected="true"]');
        if (activeTab && activeTab.getAttribute('data-tabs-target') === '#tab-2') {
            groupDateRange.style.display = 'block';
        }
    });
</script>
@endsection