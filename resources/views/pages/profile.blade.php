@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<section class="w-full p-3 md:p-5 mx-auto max-w-[1400px]">
    <div class="grid grid-cols-1 xl:grid-cols-4">
        <div class="cols-span-1 xl:col-span-1"></div>
        <div class="cols-span-1 xl:col-span-2 grid-cols-1 grid">
            <div class="cols-span-1 grid grid-cols-1">
                <div class="w-full p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl">
                    <!-- Referral Link Card -->
                    <form class="" method="post" action="{{ route('fprofileUpdate') }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="rankinginfo3 boxbgsvg1 bg-black relative border border-[#000000] p-4 rounded-lg flex items-center justify-between">
                            <div class="flex items-center space-x-3 w-full">
                                <img src="http://localhost:8000/assets/images/logo.webp" width="64" height="64" alt="Logo" class="w-16 h-auto">
                                <div class="w-full">
                                    <h3 class="text-lg text-white mb-2 leading-none">User Profile</h3>
                                    <div class="mx-auto">
                                        <input type="file" name="file" class="block w-full text-sm file:mr-4 file:rounded-md file:border-0 file:bg-[#32a7e2] file:py-2.5 file:px-4 file:text-sm file:font-semibold file:text-white hover:file:bg-[#32a7e2] focus:outline-none disabled:pointer-events-none disabled:opacity-60" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4 w-full flex-1 mt-4 text-center mx-auto space-y-4">
                            <div class="text-left">
                                <label for="name" class="block text-xs text-white text-opacity-70 font-medium mb-2">Name</label>
                                <div class="relative flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-black bg-opacity-50">
                                    <input type="text" id="name" name="name" value="{{$data['data']['name']}}" placeholder="Enter Name" class="border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base" required="" aria-describedby="hs-validation-name-success-helper">
                                    @if($data['data']['name'] != null)
                                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                        <svg class="shrink-0 size-4 text-teal-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="text-left">
                                <label for="walletaddress" class="block text-xs text-white text-opacity-70 font-medium mb-2">Wallet Address</label>
                                <div class="relative flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-black bg-opacity-50">
                                    <input type="text" id="walletaddress" name="wallet_address" value="{{$data['data']['wallet_address']}}" placeholder="Enter Wallet Address" class="border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base" required="" aria-describedby="hs-validation-name-success-helper">
                                    @if($data['data']['wallet_address'] != null)
                                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                        <svg class="shrink-0 size-4 text-teal-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="text-left">
                                <label for="email" class="block text-xs text-white text-opacity-70 font-medium mb-2">Email</label>
                                <div class="relative flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-black bg-opacity-50">
                                    <input type="email" id="email" name="email" value="{{$data['data']['email']}}" placeholder="Enter Email" class="border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base" required="" aria-describedby="hs-validation-name-success-helper">
                                    @if($data['data']['email'] != null)
                                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                        <svg class="shrink-0 size-4 text-teal-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="text-left">
                                <label for="mobile_number" class="block text-xs text-white text-opacity-70 font-medium mb-2">Mobile Number</label>
                                <div class="relative flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-black bg-opacity-50">
                                    <input type="text" id="mobile_number" name="mobile_number" value="{{$data['data']['mobile_number']}}" placeholder="Enter Mobile Number" class="border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base" required="" aria-describedby="hs-validation-name-success-helper">
                                    @if($data['data']['mobile_number'] != null)
                                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                        <svg class="shrink-0 size-4 text-teal-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- button start -->
                            <div class="flex items-center justify-center py-2 sm:py-4 relative group">
                                <button class="w-full max-w-fit relative inline-block p-px font-semibold leading-none text-white cursor-pointer rounded-sm" type="submit">
                                    <span class="absolute inset-0 rounded-sm bg-gradient-to-r from-teal-400 via-blue-500 to-purple-500 p-[2px]"></span>
                                    <span class="relative z-10 block px-6 py-3 rounded-sm">
                                        <div class="relative z-10 flex items-center space-x-2 justify-center">
                                            <span class="transition-all duration-500 group-hover:translate-x-1">Update</span>
                                            <svg class="w-6 h-6 transition-transform duration-500 group-hover:translate-x-1" data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path clip-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" fill-rule="evenodd"></path>
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
        <div class="cols-span-1 xl:col-span-1"></div>
        <div class="grid-cols-1 grid gap-5 hidden">
            <div class="p-4 rounded-xl w-full mx-auto border border-[#2b2b2f] bg-black relative boxbgsvg1">
                <div class="p-4 rounded-xl w-full mx-auto border border-[#2b2b2f] bg-black relative overflow-hidden space-y-4 rankinginfo mb-6">
                    <div class="boxbgsvg1 bg-black bg-opacity-35 relative border border-[#000000] border-opacity-10 p-4 rounded-lg flex items-center justify-between">
                        <div class="flex flex-wrap sm:flex-nowrap items-center sm:space-x-3 w-full">
                            <img src={{ asset('assets/images/logo.webp') }} width="64" height="48" alt="Logo" class="w-12 h-auto">
                            <div class="w-full mt-2 sm:mt-0">
                                <h3 class="text-base mb-2 leading-none">Orbit-X Referral Link</h3>
                                <div class="bg-white bg-opacity-10 px-2 py-0.5 leading-none rounded flex items-center justify-between">
                                    <span id="referral-link" class="text-xs truncate text-ellipsis overflow-hidden">https://{{ request()->getHost() }}/register?sponser_code=@if(Session::has('refferal_code')){{ Session::get('refferal_code')}}@endif</span>
                                    <button onclick="copyReferrallink(); showToast('success', 'Copied to clipboard!')" class="ml-2 p-1 border-l border-white border-opacity-20">
                                        <svg class="w-7 h-7 min-w-7 min-h-7 ml-2" viewBox="0 0 1024 1024">
                                            <path fill="#30b8f5" d="M768 832a128 128 0 0 1-128 128H192A128 128 0 0 1 64 832V384a128 128 0 0 1 128-128v64a64 64 0 0 0-64 64v448a64 64 0 0 0 64 64h448a64 64 0 0 0 64-64h64z" />
                                            <path fill="#30b8f5" d="M384 128a64 64 0 0 0-64 64v448a64 64 0 0 0 64 64h448a64 64 0 0 0 64-64V192a64 64 0 0 0-64-64H384zm0-64h448a128 128 0 0 1 128 128v448a128 128 0 0 1-128 128H384a128 128 0 0 1-128-128V192A128 128 0 0 1 384 64z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    function copyReferrallink() {
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
                <form method="post" action="{{ route('fpasswordUpdate') }}" class="space-y-4">
                    <div class="relative space-y-5">
                        <!-- old password -->
                        <div class="relative flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-black bg-opacity-50">
                            <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="16" r="2" stroke="#ffffff" stroke-width="1.5" />
                                <path d="M6 10V8C6 7.65929 6.0284 7.32521 6.08296 7M18 10V8C18 4.68629 15.3137 2 12 2C10.208 2 8.59942 2.78563 7.5 4.03126" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M11 22H8C5.17157 22 3.75736 22 2.87868 21.1213C2 20.2426 2 18.8284 2 16C2 13.1716 2 11.7574 2.87868 10.8787C3.75736 10 5.17157 10 8 10H16C18.8284 10 20.2426 10 21.1213 10.8787C22 11.7574 22 13.1716 22 16C22 18.8284 22 20.2426 21.1213 21.1213C20.2426 22 18.8284 22 16 22H15" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            <input type="password" name="old_password" id="old_password" placeholder="Old Password" required="required" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base">
                        </div>
                        <!-- New password -->
                        <div class="relative flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-black bg-opacity-50">
                            <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none">
                                <path d="M21 13V8C21 6.89543 20.1046 6 19 6H5C3.89543 6 3 6.89543 3 8V14C3 15.1046 3.89543 16 5 16H12" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M14.5 18.5L16.5 20.5L20.5 16.5" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 11.01L12.01 10.9989" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M16 11.01L16.01 10.9989" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M8 11.01L8.01 10.9989" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <input type="password" name="new_password" id="new_password" placeholder="New Password" required="required" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base">
                        </div>
                        <!-- Reset password -->
                        <div class="relative flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-black bg-opacity-50">
                            <svg class="w-7 h-7 min-w-7 min-h-7" viewBox="0 0 24 24" fill="none">
                                <path d="M21 13V8C21 6.89543 20.1046 6 19 6H5C3.89543 6 3 6.89543 3 8V14C3 15.1046 3.89543 16 5 16H12" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.8789 16.9174C21.3727 17.2211 21.3423 17.9604 20.8337 18.0181L18.2671 18.309L17.1159 20.6213C16.8878 21.0795 16.1827 20.8552 16.0661 20.2873L14.8108 14.1713C14.7123 13.6913 15.1437 13.3892 15.561 13.646L20.8789 16.9174Z" stroke="#ffffff" stroke-width="1.5" />
                                <path d="M12 11.01L12.01 10.9989" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M16 11.01L16.01 10.9989" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M8 11.01L8.01 10.9989" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <input type="password" name="confirm_password" id="confirm_password" placeholder="Repeat password" required="required" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base">
                        </div>
                    </div>

                    <!-- button start -->
                    <div class="flex items-center justify-center my-4 sm:my-8 relative group">
                        <button class="w-full max-w-fit relative inline-block p-px font-semibold leading-none text-white cursor-pointer rounded-sm">
                            <span class="absolute inset-0 rounded-sm bg-gradient-to-r from-teal-400 via-blue-500 to-purple-500 p-[2px]"></span>
                            <span class="relative z-10 block px-6 py-3 rounded-sm">
                                <div class="relative z-10 flex items-center space-x-2 justify-center">
                                    <span class="transition-all duration-500 group-hover:translate-x-1">Reset Password</span>
                                    <svg class="w-6 h-6 transition-transform duration-500 group-hover:translate-x-1" data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path clip-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" fill-rule="evenodd"></path>
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
    </div>
</section>
@endsection