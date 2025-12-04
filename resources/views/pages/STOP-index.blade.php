@extends('layouts.app')
@section('title', 'Home')

@section('content')
<section class="w-full p-3 md:p-8 mx-auto max-w-[1400px]">
    <div class="grid grid-cols-1 gap-5 relative z-10">
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
            <!-- Referral Link Card -->
            <div class="relative rounded-md flex items-center justify-center">
                <div class="flex items-center space-x-3 w-full border border-[#24324d] bg-[#101735] rounded-md p-4">
                    <img src={{ asset('assets/images/logoface.webp') }} width="64" height="48" alt="Logo" class="border border-[#265e8c] w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full" style="max-width:calc(100% - 60px)">
                        <h3 class="text-base leading-none my-3">TruePoints Referral Link</h3>
                        <div class="bg-white bg-opacity-5 px-2 py-0.5 leading-none rounded flex items-center justify-between overflow-auto">
                            <span id="referral-link" class="text-xs text-xs truncate text-ellipsis overflow-auto" style="text-overflow: unset;overflow: auto;">https://{{ request()->getHost() }}/register?sponser_code=@if(Session::has('refferal_code')){{ Session::get('refferal_code')}}@endif</span>
                            <button onclick="copyReferral(); showToast('success', 'Copied to clipboard!')" class="ml-2 p-1 border-l border-white border-opacity-20">
                                <svg class="w-6 h-6 min-w-6 min-h-6 ml-2" viewBox="0 0 1024 1024">
                                    <path fill="#ffffff" d="M768 832a128 128 0 0 1-128 128H192A128 128 0 0 1 64 832V384a128 128 0 0 1 128-128v64a64 64 0 0 0-64 64v448a64 64 0 0 0 64 64h448a64 64 0 0 0 64-64h64z" />
                                    <path fill="#ffffff" d="M384 128a64 64 0 0 0-64 64v448a64 64 0 0 0 64 64h448a64 64 0 0 0 64-64V192a64 64 0 0 0-64-64H384zm0-64h448a128 128 0 0 1 128 128v448a128 128 0 0 1-128 128H384a128 128 0 0 1-128-128V192A128 128 0 0 1 384 64z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function copyReferral() {
                    const linkElement = document.getElementById("referral-link");

                    if (!linkElement) {
                        console.error("Referral link element not found!");
                        return;
                    }

                    const link = linkElement.innerText;
                    navigator.clipboard.writeText(link).catch(() => {
                        console.error("Failed to copy text!");
                    });
                }
            </script>
            <!-- Download PDF -->
            <div class="relative rounded-md flex items-center justify-center">
                <div class="flex items-center space-x-3 w-full border border-[#24324d] bg-[#101735] rounded-md p-4">
                    <img src={{ asset('assets/images/icons/download-pdf-icon.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full">
                        <h3 class="text-base leading-none my-3">Download PDF</h3>
                        <div class="bg-white bg-opacity-5 px-2 py-0.5 leading-none rounded flex items-center justify-between">
                            <span class="text-xs">Download TruePoints Presentation</span>
                            <a href="{{ asset('assets/pdf/True-Points.pdf') }}?v={{time()}}" download="True-Points.pdf" target="_blank" onclick="showToast('success', 'PDF download successfully!')" class="ml-2 p-1 border-l border-white border-opacity-20">
                                <svg class="w-6 h-6 min-w-6 min-h-6 ml-2" viewBox="0 0 24 24" fill="none">
                                    <path d="M12.5535 16.5061C12.4114 16.6615 12.2106 16.75 12 16.75C11.7894 16.75 11.5886 16.6615 11.4465 16.5061L7.44648 12.1311C7.16698 11.8254 7.18822 11.351 7.49392 11.0715C7.79963 10.792 8.27402 10.8132 8.55352 11.1189L11.25 14.0682V3C11.25 2.58579 11.5858 2.25 12 2.25C12.4142 2.25 12.75 2.58579 12.75 3V14.0682L15.4465 11.1189C15.726 10.8132 16.2004 10.792 16.5061 11.0715C16.8118 11.351 16.833 11.8254 16.5535 12.1311L12.5535 16.5061Z" fill="#ffffff" />
                                    <path d="M3.75 15C3.75 14.5858 3.41422 14.25 3 14.25C2.58579 14.25 2.25 14.5858 2.25 15V15.0549C2.24998 16.4225 2.24996 17.5248 2.36652 18.3918C2.48754 19.2919 2.74643 20.0497 3.34835 20.6516C3.95027 21.2536 4.70814 21.5125 5.60825 21.6335C6.47522 21.75 7.57754 21.75 8.94513 21.75H15.0549C16.4225 21.75 17.5248 21.75 18.3918 21.6335C19.2919 21.5125 20.0497 21.2536 20.6517 20.6516C21.2536 20.0497 21.5125 19.2919 21.6335 18.3918C21.75 17.5248 21.75 16.4225 21.75 15.0549V15C21.75 14.5858 21.4142 14.25 21 14.25C20.5858 14.25 20.25 14.5858 20.25 15C20.25 16.4354 20.2484 17.4365 20.1469 18.1919C20.0482 18.9257 19.8678 19.3142 19.591 19.591C19.3142 19.8678 18.9257 20.0482 18.1919 20.1469C17.4365 20.2484 16.4354 20.25 15 20.25H9C7.56459 20.25 6.56347 20.2484 5.80812 20.1469C5.07435 20.0482 4.68577 19.8678 4.40901 19.591C4.13225 19.3142 3.9518 18.9257 3.85315 18.1919C3.75159 17.4365 3.75 16.4354 3.75 15Z" fill="#ffffff" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            
            <div class="relative rounded-md flex items-center justify-center">
                <div class="flex items-center space-x-3 w-full border border-[#24324d] bg-gradient-to-t from-[#265e8c] via-[#255480] to-[#243f82] rounded-md p-4">
                    <img src={{ asset('assets/images/icons/date-of-activation.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full">
                        <h3 class="text-base leading-none my-3">Date</h3>
                        <span>{{date('d-m-Y')}}</span>
                    </div>
                </div>
            </div>
            <div class="relative rounded-md flex items-center justify-center">
                <div class="flex items-center space-x-3 w-full border border-[#24324d] bg-gradient-to-t from-[#265e8c] via-[#255480] to-[#243f82] rounded-md p-4">
                    <img src={{ asset('assets/images/icons/ads.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full">
                        <h3 class="text-base leading-none my-3">Ads ROI</h3>
                        @if($data['self_investment'] > 0)
                            <span id="ad_percent">{{($data['user']['ad_viewed'] * 0.25)}}%</span>
                        @else
                            <span>0.0%</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="relative rounded-md flex items-center justify-center">
                <div class="flex items-center space-x-3 w-full border border-[#24324d] bg-gradient-to-t from-[#265e8c] via-[#255480] to-[#243f82] rounded-md p-4">
                    <img src={{ asset('assets/images/icons/timericon.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full">
                        <h3 class="text-base leading-none my-3">Timer 24/7</h3>
                        <span class="your-timer-class">-</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
            <div class="grid-cols-1 grid gap-5">
                <div class="p-4 md:p-6 rounded-xl w-full mx-auto border border-[#24324d] bg-[#101735] relative overflow-hidden text-left">
                    <h5 class="text-lg font-normal leading-none text-white pe-1">Group</h5>

                    <!-- Radial Chart -->
                    <div id="radial-chart"></div>
                </div>
                <script>
                    const getChartOptions = () => {
                        const actualSeries = [{{$data['user']['active_direct']}}, {{$data['user']['active_direct']}}, {{$data['user']['active_direct']}}]; // move this outside so formatter can access
                        const wantSeries = [5, 6, 7];
                        return {
                            series: [{{$data['group_a']}}, {{$data['group_b']}}, {{$data['group_c']}}],
                            actualSeries: actualSeries,
                            colors: ["#1C64F2", "#16BDCA", "#FDBA8C"],
                            chart: {
                                height: "300px",
                                width: "100%",
                                type: "radialBar",
                                sparkline: {
                                    enabled: true,
                                },
                            },
                            plotOptions: {
                                radialBar: {
                                    track: {
                                        background: '#E5E7EB',
                                    },
                                    dataLabels: {
                                        show: false,
                                    },
                                    hollow: {
                                        margin: 0,
                                        size: "32%",
                                    }
                                },
                            },
                            labels: ["Group A", "Group B", "Group C"],
                            legend: {
                                show: true,
                                position: "bottom",
                                fontFamily: "Inter, sans-serif",
                                bottom: 20,
                            },
                            tooltip: {
                                enabled: true,
                                x: {
                                    show: false,
                                },
                            },
                            yaxis: {
                                show: false,
                                labels: {
                                    formatter: function(value, {
                                        seriesIndex
                                    }) {
                                        return "Directs " + actualSeries[seriesIndex];
                                    }
                                }
                            }
                        }
                    }


                    if (document.getElementById("radial-chart") && typeof ApexCharts !== 'undefined') {
                        const chart = new ApexCharts(document.querySelector("#radial-chart"), getChartOptions());
                        chart.render();
                    }
                </script>
            </div>
            <div class="grid-cols-1 grid gap-5">
                <div class="p-4 md:p-6 rounded-xl w-full mx-auto border border-[#2396b9] border-opacity-30 bg-[#101735] relative overflow-hidden text-center">
                    <div class="flex items-center justify-between mb-4 text-left">
                        <div>
                            <h5 class="text-lg font-normal leading-none text-white pe-1">Daily Ads</h5>
                        </div>
                    </div>
                    <div class="mt-4 grid sm:grid-cols-2 gap-4 text-left">
                        <div class="p-4 rounded-xl w-full mx-auto border border-[#ffffff] border-opacity-10 overflow-hidden relative flex items-center gap-2 text-white md:flex-row md:items-center">
                            <div class="w-max rounded-lg p-px text-white relative">
                                <img src="{{ $data['user']['ad_viewed'] == 0 ? asset('assets/images/wrong-icon.svg') : asset('assets/images/right-icon.svg') }}" width="64" height="48" alt="Logo" class="w-6 min-w-6 min-h-6 h-auto max-h-6 bg-[#101735] bg-opacity-35 p-1.5 rounded-full" id="ad-img-1">
                            </div>
                            <div>
                                <h6 class="block font-sans text-base leading-relaxed tracking-normal leading-none mb-0">
                                    Packages Ads
                                </h6>
                            </div>
                        </div>
                        <div class="p-4 rounded-xl w-full mx-auto border border-[#ffffff] border-opacity-10 overflow-hidden relative flex items-center gap-2 text-white md:flex-row md:items-center">
                            <div class="w-max rounded-lg p-px text-white relative">
                                <img src="{{ $data['user']['ad_viewed'] < 2 ? asset('assets/images/wrong-icon.svg') : asset('assets/images/right-icon.svg') }}" width="64" height="48" alt="Logo" class="w-6 min-w-6 min-h-6 h-auto max-h-6 bg-[#101735] bg-opacity-35 p-1.5 rounded-full" id="ad-img-2">
                            </div>
                            <div>
                                <h6 class="block font-sans text-base leading-relaxed tracking-normal leading-none mb-0">
                                    Packages Ads
                                </h6>
                            </div>
                        </div>
                        @if($data['user']['active_direct']>= 1)
                        <div class="p-4 rounded-xl w-full mx-auto border border-[#ffffff] border-opacity-10 overflow-hidden relative flex items-center gap-2 text-white md:flex-row md:items-center">
                            <div class="w-max rounded-lg p-px text-white relative">
                                <img src="{{ $data['user']['ad_viewed'] < 3 ? asset('assets/images/wrong-icon.svg') : asset('assets/images/right-icon.svg') }}" width="64" height="48" alt="Logo" class="w-6 min-w-6 min-h-6 h-auto max-h-6 bg-[#101735] bg-opacity-35 p-1.5 rounded-full" id="ad-img-3">
                            </div>
                            <div>
                                <h6 class="block font-sans text-base leading-relaxed tracking-normal leading-none mb-0">
                                    1st Refferal
                                </h6>
                            </div>
                        </div>
                        @endif
                        @if($data['user']['active_direct']>= 2)
                        <div class="p-4 rounded-xl w-full mx-auto border border-[#ffffff] border-opacity-10 overflow-hidden relative flex items-center gap-2 text-white md:flex-row md:items-center">
                            <div class="w-max rounded-lg p-px text-white relative">
                                <img src="{{ $data['user']['ad_viewed'] < 4 ? asset('assets/images/wrong-icon.svg') : asset('assets/images/right-icon.svg') }}" width="64" height="48" alt="Logo" class="w-6 min-w-6 min-h-6 h-auto max-h-6 bg-[#101735] bg-opacity-35 p-1.5 rounded-full" id="ad-img-4">
                            </div>
                            <div>
                                <h6 class="block font-sans text-base leading-relaxed tracking-normal leading-none mb-0">
                                    2nd Refferal
                                </h6>
                            </div>
                        </div>
                        @endif
                        @if($data['user']['active_direct']>= 3)
                        <div class="p-4 rounded-xl w-full mx-auto border border-[#ffffff] border-opacity-10 overflow-hidden relative flex items-center gap-2 text-white md:flex-row md:items-center">
                            <div class="w-max rounded-lg p-px text-white relative">
                                <img src="{{ $data['user']['ad_viewed'] < 5 ? asset('assets/images/wrong-icon.svg') : asset('assets/images/right-icon.svg') }}" width="64" height="48" alt="Logo" class="w-6 min-w-6 min-h-6 h-auto max-h-6 bg-[#101735] bg-opacity-35 p-1.5 rounded-full" id="ad-img-5">
                            </div>
                            <div>
                                <h6 class="block font-sans text-base leading-relaxed tracking-normal leading-none mb-0">
                                    3rd Refferal
                                </h6>
                            </div>
                        </div>
                        @endif
                        @if($data['user']['active_direct']>= 4)
                        <div class="p-4 rounded-xl w-full mx-auto border border-[#ffffff] border-opacity-10 overflow-hidden relative flex items-center gap-2 text-white md:flex-row md:items-center">
                            <div class="w-max rounded-lg p-px text-white relative">
                                <img src="{{ $data['user']['ad_viewed'] < 6 ? asset('assets/images/wrong-icon.svg') : asset('assets/images/right-icon.svg') }}" width="64" height="48" alt="Logo" class="w-6 min-w-6 min-h-6 h-auto max-h-6 bg-[#101735] bg-opacity-35 p-1.5 rounded-full" id="ad-img-6">
                            </div>
                            <div>
                                <h6 class="block font-sans text-base leading-relaxed tracking-normal leading-none mb-0">
                                    4th Refferal
                                </h6>
                            </div>
                        </div>
                        @endif
                        @if($data['user']['active_direct']>= 5)
                        <div class="p-4 rounded-xl w-full mx-auto border border-[#ffffff] border-opacity-10 overflow-hidden relative flex items-center gap-2 text-white md:flex-row md:items-center">
                            <div class="w-max rounded-lg p-px text-white relative">
                                <img src="{{ $data['user']['ad_viewed'] < 7 ? asset('assets/images/wrong-icon.svg') : asset('assets/images/right-icon.svg') }}" width="64" height="48" alt="Logo" class="w-6 min-w-6 min-h-6 h-auto max-h-6 bg-[#101735] bg-opacity-35 p-1.5 rounded-full" id="ad-img-7">
                            </div>
                            <div>
                                <h6 class="block font-sans text-base leading-relaxed tracking-normal leading-none mb-0">
                                    5th Refferal
                                </h6>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($data['self_investment'] == 0)
                        <button onclick="showToast('error', 'Please activate package to view ADS.');" class="px-4 py-1 text-white buttonbg mx-auto flex items-center text-base capitalize tracking-wider mt-6">
                            <span class="w-full">View Ads</span>
                        </button>
                    @else
                        @if($data['activationHours'] >= 6)
                            <button id="viewAdsBtn" class="px-4 py-1 text-white buttonbg mx-auto flex items-center text-base capitalize tracking-wider mt-6">
                                <span class="w-full">View Ads</span>
                            </button>
                        @else
                            <button onclick="showToast('error', 'You can view ADS after 6 hours of activation.');" class="px-4 py-1 text-white buttonbg mx-auto flex items-center text-base capitalize tracking-wider mt-6">
                                <span class="w-full">View Ads</span>
                            </button>
                        @endif
                    @endif
                </div>
            </div>
            <div class="grid-cols-1 grid gap-5">
                <div class="p-4 md:p-6 rounded-xl w-full mx-auto border border-[#24324d] bg-[#101735] relative overflow-hidden text-left">
                    @include('components.pie-charts')
                </div>
            </div>
        </div>
        @include('components.ranking-slider')
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="relative rounded-md flex items-center justify-center">
                <div class="flex items-center space-x-3 w-full border border-[#24324d] bg-[#101735] rounded-md p-4">
                    <img src={{ asset('assets/images/icons/ads.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full">
                        <h3 class="text-base leading-none my-3">Ads Wallet</h3>
                        <span>{{number_format($data['user']['roi_income'], 2)}}</span>
                    </div>
                </div>
            </div>
            <div class="relative rounded-md flex items-center justify-center">
                <div class="flex items-center space-x-3 w-full border border-[#24324d] bg-[#101735] rounded-md p-4">
                    <img src={{ asset('assets/images/icons/referral.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full">
                        <h3 class="text-base leading-none my-3">Referral Wallet</h3>
                        <span>{{number_format($data['user']['direct_income'], 2)}}</span>
                    </div>
                </div>
            </div>
            <div class="relative rounded-md flex items-center justify-center">
                <div class="flex items-center space-x-3 w-full border border-[#24324d] bg-[#101735] rounded-md p-4">
                    <img src={{ asset('assets/images/icons/group.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full">
                        <h3 class="text-base leading-none my-3">Group Wallet</h3>
                        <span>{{number_format($data['user']['level_income'], 2)}}</span>
                    </div>
                </div>
            </div>
            <div class="relative rounded-md flex items-center justify-center">
                <div class="flex items-center space-x-3 w-full border border-[#24324d] bg-[#101735] rounded-md p-4">
                    <img src={{ asset('assets/images/icons/directer.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full">
                        <h3 class="text-base leading-none my-3">Director Wallet</h3>
                        <span>{{number_format($data['user']['reward'], 2)}}</span>
                    </div>
                </div>
            </div>
            <div class="relative rounded-md flex items-center justify-center">
                <div class="flex items-center space-x-3 w-full border border-[#24324d] bg-[#101735] rounded-md p-4">
                    <img src={{ asset('assets/images/icons/referral-bonus.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full">
                        <h3 class="text-base leading-none my-3">Referral Bonus</h3>
                        <span>{{number_format($data['user']['referral_bonus'], 2)}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
            <div class="cols-span-1 grid gap-5 grid-cols-1">
                <div class="grid grid-cols-1 gap-5">
                    <div class="cols-span-1 grid gap-5 grid-cols-1">
                        <div class="p-4 md:p-6 rounded-xl w-full mx-auto border border-[#24324d] bg-[#101735] relative overflow-hidden text-left">
                            @include('components.trading-table')
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid-cols-1 grid gap-5">
                <div class="p-4 rounded-xl mx-auto border border-[#24324d] bg-[#101735] relative w-full h-full">
                    <div class="mb-4 border-b-2 border-[#1d2753]">
                        <ul class="incomeOverview_tab flex flex-nowrap -mb-px text-sm font-medium text-center overflow-auto" data-tabs-toggle="#default-tab-content" role="tablist">
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-tab-0" data-tabs-target="#tab-0" type="button" role="tab" aria-controls="tab-0" aria-selected="false">Refferal</button>
                            </li>
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-tab-1" data-tabs-target="#tab-1" type="button" role="tab" aria-controls="tab-1" aria-selected="false">Group</button>
                            </li>
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-tab-2" data-tabs-target="#tab-2" type="button" role="tab" aria-controls="tab-2" aria-selected="false">Director Club</button>
                            </li>
                        </ul>
                    </div>
                    <div id="default-tab-content">
                        <div class="hidden" id="tab-0" role="tabpanel" aria-labelledby="table-tab-0">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse" style="padding-top: 15px;">
                                    <thead>
                                        <tr class="bg-white bg-opacity-10 text-white">
                                            <th class="px-4 py-2">Refferal</th>
                                            <th class="px-4 py-2">Ads</th>
                                            <th class="px-4 py-2">Ads Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr @if($data['user']['active_direct']>= 1) class="bg-[#265e8c]" @endif>
                                            <td class="text-nowrap px-4 py-2">1</td>
                                            <td class="text-nowrap px-4 py-2">1</td>
                                            <td class="text-nowrap px-4 py-2">0.25%</td>
                                        </tr>
                                        <tr @if($data['user']['active_direct']>= 2) class="bg-[#265e8c]" @endif>
                                            <td class="text-nowrap px-4 py-2">2</td>
                                            <td class="text-nowrap px-4 py-2">1</td>
                                            <td class="text-nowrap px-4 py-2">0.25%</td>
                                        </tr>
                                        <tr @if($data['user']['active_direct']>= 3) class="bg-[#265e8c]" @endif>
                                            <td class="text-nowrap px-4 py-2">3</td>
                                            <td class="text-nowrap px-4 py-2">1</td>
                                            <td class="text-nowrap px-4 py-2">0.25%</td>
                                        </tr>
                                        <tr @if($data['user']['active_direct']>= 4) class="bg-[#265e8c]" @endif>
                                            <td class="text-nowrap px-4 py-2">4</td>
                                            <td class="text-nowrap px-4 py-2">1</td>
                                            <td class="text-nowrap px-4 py-2">0.25%</td>
                                        </tr>
                                        <tr @if($data['user']['active_direct']>= 5) class="bg-[#265e8c]" @endif>
                                            <td class="text-nowrap px-4 py-2">5</td>
                                            <td class="text-nowrap px-4 py-2">1</td>
                                            <td class="text-nowrap px-4 py-2">0.25%</td>
                                        </tr>
                                        <tr @if($data['user']['active_direct']>= 6) class="bg-[#265e8c]" @endif>
                                            <td class="text-nowrap px-4 py-2">6</td>
                                            <td class="text-nowrap px-4 py-2">0</td>
                                            <td class="text-nowrap px-4 py-2">0%</td>
                                        </tr>
                                        <tr @if($data['user']['active_direct']>= 7) class="bg-[#265e8c]" @endif>
                                            <td class="text-nowrap px-4 py-2">7</td>
                                            <td class="text-nowrap px-4 py-2">0</td>
                                            <td class="text-nowrap px-4 py-2">0%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="hidden" id="tab-1" role="tabpanel" aria-labelledby="table-tab-1">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse" style="padding-top: 15px;">
                                    <tbody>
                                        <tr>
                                            <td class="text-nowrap px-1 py-0">
                                                <table class="w-full text-left border-collapse" style="padding-top: 15px;">
                                                    <thead>
                                                        <tr class="bg-white bg-opacity-10 text-white">
                                                            <th colspan="3" align="center" class="px-1 font-semibold py-1">Group A</th>
                                                        </tr>
                                                        <tr class="bg-white bg-opacity-10 text-white">
                                                            <th class="px-1 py-2 font-normal">Level</th>
                                                            <th class="px-1 py-2 font-normal">Direct</th>
                                                            <th class="px-1 py-2 font-normal">Income</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr @if($data['user']['active_direct']==1) class="bg-[#265e8c]" @endif>
                                                            <td class="text-nowrap px-1 py-2">L1</td>
                                                            <td class="text-nowrap px-1 py-2">1</td>
                                                            <td class="text-nowrap px-1 py-2">10%</td>
                                                        </tr>
                                                        <tr @if($data['user']['active_direct']==2) class="bg-[#265e8c]" @endif>
                                                            <td class="text-nowrap px-1 py-2">L2</td>
                                                            <td class="text-nowrap px-1 py-2">2</td>
                                                            <td class="text-nowrap px-1 py-2">10%</td>
                                                        </tr>
                                                        <tr @if($data['user']['active_direct']==3) class="bg-[#265e8c]" @endif>
                                                            <td class="text-nowrap px-1 py-2">L3</td>
                                                            <td class="text-nowrap px-1 py-2">3</td>
                                                            <td class="text-nowrap px-1 py-2">10%</td>
                                                        </tr>
                                                        <tr @if($data['user']['active_direct']==4) class="bg-[#265e8c]" @endif>
                                                            <td class="text-nowrap px-1 py-2">L4</td>
                                                            <td class="text-nowrap px-1 py-2">4</td>
                                                            <td class="text-nowrap px-1 py-2">10%</td>
                                                        </tr>
                                                        <tr @if($data['user']['active_direct']==5) class="bg-[#265e8c]" @endif>
                                                            <td class="text-nowrap px-1 py-2">L5</td>
                                                            <td class="text-nowrap px-1 py-2">5</td>
                                                            <td class="text-nowrap px-1 py-2">10%</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td class="text-nowrap px-1 py-0">
                                                <table class="w-full text-left border-collapse" style="padding-top: 15px;">
                                                    <thead>
                                                        <tr class="bg-white bg-opacity-10 text-white">
                                                            <th colspan="3" align="center" class="px-1 font-semibold py-1">Group B</th>
                                                        </tr>
                                                        <tr class="bg-white bg-opacity-10 text-white">
                                                            <th class="px-1 py-2 font-normal">Level</th>
                                                            <th class="px-1 py-2 font-normal">Direct</th>
                                                            <th class="px-1 py-2 font-normal">Income</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr @if($data['user']['active_direct']==6) class="bg-[#265e8c]" @endif>
                                                            <td class="text-nowrap px-1 py-2">L6</td>
                                                            <td class="text-nowrap px-1 py-2">6</td>
                                                            <td class="text-nowrap px-1 py-2">15%</td>
                                                        </tr>
                                                        <tr @if($data['user']['active_direct']==6) class="bg-[#265e8c]" @endif>
                                                            <td class="text-nowrap px-1 py-2">L7</td>
                                                            <td class="text-nowrap px-1 py-2">6</td>
                                                            <td class="text-nowrap px-1 py-2">15%</td>
                                                        </tr>
                                                        <tr @if($data['user']['active_direct']==6) class="bg-[#265e8c]" @endif>
                                                            <td class="text-nowrap px-1 py-2">L8</td>
                                                            <td class="text-nowrap px-1 py-2">6</td>
                                                            <td class="text-nowrap px-1 py-2">15%</td>
                                                        </tr>
                                                        <tr @if($data['user']['active_direct']==6) class="bg-[#265e8c]" @endif>
                                                            <td class="text-nowrap px-1 py-2">L9</td>
                                                            <td class="text-nowrap px-1 py-2">6</td>
                                                            <td class="text-nowrap px-1 py-2">15%</td>
                                                        </tr>
                                                        <tr @if($data['user']['active_direct']==6) class="bg-[#265e8c]" @endif>
                                                            <td class="text-nowrap px-1 py-2">L10</td>
                                                            <td class="text-nowrap px-1 py-2">6</td>
                                                            <td class="text-nowrap px-1 py-2">15%</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td class="text-nowrap px-1 py-0">
                                                <table class="w-full text-left border-collapse" style="padding-top: 15px;">
                                                    <thead>
                                                        <tr class="bg-white bg-opacity-10 text-white">
                                                            <th colspan="3" align="center" class="px-1 font-semibold py-1">Group C</th>
                                                        </tr>
                                                        <tr class="bg-white bg-opacity-10 text-white">
                                                            <th class="px-1 py-2 font-normal">Level</th>
                                                            <th class="px-1 py-2 font-normal">Direct</th>
                                                            <th class="px-1 py-2 font-normal">Income</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr @if($data['user']['active_direct']==7) class="bg-[#265e8c]" @endif>
                                                            <td class="text-nowrap px-1 py-2">L11</td>
                                                            <td class="text-nowrap px-1 py-2">7</td>
                                                            <td class="text-nowrap px-1 py-2">25%</td>
                                                        </tr>
                                                        <tr @if($data['user']['active_direct']==7) class="bg-[#265e8c]" @endif>
                                                            <td class="text-nowrap px-1 py-2">L12</td>
                                                            <td class="text-nowrap px-1 py-2">7</td>
                                                            <td class="text-nowrap px-1 py-2">25%</td>
                                                        </tr>
                                                        <tr @if($data['user']['active_direct']==7) class="bg-[#265e8c]" @endif>
                                                            <td class="text-nowrap px-1 py-2">L13</td>
                                                            <td class="text-nowrap px-1 py-2">7</td>
                                                            <td class="text-nowrap px-1 py-2">25%</td>
                                                        </tr>
                                                        <tr @if($data['user']['active_direct']==7) class="bg-[#265e8c]" @endif>
                                                            <td class="text-nowrap px-1 py-2">L14</td>
                                                            <td class="text-nowrap px-1 py-2">7</td>
                                                            <td class="text-nowrap px-1 py-2">25%</td>
                                                        </tr>
                                                        <tr @if($data['user']['active_direct']==7) class="bg-[#265e8c]" @endif>
                                                            <td class="text-nowrap px-1 py-2">L15</td>
                                                            <td class="text-nowrap px-1 py-2">7</td>
                                                            <td class="text-nowrap px-1 py-2">25%</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="hidden" id="tab-2" role="tabpanel" aria-labelledby="table-tab-2">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse" style="padding-top: 15px;">
                                    <thead>
                                        <tr class="bg-white bg-opacity-10 text-white">
                                            <th class="px-4 py-2">Active Nft</th>
                                            <th class="px-4 py-2">Team Business</th>
                                            <th class="px-4 py-2">Ads Stream</th>
                                            <th class="px-4 py-2">Rewards</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-nowrap px-4 py-2">$500</td>
                                            <td class="text-nowrap px-4 py-2">$50,000</td>
                                            <td class="text-nowrap px-4 py-2">100,000</td>
                                            <td class="text-nowrap px-4 py-2">$2500</td>
                                        </tr>
                                        <tr>
                                            <td class="text-nowrap px-4 py-2">$1000</td>
                                            <td class="text-nowrap px-4 py-2">$100,000</td>
                                            <td class="text-nowrap px-4 py-2">200,000</td>
                                            <td class="text-nowrap px-4 py-2">$5000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-nowrap px-4 py-2">$2000</td>
                                            <td class="text-nowrap px-4 py-2">$250,000</td>
                                            <td class="text-nowrap px-4 py-2">500,000</td>
                                            <td class="text-nowrap px-4 py-2">$12500</td>
                                        </tr>
                                        <tr>
                                            <td class="text-nowrap px-4 py-2">$5000</td>
                                            <td class="text-nowrap px-4 py-2">$500,000</td>
                                            <td class="text-nowrap px-4 py-2">10,000,00</td>
                                            <td class="text-nowrap px-4 py-2">$30000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
            <div class="grid grid-cols-2 gap-5">
                <div class="p-4 rounded-xl w-full mx-auto border border-[#ffffff] border-opacity-20 bg-gradient-to-t from-[#265e8c] via-[#255480] to-[#243f82] overflow-hidden relative">
                    <img src={{ asset('assets/images/icons/total-withdraw-icon.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full">
                        <h3 class="text-sm sm:text-base my-4 opacity-75 leading-none">Total Withdraw</h3>
                        <span class="text-sm sm:text-base">${{$data['total_withdraw']}}</span>
                    </div>
                </div>
                <div class="p-4 rounded-xl w-full mx-auto border border-[#ffffff] border-opacity-20 bg-gradient-to-t from-[#265e8c] via-[#255480] to-[#243f82] overflow-hidden relative">
                    <img src={{ asset('assets/images/icons/self-investment.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full">
                        <h3 class="text-sm sm:text-base my-4 opacity-75 leading-none">Self Investment</h3>
                        <span class="text-sm sm:text-base">${{$data['self_investment']}}</span>
                    </div>
                </div>
                <div class="p-4 rounded-xl w-full mx-auto border border-[#ffffff] border-opacity-20 bg-gradient-to-t from-[#265e8c] via-[#255480] to-[#243f82] overflow-hidden relative">
                    <img src={{ asset('assets/images/icons/team-investment.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full">
                        <h3 class="text-sm sm:text-base my-4 opacity-75 leading-none">Total Team Investment</h3>
                        <span class="text-sm sm:text-base">${{number_format($data['user']['my_business'], 2)}}</span>
                    </div>
                </div>
                <div class="p-4 rounded-xl w-full mx-auto border border-[#ffffff] border-opacity-20 bg-gradient-to-t from-[#265e8c] via-[#255480] to-[#243f82] overflow-hidden relative">
                    <img src={{ asset('assets/images/icons/direct-investment.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full">
                        <h3 class="text-sm sm:text-base my-4 opacity-75 leading-none">Direct Investment</h3>
                        <span class="text-sm sm:text-base">${{number_format($data['user']['direct_business'], 2)}}</span>
                    </div>
                </div>
            </div>
            <div class="grid-cols-1 grid relative">
                <div class="w-full relative z-10 p-5 p-4 rounded-2xl mx-auto border border-[#24324d] bg-[#101735] overflow-hidden space-y-4">
                    <div class="grid grid-cols-2 gap-5">
                        <div class="p-4 mx-auto levelboxbig text-center text-white relative flex flex-col gap-1 items-center justify-center ">
                            <img src={{ asset('assets/images/icons/total-team.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                            <div class="w-full">
                                <h3 class="text-sm sm:text-base mb-1 mt-2 opacity-75 leading-none">Team</h3>
                                <span class="text-sm sm:text-base">{{$data['user']['my_team']}}</span>
                            </div>
                        </div>
                        <div class="p-4 mx-auto levelboxbig text-center text-white relative flex flex-col gap-1 items-center justify-center ">
                            <img src={{ asset('assets/images/icons/total-income-icon.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                            <div class="w-full">
                                <h3 class="text-sm sm:text-base mb-1 mt-2 opacity-75 leading-none">Income</h3>
                                <span class="text-sm sm:text-base">{{number_format($data['user']['roi_income'] + $data['user']['level_income'] + $data['user']['royalty'] + $data['user']['reward'] + $data['user']['direct_income'] + $data['user']['referral_bonus'],2)}}</span>
                            </div>
                        </div>
                        <div class="p-4 mx-auto levelboxbig text-center text-white relative flex flex-col gap-1 items-center justify-center ">
                            <img src={{ asset('assets/images/income-icons/total-invest.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                            <div class="w-full">
                                <h3 class="text-sm sm:text-base mb-1 mt-2 opacity-75 leading-none">Balance</h3>
                                <span class="text-sm sm:text-base">{{ number_format($data['available_balance'], 2) }}</span>
                            </div>
                        </div>
                        <div class="p-4 mx-auto levelboxbig text-center text-white relative flex flex-col gap-1 items-center justify-center ">
                            <img src={{ asset('assets/images/income-icons/level-income.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                            <div class="w-full">
                                <h3 class="text-sm sm:text-base mb-1 mt-2 opacity-75 leading-none">Level</h3>
                                <span class="text-sm sm:text-base">{{$data['user']['level']}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-5">
                <div class="p-4 rounded-xl w-full mx-auto border border-[#ffffff] border-opacity-20 bg-gradient-to-t from-[#265e8c] via-[#255480] to-[#243f82] overflow-hidden relative">
                    <img src={{ asset('assets/images/icons/total-directs.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full">
                        <h3 class="text-sm sm:text-base my-4 opacity-75 leading-none">Total Directs</h3>
                        <span class="text-sm sm:text-base">{{$data['user']['my_direct']}}</span>
                    </div>
                </div>
                <div class="p-4 rounded-xl w-full mx-auto border border-[#ffffff] border-opacity-20 bg-gradient-to-t from-[#265e8c] via-[#255480] to-[#243f82] overflow-hidden relative">
                    <img src={{ asset('assets/images/icons/sponsor.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full">
                        <h3 class="text-sm sm:text-base my-4 opacity-75 leading-none">Sponsor</h3>
                        <span class="text-sm sm:text-base">{{$data['user']['sponser_code']}}</span>
                    </div>
                </div>
                <div class="p-4 rounded-xl w-full mx-auto border border-[#ffffff] border-opacity-20 bg-gradient-to-t from-[#265e8c] via-[#255480] to-[#243f82] overflow-hidden relative">
                    <img src={{ asset('assets/images/icons/date-of-activation.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full">
                        <h3 class="text-sm sm:text-base my-4 opacity-75 leading-none">Date of Activation</h3>
                        <span class="text-sm sm:text-base">{{date('d-m-Y', strtotime($data['user']['created_on']))}}</span>
                    </div>
                </div>
                <div class="p-4 rounded-xl w-full mx-auto border border-[#ffffff] border-opacity-20 bg-gradient-to-t from-[#265e8c] via-[#255480] to-[#243f82] overflow-hidden relative">
                    <img src={{ asset('assets/images/icons/total-active-directs.webp') }} width="64" height="48" alt="Logo" class="w-8 sm:w-12 h-auto max-h-8 sm:max-h-12">
                    <div class="w-full">
                        <h3 class="text-sm sm:text-base my-4 opacity-75 leading-none">Total Active Direct</h3>
                        <span class="text-sm sm:text-base">{{$data['user']['active_direct']}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Home Page Popup Modal -->
<div id="popup" class="hidden fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black bg-opacity-60 backdrop-blur-sm transition-opacity duration-300 overflow-auto p-2">
    <!-- <span id="closePopup" class="fixed inset-0 -z-1 h-screen w-screen"></span> -->

    <div class="relative bg-black bg-opacity-50 shadow-lg overflow-auto max-h-[95vh] z-10 min-w-80 min-h-80">
        <!-- Countdown Close Button -->
        <button id="closePopup1" class="absolute top-2 right-2 h-10 w-10 bg-[#244283] border-white border-2 border-opacity-50 flex items-center justify-center select-none rounded-full text-white text-sm font-bold pointer-events-none z-10">
            <span id="countdown">45</span>
        </button>

        <!-- Static Video (Autoplays with popup) -->
        <div id="popupContent" class="p-0 w-full h-auto flex items-center justify-center">
            @if(isset($data['adCampaign']))
                <input type="hidden" name="adId" id="adId" value="{{$data['adCampaign']['id']}}">
            @if($data['adCampaign']['file_type'] == "image")
            <img id="adVideo" src="{{ asset('storage/'.$data['adCampaign']['file']) }}" width="500" height="500" alt="Ad" class="block max-h-[95vh] max-w-[600px] h-auto w-full bg-[#ffdddd] p-0.5 rounded-xl">
            @elseif($data['adCampaign']['file_type'] == "video")
            <video id="adVideo" autoplay loop muted playsinline controls disablePictureInPicture playsinline  controlsList="nodownload nofullscreen noremoteplayback" class="block max-h-[95vh] max-w-[600px] h-auto w-full bg-[#ffdddd] p-0.5 rounded-xl" oncontextmenu="return false">
                <source src="{{ asset('storage/'.$data['adCampaign']['file']) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            @else
            <iframe
                id="adVideo"
                width="700"
                height="400"
                class="max-w-full max-h-full object-center"
                src="https://www.youtube.com/embed/{{$data['adCampaign']['description']}}?autoplay=1&mute=1&playsinline=1&controls=0&disablekb=1&modestbranding=1&rel=0&iv_load_policy=3&fs=0&loop=1&playlist={{$data['adCampaign']['description']}}"
                data-src="https://www.youtube.com/embed/{{$data['adCampaign']['description']}}?autoplay=1&mute=0&playsinline=1&controls=0&disablekb=1&modestbranding=1&rel=0&iv_load_policy=3&fs=0&loop=1&playlist={{$data['adCampaign']['description']}}"
                title="Ad Video"
                frameborder="0"
                allow="autoplay; encrypted-media"
                allowfullscreen>
            </iframe>
            <!-- <div id="container-bd6c0c7b7069b8b8d574777e107adcb1" class="pointer-events-none"></div>
            <script async="async" data-cfasync="false" src="//pl26530520.profitableratecpm.com/bd6c0c7b7069b8b8d574777e107adcb1/invoke.js"></script> -->
            @endif
            @else
            <img id="adVideo" src="{{ asset('assets/videos/ads1.jpg') }}" width="500" height="500" alt="Ad" class="block max-h-[95vh] max-w-[600px] h-auto w-full bg-[#ffdddd] p-0.5 rounded-xl">
            @endif
        </div>
    </div>
</div>

@if(isset($data['idActive']) && $data['idActive'] == 0 || isset($data['show_70_popup']) && $data['show_70_popup'] == 1)
<!-- Modal (Initially visible) -->
<div id="modalWorning" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-3">
    <div class="bg-[#101735] border border-[#24324d] rounded-xl text-rounded-xl shadow-lg max-w-full w-[400px] space-y-4">
        <!-- Warning Header -->
        <div class="flex justify-between items-center border-b border-gray-800 dark:border-neutral-700 p-4">
            <h2 class="text-xl font-semibold text-white rounded-xl">Alert!</h2>
            <button onclick="closeModalWorning()" type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-[#2396b9] text-rounded-xl hover:bg-[#2396b9] focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none" aria-label="Close" data-hs-overlay="#hs-scroll-inside-body-modal" aria-expanded="true">
                <span class="sr-only">Close</span>
                <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body (2 lines of content) -->
        <div class="text-white p-4">
            <div class="w-full text-center mx-auto max-w-[70px]">
                <svg class="w-full h-auto mx-auto mb-5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
                    <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                        <path d="M 45 57.469 L 45 57.469 c -1.821 0 -3.319 -1.434 -3.399 -3.252 L 38.465 23.95 c -0.285 -3.802 2.722 -7.044 6.535 -7.044 h 0 c 3.813 0 6.82 3.242 6.535 7.044 l -3.137 30.267 C 48.319 56.036 46.821 57.469 45 57.469 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(229,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <circle cx="45" cy="67.67" r="5.42" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(229,0,0); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) " />
                        <path d="M 45 90 C 20.187 90 0 69.813 0 45 C 0 20.187 20.187 0 45 0 c 24.813 0 45 20.187 45 45 C 90 69.813 69.813 90 45 90 z M 45 6 C 23.495 6 6 23.495 6 45 s 17.495 39 39 39 s 39 -17.495 39 -39 S 66.505 6 45 6 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(229,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                    </g>
                </svg>
            </div>
            @if($data['idActive'] == 0)
                <p class="text-base text-gray-300 font-medium text-center">You've reached the maximum return limit on your existing investment. To continue earning and unlocking new income opportunities, kindly re-top up your account. Your journey to greater rewards doesn’t stop here!</p>
                <div class="bg-white/5 border border-white/10 p-4 mt-4 rounded-md">
                    <h2 class="mb-2 text-center text-xl xl:text-2xl uppercase">Time left for <span class="text-[#2396b9] font-semibold">retopup</span></h2>
                    <div id="countdown" class="text-center text-xl xl:text-2xl text-white font-semibold">
                        <!-- <span id="cd-days">00</span>d : -->
                        <span id="cd-hours">00</span>h :
                        <span id="cd-minutes">00</span>m :
                        <span id="cd-seconds">00</span>s
                    </div>
                </div>
            @else
                <p class="text-base text-gray-300 font-medium text-center">You're approaching the maximum return limit on your current investment — over 70% achieved! To ensure uninterrupted earnings and unlock your full potential, we recommend re-topping your account. Keep going, greater rewards are just ahead!</p>
            @endif
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end p-4 border-t border-gray-800 dark:border-neutral-700">
            <a href="{{route('packages')}}">
                <button type="button" class="px-4 py-1 text-white buttonbg mx-auto flex items-center text-base capitalize tracking-wider">
                    <span class="w-full">RETOPUP</span>
                    <svg id="svg1-icon" class="w-6 h-6 transition-transform duration-500 group-hover:translate-x-1" data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path clip-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" fill-rule="evenodd"></path>
                    </svg>
                </button>
            </a>
        </div>
    </div>
</div>
@if($data['idActive'] == 0)
<script>
    // Fixed target time: 20 July 2025, 3:00 PM
    // const targetDate = new Date('2025-07-20T17:00:00'); // ISO format
    const targetDate =  new Date("{!! $data['package_completed_on'] !!}"); // ISO format


    function updateCountdown() {
        const now = new Date();
        const diff = targetDate - now;

        if (diff <= 0) {
            document.getElementById("countdown").innerHTML = "Time's up!";
            return;
        }

        // const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((diff / (1000 * 60)) % 60);
        const seconds = Math.floor((diff / 1000) % 60);

        // document.getElementById("cd-days").innerText = String(days).padStart(2, '0');
        document.getElementById("cd-hours").innerText = String(hours).padStart(2, '0');
        document.getElementById("cd-minutes").innerText = String(minutes).padStart(2, '0');
        document.getElementById("cd-seconds").innerText = String(seconds).padStart(2, '0');
    }

    updateCountdown();
    setInterval(updateCountdown, 1000); // Update every second
</script>
@endif
<script>
    // Flag to check if the user has manually closed the modal
    let isClosedManually = false;

    // Close the modal when clicking the "Close" button or the "×"
    function closeModalWorning() {
        // Set the flag to true to prevent the auto-close function
        isClosedManually = true;
        document.getElementById('modalWorning').style.display = 'none';
    }
</script>
@endif

<!-- JavaScript Logic -->
<script>
    let allAds = {!! json_encode($data['allAds'], true) !!};
    let userAds = {{$data['user']['ad_viewed']}} < 7 ? {{$data['user']['ad_viewed']}} : 0;
    document.addEventListener("DOMContentLoaded", function() {
        const popup = document.getElementById("popup");
        const closeBtn1 = document.getElementById("closePopup1");
        const countdownSpan = document.getElementById("countdown");
        const viewAdsBtn = document.getElementById("viewAdsBtn");

        viewAdsBtn.addEventListener("click", function() {
            popup.classList.remove("hidden");
            closeBtn1.classList.remove("hidden");
            closeBtn1.classList.add("pointer-events-none");
            closeBtn1.innerHTML = `<span id="countdown">45</span>`;

            // 👇👇👇 Add this code for YouTube iframe start
            const adVideo = document.getElementById("adVideo");
            if (adVideo && adVideo.tagName === "IFRAME" && adVideo.dataset.src) {
                adVideo.src = 'https://www.youtube.com/embed/'+allAds[userAds].description+'?autoplay=1&mute=0&playsinline=1&controls=0&disablekb=1&modestbranding=1&rel=0&iv_load_policy=3&fs=0&loop=1&playlist='+allAds[userAds].description;

                document.getElementById("adId").value = allAds[userAds].id;
            }
            if(adVideo.tagName === "VIDEO")
            {
                 const source = adVideo.querySelector("source");
                if (source) {
                    source.src = "/storage/" + allAds[userAds].file;
                    adVideo.load(); // <- this reloads the video
                }
                adVideo.play();
            }

            let countdown = countdownSpan.innerText;

            // Start Countdown
            const countdownInterval = setInterval(() => {
                countdown--;
                document.getElementById("countdown").innerText = countdown;

                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    closeBtn1.innerHTML = `
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>`;
                    closeBtn1.classList.remove("pointer-events-none");
                    closeBtn1.click();
                    if(adVideo.tagName === "IFRAME")
                    {
                        adVideo.src = '';
                    }

                    if(adVideo.tagName === "VIDEO")
                    {
                        adVideo.pause();
                    }
                }
            }, 1000);
        });

        // Close only after countdown
        closeBtn1.addEventListener("click", () => {
            if (!closeBtn1.classList.contains("pointer-events-none")) {
                makeTheAdCount();
                userAds++;
                let img = document.getElementById("ad-img-" + userAds);
                if (img) {
                    img.src = "/assets/images/right-icon.svg";
                }
                popup.classList.add("hidden");
            }
        });
    });
</script>
<script>
    function makeTheAdCount() {
        let x = document.getElementById("adId").value;
        let ad_percent = document.getElementById("ad_percent");
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            let respo = JSON.parse(this.responseText);
            let percent_result=respo.ad_viewed*0.25;
            ad_percent.innerText=`${percent_result}%`
            // let img = document.getElementById("todayAdViewImage");
            // img.src = "/assets/images/right-icon.svg";
        }
        xhttp.open("POST", "{{route('fadViewed')}}");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.setRequestHeader("X-CSRF-TOKEN", csrfToken);
        xhttp.send("ad_id=" + x);
    }
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const timerElement = document.querySelector('.your-timer-class'); // Update your span to have this class

    function updateTimer() {
        const nowUtc = new Date();

        // Target today 12:00 PM UTC
        const targetUtc = new Date(nowUtc);
        targetUtc.setUTCHours(12, 1, 0, 0); // 12:00 PM UTC

        // If current UTC time > 12:00 PM, target is next day's 12:00 PM
        if (nowUtc > targetUtc) {
            targetUtc.setUTCDate(targetUtc.getUTCDate() + 1);
        }

        const diffMs = targetUtc - nowUtc;
        const diffHrs = Math.floor(diffMs / (1000 * 60 * 60));
        const diffMins = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
        const diffSecs = Math.floor((diffMs % (1000 * 60)) / 1000);

        timerElement.innerHTML = `${diffHrs.toString().padStart(2, '0')}:${diffMins.toString().padStart(2, '0')}:${diffSecs.toString().padStart(2, '0')}`;
    }

    setInterval(updateTimer, 1000);
    updateTimer(); // call once immediately
});
</script>
@endsection

<script src="{{asset('assets/js/apexcharts.js')}}"></script>