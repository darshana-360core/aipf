@extends('layouts.app')

@section('title', 'Activate Package (USDT)')

@section('content')
<section class="w-full p-3 md:p-5 mx-auto max-w-[1400px]">
    <div class="grid grid-cols-1 gap-5 relative z-10">
        <!-- <div class="grid grid-cols-1 md:my-4"></div> -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 mt-4">
            <div class="grid-cols-1 grid gap-5">
                <div class="p-4 rounded-xl w-full mx-auto border border-[#2b2b2f] bg-black relative boxbgsvg1">
                    <h3 class="font-bold text-xl md:text-2xl mb-2">Activate Package By Transfer Balance</h3>
                    <div class="bg-white bg-opacity-20 p-4 leading-none rounded flex items-center justify-between mb-4">
                        <p class="mr-2">Tranfer Balance</p>
                        <span>$19528</span>
                    </div>
                    <form class="relative">
                        <!-- Calculator -->
                        <div class="relative mb-8 flex items-center justify-between border border-white border-opacity-30 p-3 rounded gap-3 bg-black bg-opacity-50">
                            <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none">
                                <path d="M21 12C21 16.714 21 19.0711 19.682 20.5355C18.364 22 16.2426 22 12 22C7.75736 22 5.63604 22 4.31802 20.5355C3 19.0711 3 16.714 3 12C3 7.28595 3 4.92893 4.31802 3.46447C5.63604 2 7.75736 2 12 2C16.2426 2 18.364 2 19.682 3.46447C20.5583 4.43821 20.852 5.80655 20.9504 8" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M7 8C7 7.53501 7 7.30252 7.05111 7.11177C7.18981 6.59413 7.59413 6.18981 8.11177 6.05111C8.30252 6 8.53501 6 9 6H15C15.465 6 15.6975 6 15.8882 6.05111C16.4059 6.18981 16.8102 6.59413 16.9489 7.11177C17 7.30252 17 7.53501 17 8C17 8.46499 17 8.69748 16.9489 8.88823C16.8102 9.40587 16.4059 9.81019 15.8882 9.94889C15.6975 10 15.465 10 15 10H9C8.53501 10 8.30252 10 8.11177 9.94889C7.59413 9.81019 7.18981 9.40587 7.05111 8.88823C7 8.69748 7 8.46499 7 8Z" stroke="#ffffff" stroke-width="1.5" />
                                <circle cx="8" cy="13" r="1" fill="#ffffff" />
                                <circle cx="8" cy="17" r="1" fill="#ffffff" />
                                <circle cx="12" cy="13" r="1" fill="#ffffff" />
                                <circle cx="12" cy="17" r="1" fill="#ffffff" />
                                <circle cx="16" cy="13" r="1" fill="#ffffff" />
                                <circle cx="16" cy="17" r="1" fill="#ffffff" />
                            </svg>
                            <input type="text" name="calculator" id="calculator" placeholder="0.0" required="required" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base">
                        </div>

                        <!-- button Process start -->
                        <div class="flex items-center justify-center my-4 relative group">
                            <button class="w-full relative inline-block p-px font-semibold leading-none text-white cursor-pointer rounded-sm">
                                <span class="absolute inset-0 rounded-sm bg-gradient-to-r from-teal-400 via-blue-500 to-purple-500 p-[2px]"></span>
                                <span class="relative z-10 block px-6 py-3 rounded-sm">
                                    <div class="relative z-10 flex items-center space-x-2 justify-center">
                                        <span class="transition-all duration-500 group-hover:translate-x-1">Process</span>
                                        <svg class="w-6 h-6 transition-transform duration-500 group-hover:translate-x-1" data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path clip-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" fill-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </span>
                            </button>
                        </div>
                        <!-- button Process end -->
                    </form>
                </div>
            </div>
            <div class="cols-span-1 grid grid-cols-1">
                <div class="w-full p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl">
                    <div class="p-4 md:p-5 rounded-xl w-full mx-auto border border-[#2b2b2f] bg-[#000] rankinginfo relative">
                        <!-- <img src="http://localhost:8000/assets/images/rank/1.webp" width="60" height="60" class="w-auto h-16 p-1.5" alt="Rank 1"> -->
                        <h3 class="font-bold text-xl md:text-2xl mb-2">Packages History</h3>
                        <p class="font-normal text-lg my-1">Your referrer :</p>
                        <div class="bg-black bg-opacity-20 px-2 py-0.5 leading-none rounded flex items-center justify-between">
                            <span id="copyYourReferral" class="text-lg truncate text-ellipsis overflow-hidden">000000</span>
                            <button onclick="copyYourReferral(); showToast('success', 'Copied to clipboard!')" class="ml-2 p-1 border-l border-white border-opacity-20">
                                <svg class="w-6 h-6 min-w-6 min-h-6 ml-2" viewBox="0 0 1024 1024">
                                    <path fill="#ffffff" d="M768 832a128 128 0 0 1-128 128H192A128 128 0 0 1 64 832V384a128 128 0 0 1 128-128v64a64 64 0 0 0-64 64v448a64 64 0 0 0 64 64h448a64 64 0 0 0 64-64h64z" />
                                    <path fill="#ffffff" d="M384 128a64 64 0 0 0-64 64v448a64 64 0 0 0 64 64h448a64 64 0 0 0 64-64V192a64 64 0 0 0-64-64H384zm0-64h448a128 128 0 0 1 128 128v448a128 128 0 0 1-128 128H384a128 128 0 0 1-128-128V192A128 128 0 0 1 384 64z" />
                                </svg>
                            </button>
                        </div>
                        <script>
                            function copyYourReferral() {
                                const linkElement = document.getElementById("copyYourReferral");
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
                    </div>
                    <div class="w-full flex-1 mt-4 text-center mx-auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-2 gap-5">
                            <div class="boxbgsvg relative border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
                                <div class="flex items-center space-x-3 w-full gap-1">
                                    <div class="text-2xl flex items-center justify-center w-12 h-12 min-w-12 min-h-12 rounded-full border border-white border-opacity-15 bg-white bg-opacity-10 text-center">1</div>
                                    <div class="w-full">
                                        <h3 class="text-base mb-2 opacity-75 leading-none">#1</h3>
                                        <span class="text-base font-semibold">$100</span>
                                    </div>
                                </div>
                            </div>
                            <div class="boxbgsvg relative border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
                                <div class="flex items-center space-x-3 w-full gap-1">
                                    <div class="text-2xl flex items-center justify-center w-12 h-12 min-w-12 min-h-12 rounded-full border border-white border-opacity-15 bg-white bg-opacity-10 text-center">2</div>
                                    <div class="w-full">
                                        <h3 class="text-base mb-2 opacity-75 leading-none">#2</h3>
                                        <span class="text-base font-semibold">$10</span>
                                    </div>
                                </div>
                            </div>
                            <div class="boxbgsvg relative border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
                                <div class="flex items-center space-x-3 w-full gap-1">
                                    <div class="text-2xl flex items-center justify-center w-12 h-12 min-w-12 min-h-12 rounded-full border border-white border-opacity-15 bg-white bg-opacity-10 text-center">3</div>
                                    <div class="w-full">
                                        <h3 class="text-base mb-2 opacity-75 leading-none">#3</h3>
                                        <span class="text-base font-semibold">$25000</span>
                                    </div>
                                </div>
                            </div>
                            <div class="boxbgsvg relative border border-[#2b2b2f] p-4 rounded-lg shadow-md flex items-center justify-between text-left">
                                <div class="flex items-center space-x-3 w-full gap-1">
                                    <div class="text-2xl flex items-center justify-center w-12 h-12 min-w-12 min-h-12 rounded-full border border-white border-opacity-15 bg-white bg-opacity-10 text-center">4</div>
                                    <div class="w-full">
                                        <h3 class="text-base mb-2 opacity-75 leading-none">#4</h3>
                                        <span class="text-base font-semibold">$100</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection