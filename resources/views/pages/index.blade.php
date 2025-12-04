@extends('layouts.app')
@section('title', 'Home')

@section('content')
<section class="w-full mx-auto max-w-[1470px]">
    @if(isset($data['rewardDate']))
    <div>
        {{-- resources/views/marquee.blade.php --}}
        <div class="w-full bg-gray-900 text-white bg-gradient-to-l from-[#0f0f1c] via-[#6b3fb9] to-[#0f0f1c]">
            <style>
                /* 100% fix: clip + take track out of normal flow */
                .tw-marquee-viewport{ position:relative; overflow:hidden;height: 40px; }
                .tw-marquee-track{
                --dur: 250s;
                position:absolute; left:0; top:0;   /* <-- key: no layout widening */
                display:flex; flex-wrap:nowrap;
                width:max-content;
                will-change: transform;
                animation: tw-marquee var(--dur) linear infinite;
                }
                .tw-marquee-track:hover{ animation-play-state: paused; }

                .tw-marquee-group {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    padding: 8px 5px;
                    white-space: nowrap;
                }

                @keyframes tw-marquee{
                0%   { transform: translateX(0); }
                100% { transform: translateX(-50%); } /* because we duplicate content */
                }

                /* safety: kabhi-kabhi theme CSS se bhi scroll aata hai */
                html, body { overflow-x:hidden; }

                /* motion preference */
                @media (prefers-reduced-motion: reduce){
                .tw-marquee-track{ animation:none !important; transform:none !important; position:static; }
                }

                /* mobile pe slow karna ho */
                @media (max-width:640px){ .tw-marquee-track{ --dur: 250s; } }
            </style>

            <div class="mx-auto max-w-full px-0 py-0 relative">
                <h2 class="sm:bg-gradient-to-l from-[#2c1e4e] to-[#0f0f1c] text-left sm:absolute sm:top-0 sm:left-0 sm:h-full flex items-center justify-center p-0 z-[9] sm:pr-3">Monthly Top Investors</h2>
                <div class="tw-marquee-viewport mt-0" aria-label="Top investors marquee">
                <div class="tw-marquee-track">
                    <!-- Group A -->
                    <div class="tw-marquee-group">
                    @foreach($data['top_investor'] as $k => $v)
                        <span class="inline-flex items-center gap-1.5">
                        {{ $k + 1 }} -
                        {{ substr($v->wallet_address, 0, 6) }}...{{ substr($v->wallet_address, -6) }} -
                        {{ number_format($v->amount, 2) }} RTX -
                        ${{ number_format($v->amount * $v->coin_price, 2) }}
                        </span><span aria-hidden="true">|</span>
                    @endforeach
                    </div>

                    <!-- Group B (duplicate for seamless loop) -->
                    <div class="tw-marquee-group" aria-hidden="true">
                    @foreach($data['top_investor'] as $k => $v)
                        <span class="inline-flex items-center gap-1.5">
                        {{ $k + 1 }} -
                        {{ substr($v->wallet_address, 0, 6) }}...{{ substr($v->wallet_address, -6) }} -
                        {{ number_format($v->amount, 2) }} RTX -
                        ${{ number_format($v->amount * $v->coin_price, 2) }}
                        </span><span aria-hidden="true">|</span>
                    @endforeach
                    </div>
                </div>
                </div>
            </div>
        </div>


        <div class="flex items-center justify-between gap-2 mt-5 mb-2 border border-[#bd97ff] p-2 sm:pl-4 rounded-md">
            <h2 class="text-sm md:text-xl font-semibold leading-none">Reward Bonus (Star {{$data['user']['rank_id'] + 1}})</h2>
            @if(count($data['my_packages'])>0)
            <div id="timer" class="flex justify-center text-sm sm:text-base md:text-2xl font-semibold gap-1 sm:gap-2">
                <div class="text-center">
                    <div id="days" class="text-[#fad85d]">--</div>
                    <div class="text-xs sm:text-sm text-gray-400">Days</div>
                </div>
                <span>:</span>
                <div class="text-center">
                    <div id="hours" class="text-[#fad85d]">--</div>
                    <div class="text-xs sm:text-sm text-gray-400">Hours</div>
                </div>
                <span>:</span>
                <div class="text-center">
                    <div id="minutes" class="text-[#fad85d]">--</div>
                    <div class="text-xs sm:text-sm text-gray-400">Minutes</div>
                </div>
                <span>:</span>
                <div class="text-center">
                    <div id="seconds" class="text-[#fad85d]">--</div>
                    <div class="text-xs sm:text-sm text-gray-400">Seconds</div>
                </div>
            </div>
            @endif
        </div>

        <script>
            const countdownDate = new Date("{{ date('c', strtotime($data['rewardDate'])) }}").getTime();
            const daysEl = document.getElementById("days");
            const hoursEl = document.getElementById("hours");
            const minutesEl = document.getElementById("minutes");
            const secondsEl = document.getElementById("seconds");

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = countdownDate - now;

                if (distance <= 0) {
                    daysEl.innerText = hoursEl.innerText = minutesEl.innerText = secondsEl.innerText = '00';
                    clearInterval(interval);
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                daysEl.innerText = String(days).padStart(2, '0');
                hoursEl.innerText = String(hours).padStart(2, '0');
                minutesEl.innerText = String(minutes).padStart(2, '0');
                secondsEl.innerText = String(seconds).padStart(2, '0');
            }

            const interval = setInterval(updateCountdown, 1000);
            updateCountdown();
        </script>
    </div>
    @endif
    <div class="grid grid-cols-1 gap-5 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 md:gap-5 overflow-hidden mt-5">
            <x-stat-box
                title="Market Value"
                value="${{ number_format(210000000 * $data['rtxPrice']) }}"
                bgColor="#0BF4C8"
                borderColor="#0BF4C8"
                imageSrc="{{ asset('assets/images/icons/marketvalue.webp') }}"
                altText="Market Value" />

            <x-stat-box
                title="Total Supply"
                value="{{ number_format(210000000) }}"
                bgColor="#FAD85D"
                borderColor="#FAD85D"
                imageSrc="{{ asset('assets/images/icons/totalsupply.webp') }}"
                altText="Total Supply" />

            <x-stat-box
                title="RTX Price"
                value="${{ number_format($data['rtxPrice'], 2) }}"
                bgColor="#F2A0FF"
                borderColor="#F2A0FF"
                imageSrc="{{ asset('assets/images/icons/rtxprice.webp') }}"
                altText="RTX Price" />

            <x-stat-box
                title="Liquidity Pool"
                value="${{ number_format($data['treasuryBalance'] * $data['rtxPrice'], 2) }}"
                bgColor="#FF6B6B"
                borderColor="#FF6B6B"
                imageSrc="{{ asset('assets/images/icons/treasury-wallet.webp') }}"
                altText="Liquidity Pool" />
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
            <div class="grid grid-cols-1 xl:col-span-2 gap-5">
                @if($data['user']['rank_id']>0)
                <!-- <div class="relative overflow-hidden w-full bg-[#121222] border border-[#bd97ff] shadow-[inset_0px_0px_20px_-3px_#bd97ff] rounded-xl p-3 items-center flex flex-wrap sm:flex-nowrap items-center justify-between gap-4">
                </div> -->
                @else
                <!-- <div class="hidden relative overflow-hidden w-full bg-[#121222] border border-[#bd97ff] shadow-[inset_0px_0px_20px_-3px_#bd97ff] rounded-xl p-3 items-center flex flex-wrap sm:flex-nowrap items-center justify-between gap-4">
                </div> -->
                @endif
                   <!--  <h2 class="text-base sm:text-lg font-medium sm:font-semibold leading-none">Event Form – 17 August</h2>
                    @if($data['delhi-event'] == 0)
                    <button onclick="openFormEvent()" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-t from-[#6B3FB9] to-indigo-500 border border-[#BD97FF] rounded-md text-white text-lg hover:from-[#7C4BC7] hover:to-indigo-600 transition">
                        Fill Event Form
                    </button>
                    @else
                    <h2 class="text-green-600 sm:text-lg font-medium sm:font-semibold leading-none">Form Submitted Thank You!</h2>
                    @endif -->
                <x-star-levels :rank="$data['user']['rank_id']" />
            </div>
            <div class="grid grid-cols-1 col-span-1 gap-5">
                <x-referral-link-card
                    package="{{count($data['my_packages'])}}"
                    walletAddress="{{$data['user']['wallet_address']}}"
                    referrer="{{$data['sponser']['wallet_address']}}"
                    affiliateData="{referrer: {{$data['sponser']['wallet_address']}}}"
                    link="https://{{ request()->getHost() }}/connect-wallet?sponser_code={{ Session::get('wallet_address')}}" />

                <x-download-pdf
                    file="orbitx-the-defi-revolution-begins.pdf?v={{time()}}"
                    title="PPT Download"
                    subtitle="Download Orbitx Presentation"
                    logo="assets/images/logo.webp"
                    bgImage="assets/images/wavebgbox.svg" />
            </div>
        </div>
        <x-level-grid :currentLevel="$data['user']['level']" />

        <section class="w-full mx-auto max-w-[1400px]">
            <h2 class="bg-blue-500 relative rankinginfo4 text-white rounded-sm p-3 text-lg font-normal leading-none mb-5 flex items-center gap-2">
                <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 17V11" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                    <circle cx="1" cy="1" r="1" transform="matrix(1 0 0 -1 11 9)" fill="#ffffff" />
                    <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                </svg>
                Calculator
            </h2>
            <div class="w-full max-w-2xl mx-auto p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl mt-10">
                <form class="relative" method="post" action="#" id="apy-static-form">
                    @csrf
                    @method('POST')

                    {{-- Tenor (Days) --}}
                    <div class="relative">
                        <label class="block text-xs text-white/70 font-medium mb-2">Select Tenor (Days)</label>
                        <div class="flex items-center overflow-auto gap-1.5 sm:gap-3 mb-4 bg-white/5 p-3 rounded">
                            @foreach([7,30,90,180,360] as $i => $d)
                            <label class="w-full relative flex items-center justify-center border border-white/15 px-1.5 py-2 sm:px-3 sm:py-3 rounded gap-1 sm:gap-3 bg-transparent cursor-pointer">
                                <input type="radio" name="days" id="days_{{ $d }}" value="{{ $d }}"
                                    class="peer opacity-0 hidden absolute top-0 left-0 h-full w-full cursor-pointer appearance-none transition-all relative"
                                    {{ $i===0 ? 'checked' : '' }}>
                                <span class="absolute top-0 left-0 bg-[#845dcb]/20 w-full h-full opacity-0 peer-checked:opacity-60 transition-opacity duration-200 z-0 border border-[#845dcb]"></span>
                                <label for="days_{{ $d }}" class="text-white cursor-pointer text-xs sm:text-sm z-10 whitespace-nowrap">{{ $d }} days</label>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Enter Amount --}}
                    <div class="relative">
                        <div class="flex items-center mb-2">
                            <label for="amount" class="block text-xs text-white text-opacity-70 font-medium">Enter Amount</label>
                            <!-- <span class="ml-2 px-2 py-0.5 rounded bg-[#845dcb]/20 text-[#845dcb] text-[10px] font-semibold cursor-default"
                                style="font-size:10px;line-height:1.2;">MAX</span> -->
                        </div>
                        <div class="relative mb-4 flex items-center justify-between border border-white/15 p-3 rounded gap-3 bg-transparent">
                            <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M21 6V3.50519C21 2.92196 20.3109 2.61251 19.875 2.99999C19.2334 3.57029 18.2666 3.57029 17.625 2.99999C16.9834 2.42969 16.0166 2.42969 15.375 2.99999C14.7334 3.57029 13.7666 3.57029 13.125 2.99999C12.4834 2.42969 11.5166 2.42969 10.875 2.99999C10.2334 3.57029 9.26659 3.57029 8.625 2.99999C7.98341 2.42969 7.01659 2.42969 6.375 2.99999C5.73341 3.57029 4.76659 3.57029 4.125 2.99999C3.68909 2.61251 3 2.92196 3 3.50519V14M21 10V20.495C21 21.0782 20.3109 21.3876 19.875 21.0002C19.2334 20.4299 18.2666 20.4299 17.625 21.0002C16.9834 21.5705 16.0166 21.5705 15.375 21.0002C14.7334 20.4299 13.7666 20.4299 13.125 21.0002C12.4834 21.5705 11.5166 21.5705 10.875 21.0002C10.2334 20.4299 9.26659 20.4299 8.625 21.0002C7.98341 21.5705 7.01659 21.5705 6.375 21.0002C5.73341 20.4299 4.76659 20.4299 4.125 21.0002C3.68909 21.3876 3 21.0782 3 20.495V18" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M7.5 15.5H11.5M16.5 15.5H14.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M16.5 12H12.5M7.5 12H9.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M7.5 8.5H16.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            <input type="text" name="amount" id="amount" autocomplete="off" placeholder="Enter Amount"
                                class="border-l pl-4 border-white/15 outline-none shadow-none bg-transparent w-full block text-base placeholder-white/50">
                            <span class="text-xs text-white/70 font-medium">RTX</span>
                        </div>
                    </div>

                    {{-- Range Slider --}}
                    <div class="relative mb-4 hidden">
                         <div class="flex items-center mb-2">
                            <label for="amount_range" class="block text-xs text-white text-opacity-70 font-medium">RTX Price: ${{ number_format($data['rtxPrice'], 2) }}</label>
                        </div>
                        <div class="mb-2">
                            <input
                                type="range"
                                id="amount_range"
                                name="amount_range"
                                min="1"
                                max="100"
                                step="1"
                                value="{{ number_format($data['rtxPrice'], 2) }}"
                                class="w-full accent-[#845dcb] cursor-pointer"
                            />
                        </div>
                        <!-- value="{{ isset($data['rtxPrice']) ? (int) $data['rtxPrice'] : 1 }}" -->

                        <div class="flex justify-between text-xs text-white/50">
                            <span>Min: $1</span>
                            <span>Max: $100</span>
                        </div>
                    </div>
                    
                    <div class="relative grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                        <div class="relative">
                            <label for="apy" class="block text-xs text-white/70 font-medium mb-2">APY</label>
                            <div class="relative mb-2 flex items-center justify-between border border-white/15 p-3 rounded gap-3 bg-transparent">
                                <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M21 6V3.50519C21 2.92196 20.3109 2.61251 19.875 2.99999C19.2334 3.57029 18.2666 3.57029 17.625 2.99999C16.9834 2.42969 16.0166 2.42969 15.375 2.99999C14.7334 3.57029 13.7666 3.57029 13.125 2.99999C12.4834 2.42969 11.5166 2.42969 10.875 2.99999C10.2334 3.57029 9.26659 3.57029 8.625 2.99999C7.98341 2.42969 7.01659 2.42969 6.375 2.99999C5.73341 3.57029 4.76659 3.57029 4.125 2.99999C3.68909 2.61251 3 2.92196 3 3.50519V14M21 10V20.495C21 21.0782 20.3109 21.3876 19.875 21.0002C19.2334 20.4299 18.2666 20.4299 17.625 21.0002C16.9834 21.5705 16.0166 21.5705 15.375 21.0002C14.7334 20.4299 13.7666 20.4299 13.125 21.0002C12.4834 21.5705 11.5166 21.5705 10.875 21.0002C10.2334 20.4299 9.26659 20.4299 8.625 21.0002C7.98341 21.5705 7.01659 21.5705 6.375 21.0002C5.73341 20.4299 4.76659 20.4299 4.125 21.0002C3.68909 21.3876 3 21.0782 3 20.495V18" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M7.5 15.5H11.5M16.5 15.5H14.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M16.5 12H12.5M7.5 12H9.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M7.5 8.5H16.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                <input type="text" id="apy" name="apy" readonly placeholder="0.00%"
                                    value="0.00%" class="border-l pl-4 border-white/15 outline-none shadow-none bg-transparent w-full block text-base placeholder-white/50">
                                <span class="text-xs text-white/70 font-medium whitespace-nowrap">RTX</span>
                            </div>
                        </div>

                        <div class="relative">
                            <label for="apyUsd" class="block text-xs text-white/70 font-medium mb-2">APY ($)</label>
                            <div class="relative mb-2 flex items-center justify-between border border-white/15 p-3 rounded gap-3 bg-transparent">
                                <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M21 6V3.50519C21 2.92196 20.3109 2.61251 19.875 2.99999C19.2334 3.57029 18.2666 3.57029 17.625 2.99999C16.9834 2.42969 16.0166 2.42969 15.375 2.99999C14.7334 3.57029 13.7666 3.57029 13.125 2.99999C12.4834 2.42969 11.5166 2.42969 10.875 2.99999C10.2334 3.57029 9.26659 3.57029 8.625 2.99999C7.98341 2.42969 7.01659 2.42969 6.375 2.99999C5.73341 3.57029 4.76659 3.57029 4.125 2.99999C3.68909 2.61251 3 2.92196 3 3.50519V14M21 10V20.495C21 21.0782 20.3109 21.3876 19.875 21.0002C19.2334 20.4299 18.2666 20.4299 17.625 21.0002C16.9834 21.5705 16.0166 21.5705 15.375 21.0002C14.7334 20.4299 13.7666 20.4299 13.125 21.0002C12.4834 21.5705 11.5166 21.5705 10.875 21.0002C10.2334 20.4299 9.26659 20.4299 8.625 21.0002C7.98341 21.5705 7.01659 21.5705 6.375 21.0002C5.73341 20.4299 4.76659 20.4299 4.125 21.0002C3.68909 21.3876 3 21.0782 3 20.495V18" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M7.5 15.5H11.5M16.5 15.5H14.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M16.5 12H12.5M7.5 12H9.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M7.5 8.5H16.5" stroke="#b3b3b4" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                <input type="text" id="apyUsd" name="apyUsd" readonly placeholder="0.00%"
                                    value="0.00%" class="border-l pl-4 border-white/15 outline-none shadow-none bg-transparent w-full block text-base placeholder-white/50">
                                <span class="text-xs text-white/70 font-medium whitespace-nowrap">$</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <div id="statsGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5 mt-5">
           <div class="stat-card">
                <x-item-box
                    image-src="{{ asset('assets/images/icons/withdraw.webp') }}"
                    title="Total Claimed Bonus"
                    :valuesDolur="'$' . number_format($data['rtxPrice'] * $data['total_withdraw'], 3)"
                    :values="number_format($data['total_withdraw'], 3) . ' RTX'"
                    flex="flex-col" />
            </div>
            <div class="stat-card">
                <x-item-box
                    image-src="{{ asset('assets/images/icons/staked-amount.webp') }}"
                    title="Staked Amount"
                    :valuesDolur="'$' . number_format($data['rtxPrice'] * $data['activeStake'], 3)"
                    :values="number_format($data['activeStake'], 3) . ' RTX'"
                    flex="flex-col" />
            </div>
            <div class="stat-card">
                <x-item-box
                    image-src="{{ asset('assets/images/icons/compounded-amount.webp') }}"
                    title="Compounded Amount"
                    :valuesDolur="'$' . number_format($data['rtxPrice'] * ($data['compound_amount'] + $data['self_investment'] - $data['total_unstake_amount']), 3)"
                    :values="number_format(($data['compound_amount'] + $data['self_investment'] - $data['total_unstake_amount']), 3) . ' RTX'"
                    flex="flex-col" />
            </div>
            <div class="stat-card">
                <x-item-box
                    image-src="{{ asset('assets/images/icons/total-income.webp') }}"
                    title="Last Stake Bonus"
                    :valuesDolur="'$' . number_format($data['rtxPrice'] * $data['user']['daily_roi'], 3)"
                    :values="number_format($data['user']['daily_roi'], 3) . ' RTX'"
                    flex="flex-col" />
            </div>
            <div class="stat-card">
                <x-item-box
                    image-src="{{ asset('assets/images/icons/daily-pool.webp') }}"
                    title="Daily Pool Bonus"
                    :valuesDolur="'$' . number_format($data['rtxPrice'] * $data['dailyPoolWinners'], 3)"
                    :values="number_format($data['dailyPoolWinners'], 3) . ' RTX'"
                    flex="flex-col" />
            </div>
            <div class="stat-card extra hidden">
                <x-item-box
                    image-src="{{ asset('assets/images/icons/total-directs.webp') }}"
                    title="Total Directs"
                    :values="$data['user']['active_direct']"
                    flex="flex-col" />
            </div>
            <div class="stat-card extra hidden">
                <x-item-box
                    image-src="{{ asset('assets/images/icons/direct-investment.webp') }}"
                    title="Direct Investment"
                    :valuesDolur="'$' . number_format($data['rtxPrice'] * $data['user']['direct_business'], 3)"
                    :values="number_format($data['user']['direct_business'], 3) . ' RTX'"
                    flex="flex-col" />
            </div>
            <div class="stat-card extra hidden">
                <x-item-box
                    image-src="{{ asset('assets/images/icons/total-team.webp') }}"
                    title="Total Team"
                    :values="$data['user']['my_team']"
                    flex="flex-col" />
            </div>
            <div class="stat-card extra hidden">
                <x-item-box
                    image-src="{{ asset('assets/images/icons/total-team-investment.webp') }}"
                    title="Team Investment"
                    :valuesDolur="'$' . number_format(($data['rtxPrice'] * ($data['user']['my_business'] + $data['user']['strong_business'] + $data['user']['weak_business'])), 3)"
                    :values="number_format(($data['user']['my_business'] + $data['user']['strong_business'] + $data['user']['weak_business']), 3) . ' RTX'"
                    flex="flex-col" />
            </div>
            <div class="stat-card extra hidden">
                <x-item-box
                    image-src="{{ asset('assets/images/icons/club-bonus.webp') }}"
                    title="Club Bonus"
                    :valuesDolur="'$' . number_format($data['rtxPrice'] * $data['user']['club_bonus'], 3)"
                    :values="number_format($data['user']['club_bonus'], 3) . ' RTX'"
                    flex="flex-col" />
            </div>
            <div class="stat-card extra hidden">
                <x-item-box
                    image-src="{{ asset('assets/images/icons/reward-bonus.webp') }}"
                    title="Reward Bonus"
                    :valuesDolur="'$' . number_format($data['rtxPrice'] * $data['user']['reward_bonus'], 3)"
                    :values="number_format($data['user']['reward_bonus'], 3) . ' RTX'"
                    flex="flex-col" />
            </div>
            <div class="stat-card extra hidden">
                <x-item-box
                    image-src="{{ asset('assets/images/icons/star-bonus.webp') }}"
                    title="Star Bonus"
                    :valuesDolur="'$' . number_format($data['rtxPrice'] * $data['user']['rank_bonus'], 3)"
                    :values="number_format($data['user']['rank_bonus'], 3) . ' RTX'"
                    flex="flex-col" />
            </div>
            <div class="stat-card extra hidden">
                <x-item-box
                    image-src="{{ asset('assets/images/icons/level-bonus.webp') }}"
                    title="Level Income"
                    :valuesDolur="'$' . number_format($data['rtxPrice'] * $data['user']['level_income'], 3)"
                    :values="number_format($data['user']['level_income'], 3) . ' RTX'"
                    flex="flex-col" />
            </div>
            <div class="stat-card extra hidden">
                <x-item-box
                    image-src="{{ asset('assets/images/icons/upline-bonus.webp') }}"
                    title="Upline Bonus"
                    :values="number_format($data['user']['direct_income'], 3) . ' RTX'"
                    :valuesDolur="'$' . number_format($data['rtxPrice'] * $data['user']['direct_income'], 3)"
                    flex="flex-col" />
            </div>
            <div class="stat-card extra hidden">
                <x-item-box
                    image-src="{{ asset('assets/images/icons/monthly-pool.webp') }}"
                    title="Monthly Pool Bonus"
                    :valuesDolur="'$' . number_format($data['rtxPrice'] * $data['monthlyPoolWinners'], 3)"
                    :values="number_format($data['monthlyPoolWinners'], 3) . ' RTX'"
                    flex="flex-col" />
            </div>
        </div>

        {{-- Load more button --}}
        <div class="mt-2 flex justify-center">
            <button
                id="loadMoreStats"
                type="button"
                class="text-white text-sm sm:text-base flex items-center gap-1 sm:gap-2 font-normal capitalize border-opacity-50 rounded-md px-2 sm:px-3 py-2 active bg-gradient-to-t from-[#6b3fb9] to-indigo-500 border border-[#bd97ff] hover:from-[#7c4bc7] hover:to-indigo-600 transition-all duration-200"
            >
                Load more
            </button>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('loadMoreStats');
            const extras = document.querySelectorAll('#statsGrid .extra');

            btn?.addEventListener('click', () => {
                extras.forEach(el => el.classList.remove('hidden'));
                btn.classList.add('hidden'); // hide button after showing all
            });
        });
        </script>

        <div class="flex items-center gap-3 mt-4">
            <div class="w-1 h-8 bg-gradient-to-b from-[#fac35d] to-[#FAD85D] rounded-full"></div>
            <h3 class="font-bold text-xl md:text-2xl">Rank Bonus Analytics</h3>
            <div class="flex-1 h-px bg-gradient-to-r from-[#322751] via-[#322751] to-transparent"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 overflow-hidden">
        {{--    <x-rank-analytics
                lable="Team ROI"
                title="Total Team ROI"
                :valuesDolur="'$' . number_format(($data['rtxPrice'] * $data['teamRoi']), 3)"
                :value="$data['teamRoi']"
                unit="RTX"
                bgColor="#ffa0b7"
                borderColor="#ffa0b7"
                imageSrc="{{ asset('assets/images/icons/strongteam.svg') }}" />--}}

           {{-- <x-rank-analytics
                lable="Rank"
                title="Rank Users Bonus"
                :valuesDolur="'$' . number_format(($data['rtxPrice'] * $data['user']['rank_bonus']), 3)"
                :value="0"
                unit="RTX"
                bgColor="#aea0ff"
                borderColor="#aea0ff"
                imageSrc="{{ asset('assets/images/icons/leaderearn.svg') }}" />--}}

            {{-- <x-rank-analytics
                lable="Count"
                title="Rank Users in Team"
                :value="$data['rankUser']"
                unit="Users"
                bgColor="#8be189"
                borderColor="#8be189"
                imageSrc="{{ asset('assets/images/icons/teamgrowth.svg') }}" /> --}}

            <x-rank-analytics
                lable="Count"
                title="Active Users"
                :value="$data['user']['active_team']"
                unit="Users"
                bgColor="#FF6B6B"
                borderColor="#FF6B6B"
                imageSrc="{{ asset('assets/images/icons/employee.svg') }}" />

            <x-rank-analytics
                lable="Non-Rank"
                title="Non-Rank Users"
                :value="$data['nonRankUser']"
                unit="Users"
                bgColor="#ffe1a0"
                borderColor="#ffe1a0"
                imageSrc="{{ asset('assets/images/icons/weakteam.svg') }}" />

        </div>

        @php
        $rankUser = $data['rankUser'] ?? 0;
        $nonRankUser = $data['nonRankUser'] ?? 0;
        $totalUsers = $rankUser + $nonRankUser;

        $rankPercentage = $totalUsers > 0 ? round(($rankUser / $totalUsers) * 100, 1) : 0;
        $nonRankPercentage = 100 - $rankPercentage; // ensures total = 100
        @endphp

        <!-- Bonus Distribution Analysis -->
        <div class="group relative gap-2 md:gap-4 bg-[#121222] border border-[#322751] rounded-xl px-4 py-6 overflow-hidden text-left text-white mt-2">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Bonus Distribution Analysis</h3>
                        <p class="text-sm text-gray-400">Performance breakdown of your team structure</p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="text-center">
                        <p class="text-xs text-gray-400 mb-1">Rank Contribution</p>
                        <p class="text-sm font-medium text-emerald-400">{{ $rankPercentage }}%</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-gray-400 mb-1">Non-Rank Contribution</p>
                        <p class="text-sm font-medium text-purple-400">{{ $nonRankUser == 0 ? "0" : $nonRankPercentage }}%</p>
                    </div>
                </div>
            </div>
            <div class="w-full h-full absolute top-0 left-0 opacity-10 p-0 z-0 pointer-events-none">
                <img src="{{ asset('assets/images/wavebgbox.svg') }}" alt="Bonus Distribution Analysis"
                    class="w-full h-full object-cover b mx-auto hue-rotate-[225deg]" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 overflow-hidden">
            <x-rank-analytics
                lable="Strong Leg Business"
                title="Highest performing leg"
                :valuesDolur="'$' . number_format(($data['rtxPrice'] * ($data['firstLeg'])), 3)"
                :value="($data['firstLeg']) . 'RTX'"
                bgColor="#009688"
                borderColor="#009688"
                imageSrc="{{ asset('assets/images/icons/rank.svg') }}" />

            <x-rank-analytics
                lable="Other Legs"
                title="Development opportunity"
                :valuesDolur="'$' . number_format(($data['rtxPrice'] * ($data['otherLeg'])), 3)"
                :value="($data['otherLeg']) . 'RTX'"
                bgColor="#93695a"
                borderColor="#93695a"
                imageSrc="{{ asset('assets/images/icons/teamgrowthlaps.svg') }}" />

        </div>

        <div class="grid grid-cols-1 xl:grid-cols-1 gap-5 mt-4">
            <div class="cols-span-1 md:col-span-1 grid grid-cols-1">
                <div class="w-full xl:col-span-2 p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl">
                    @include('components.packages-table')
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div id="fillFormEvent" class="fixed flex inset-0 bg-black/70 backdrop-blur-sm hidden justify-center items-center z-[52] px-4">
    <div class="relative bg-gradient-to-br from-[#1f1d2b] to-[#2a263b] border border-[#3f3b53] rounded-2xl shadow-2xl p-4 sm:p-5 w-full max-w-xl text-left text-white animate-scale-fade overflow-y-auto max-h-[90vh]">
        
        <!-- Close Button -->
        <button onclick="closeFormEvent()" class="absolute top-3 right-3 text-white text-3xl transition leading-none">
            &times;
        </button>

        <h2 class="text-base sm:text-xl font-medium sm:font-semibold mb-0 text-white text-left leading-[1.4] mb-2.5 pr-3">
            Event – 17 August (Star & Above)
        </h2>
        <div class="w-full h-auto p-0 z-0">
            <img src="{{ asset('assets/images/event17august.webp') }}" alt="Event – 17 August (Star & Above)"
                class="rounded bg-[#2c273f] border border-white/10 w-full h-auto object-cover mx-auto" />
        </div>
        <form class="space-y-2 sm:space-y-3" method="POST" action="{{ route('user_rank_details_store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Name -->
                <div>
                    <label class="block text-sm opacity-90 mb-1">Name</label>
                    <input type="text" name="name" class="w-full p-2 rounded outline-none bg-[#2c273f] border border-white/10 text-white" required>
                </div>

                <!-- Mobile -->
                <div>
                    <label class="block text-sm opacity-90 mb-1">Mobile</label>
                    <input type="tel" name="mobile" class="w-full p-2 rounded outline-none bg-[#2c273f] border border-white/10 text-white" required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm opacity-90 mb-1">Email</label>
                    <input type="email" name="email" class="w-full p-2 rounded outline-none bg-[#2c273f] border border-white/10 text-white" required>
                </div>

                <!-- Rank -->
                <div>
                    <label class="block text-sm opacity-90 mb-1">Rank</label>
                    <input type="text" value="{{$data['user']['rank_id']}}" readonly class="w-full p-2 rounded outline-none bg-[#2c273f] border border-white/10 text-white">
                </div>

                <!-- Address Proof -->
                <div>
                    <label class="block text-sm opacity-90 mb-1">Address Proof</label>
                    <input type="file" name="address_proof" class="w-full p-2 outline-none bg-[#2c273f] border border-white/10 rounded text-white" required>
                </div>

                <!-- Photo -->
                <div>
                    <label class="block text-sm opacity-90 mb-1">Your Photo</label>
                    <input type="file" name="photo" class="w-full p-2 outline-none bg-[#2c273f] border border-white/10 rounded text-white" required>
                </div>
            </div>
            <input type="hidden" name="rank" value="{{$data['user']['rank_id']}}">
            <!-- Submit -->
            <div class="flex items-center justify-center gap-2 text-center mt-4">
                <button type="submit" class="mt-4 tab-btn w-full md:w-auto text-white text-sm sm:text-base flex items-center justify-center gap-1 sm:gap-2 font-normal capitalize border-opacity-50 rounded-md px-2 sm:px-3 py-2 bg-gradient-to-t from-[#6B3FB9] to-indigo-500 border border-[#BD97FF] hover:from-[#7C4BC7] hover:to-indigo-600 transition-all duration-200">
                    Submit Event Details
                </button>
            </div>
        </form>
    </div>
</div>
<!-- Modal Backdrop -->
<div id="notifyModal" class="hidden fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-[999] p-4">
    <div class="relative w-full max-w-md md:max-w-lg lg:max-w-xl bg-[#06050c] rounded-lg overflow-hidden shadow-lg p-1">
        <!-- Close Icon -->
        <!-- Close Button -->
        <button onclick="closeNotifyModal()" class="absolute top-0 right-0 rounded-full p-2 shadow-md bg-red-500 text-white transition-all duration-200">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 8.586L15.95 2.636a1 1 0 1 1 1.414 1.414L11.414 10l5.95 5.95a1 1 0 0 1-1.414 1.414L10 11.414l-5.95 5.95a1 1 0 0 1-1.414-1.414L8.586 10 2.636 4.05a1 1 0 1 1 1.414-1.414L10 8.586z" clip-rule="evenodd" />
            </svg>
        </button>
        <!-- Responsive Image -->
        <!-- <img 
            src="{{ asset('assets/images/stablebonds/stablebonds.webp') }}" 
            alt="Popup Image" 
            class="max-w-full w-auto h-auto max-h-[300px] mx-auto mb-5 object-contain max-h-[90vh] border border-[#ae83fe] rounded-lg"
        > -->
        <div class="mt-4  max-h-[90vh] overflow-auto bg-[#1a1925] border border-[#ae83fe] rounded-lg p-4 text-white space-y-3">
            <h3 class="text-lg font-semibold text-purple-300">Dear OrbitX Family,</h3>
            <p class="text-sm leading-relaxed">
                You already know that the <span class="font-bold text-yellow-300">Thailand Luxury & Learning Trip</span> qualification target is ongoing, and the duration is from <span class="text-green-400">1st August to 31st August</span>. 🌴✨
            </p>

            <ul class="list-disc list-inside text-sm space-y-1">
                <li>✅ To qualify, you must stake in <span class="text-purple-400 font-semibold">Stable Bond</span>, where you will also receive extra tokens depending on your staking period.</li>
                <li>⚠️ <span class="font-semibold text-red-400">Important Notice:</span> If anyone unstakes from their existing ID and then puts the same amount into Stable Bond, it will NOT be considered as a valid qualification for the trip.</li>
                <li>🌍 The trip will be considered qualified only if the required amount is staked as an <span class="font-semibold text-blue-400">addon/top-up</span> in Stable Bond or through a fresh ID.</li>
            </ul>

            <p class="text-sm leading-relaxed text-green-300 font-medium">
                Let’s secure our positions and get ready for an unforgettable Thailand experience! 🌏✈️
            </p>
        </div>
    </div>
</div>
<!-- JS to Open/Close Modal -->
<!-- <script>
    function closeNotifyModal() {
        const modal = document.getElementById('notifyModal');
        modal.style.display = 'none';
    }

    // Auto-open on page load
    window.addEventListener('DOMContentLoaded', () => {
        document.getElementById('notifyModal').style.display = 'flex';
    });
</script> -->
<script>
function openFormEvent() {
    document.getElementById('fillFormEvent').classList.remove('hidden');
}
function closeFormEvent() {
    document.getElementById('fillFormEvent').classList.add('hidden');
}
</script>

<x-affiliate-modal
    link="https://{{ request()->getHost() }}/connect-wallet?sponser_code={{Session::get('wallet_address')}}"
    referrer="{{$data['sponser']['wallet_address']}}"
    :paths="['/my/stake', '/my/lpbonds', '/my/stablebonds']" />

<script src="{{asset('web3/ethers.umd.min.js')}}"></script>
<script>
  (function () {
    // --- Settings ---
    const PERIOD_ROI       = 0.0035; // 0.35% per 12 hours
    const PERIODS_PER_DAY  = 2;      // 12-hour compounding
    const rtxPrice = {{$data['rtxPrice']}};

    const $amount = document.getElementById('amount');
    const $apy    = document.getElementById('apy');
    const $apyUsd    = document.getElementById('apyUsd');

    function parseAmount(str) {
      if (!str) return 0;
      const n = parseFloat(String(str).replace(/[, ]+/g, ''));
      return isFinite(n) ? n : 0;
    }

    function fmt(n) {
      return (isFinite(n) ? n : 0).toLocaleString(undefined, { maximumFractionDigits: 2 });
    }

    function getSelectedDays() {
      const el = document.querySelector('input[name="days"]:checked');
      return el ? parseInt(el.value, 10) : 0;
    }

    // Compounded every 12 hours: total = amount * (1 + r)^(days * 2)
    function compoundedTotal(amount, days) {
      if (!amount || !days) return 0;
      const periods = days * PERIODS_PER_DAY;
      return amount * Math.pow(1 + PERIOD_ROI, periods);
    }

    function update() {
      const amt  = parseAmount($amount.value);
      const days = getSelectedDays();

      const total = compoundedTotal(amt, days);        // principal + ROI
      // If you want only the earned ROI, use: const earned = total - amt;

      $apy.value = fmt(total); // show total compounded amount in RTX
      $apyUsd.value = fmt(total * rtxPrice);
    }

    $amount.addEventListener('input', update);
    document.querySelectorAll('input[name="days"]').forEach(r => r.addEventListener('change', update));

    const form = document.getElementById('apy-static-form');
    if (form) {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        update();
      });
    }

    update(); // initial
  })();
</script>
<script src="{{asset('web3/web3.min.js')}}"></script>

<script>
    @if(!Session::has('admin_user_id'))

    async function checkWalletAddress() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        // Get the stored address from wherever it's stored (e.g., local storage)
        var storedAddress = "{{ Session::get('wallet_address') }}"

        // Get the connected wallet address
        var addressConnected = await window.ethereum.request({
            method: 'eth_requestAccounts'
        }); // Replace with your code to get the connected address

        // Compare the stored and connected addresses
        if (storedAddress.toLowerCase() !== addressConnected[0].toLowerCase()) {
            // Call your function or perform the desired action
            // handleAccountChange(addressConnected); // Replace with the function you want to call
            showToast("error", "Wallet Address Mismatch! Please connect the correct wallet address.");

            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '';

            // Add CSRF token
            var token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = csrfToken;
            form.appendChild(token);

            document.body.appendChild(form);
            setTimeout(function() {
                form.submit();
            }, 300);
        }
    }

    setInterval(checkWalletAddress, 1500); // Call checkWalletAddress() every 5 seconds (5000 milliseconds)

    @endif
</script>

@endsection

<script src="{{asset('assets/js/apexcharts.js')}}"></script>