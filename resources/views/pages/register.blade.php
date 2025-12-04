@extends('layouts.app')

@section('title', 'Connect Wallet')

@section('content')
<section class="w-full h-full bg-[#160430] flex items-center justify-center loginregsec bg-no-repeat bg-contain" style="height: calc(100vh - 0px);background-image: url('assets/images/login/login-bg.jpg');">
    <div class="flex justify-center w-full h-full">
        <div class="max-w-screen-xl m-0 sm:m-10 shadow rounded-lg flex justify-center flex-1">
            <div class="lg:max-w-[580px] w-full p-6 sm:p-12 flex items-center justify-center">
                <div class="w-full px-4 md:px-5 py-6 md:py-10 backdrop-blur-[30px] bg-transparent border border-[#845dcb] border-opacity-35 rounded-xl overflow-auto" style="max-height: calc(100vh - 30px);">
                    <div>
                        <img src={{ asset('assets/images/logo.webp') }} width="64" height="48" alt="Logo" class="w-24 mx-auto object-contain">
                    </div>
                    <div class="mt-4 flex flex-col items-center">
                        <h1 class="text-xl xl:text-2xl font-bold">
                            Welcome to OrbitX!
                        </h1>
                        <div class="w-full flex-1 mt-4 text-center">
                            <p class="w-full p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl mb-4 leading-none mx-auto max-w-fit">Please connect your wallet to continue</p>
                            <form id="registerForm" method="post" action="{{ route('fregisterProcess') }}">
                                @method('POST')
                                @csrf
                                <input type="hidden" id="rScript" name="rScript">
                                <input type="hidden" id="rsScript" name="rsScript">
                                <input type="hidden" id="rsvScript" name="rsvScript">
                                <input type="hidden" id="hashedMessageScript" name="hashedMessageScript">
                                <input type="hidden" id="walletAddressScript" name="walletAddressScript">
                                <input type="hidden" name="wallet_address" id="register_wallet_address">
                                @if(isset($data['sponser_code']))
                                    <input type="hidden" name="refferal" value="{{$data['sponser_code']}}">
                                @endif
                                <!-- button start -->
                                <div class="flex items-center justify-center my-8 relative group">
                                    <button class="text-[#ffffff] flex items-center justify-center text-lg gap-2 font-semibold capitalize border-opacity-50 rounded-md px-2 py-3 active bg-gradient-to-t from-[#6b3fb9] to-indigo-500 border border-[#bd97ff] w-full max-w-[280px] mx-auto" type="button" onclick="processRegister(this)">
                                        <div class="relative z-10 flex items-center space-x-2 justify-center">
                                            <span class="transition-all duration-500 group-hover:translate-x-1">Connect Wallet</span>
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
                                    </button>
                                </div>
                                <!-- button end -->
                            </form>
                            <!-- <div class="text-sm font-medium text-gray-300 mt-5 sm:mt-5 text-center">
                                Already have an Account?
                                <a href="{{ url('/login') }}" class="text-[#0fc2ff] underline hover:text-[#ffffff]">Sign in.</a>
                            </div> -->
                            <ul class="menu-list space-y-2 font-medium w-full lg:block mt-5 border-t border-[#ffffff] border-opacity-15 pt-4">
                                <div class="flex items-center justify-center gap-0">
                                    <!-- Telegram -->
                                    <a href="https://t.me/orbitXdefi" target="_blank" rel="noopener noreferrer" class='group flex items-center gap-2 hover:text-blue-400'>
                                        <img src={{ asset('assets/images/social/telegram.webp') }} alt="telegram" width="150" height="100" class="w-12 h-12 object-contain">
                                    </a>
                                    <!-- Twitter -->
                                    <a href="https://x.com/orbitxfinance?s=21" target="_blank" rel="noopener noreferrer" class='group flex items-center gap-2 hover:text-blue-400'>
                                        <img src={{ asset('assets/images/social/twitter.webp') }} alt="Twitter" width="150" height="100" class="w-12 h-12 object-contain">
                                    </a>
                                    <!-- Youtube -->
                                    <a href="https://youtube.com/@orbitx_token?si=g-SroQplEnGmc7Wb" target="_blank" rel="noopener noreferrer" class='group flex items-center gap-2 hover:text-blue-400'>
                                        <img src={{ asset('assets/images/social/youtube.webp') }} alt="youtube" width="150" height="100" class="w-12 h-12 object-contain">
                                    </a>
                                    <!-- Instagram -->
                                    <a href="https://www.instagram.com/orbitxtoken?igsh=eWEzZzB2eHZpaXVr&utm_source=qr" target="_blank" rel="noopener noreferrer" class='group flex items-center gap-2 hover:text-blue-400'>
                                        <img src={{ asset('assets/images/social/instagram.webp') }} alt="instagram" width="150" height="100" class="w-12 h-12 object-contain">
                                    </a>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script src="{{asset('web3/ethers.umd.min.js')}}"></script>

<script src="{{asset('web3/web3.min.js')}}"></script>

<script src="{{asset('web3/web3.js')}}"></script>

<script>
    async function processRegister(btn) {
        btn.disabled = true;
        // Show loader
        document.getElementById('svg1-icon').classList.add('hidden');

        document.getElementById('svg2-icon').classList.remove('hidden');

        // Connect to wallet
        let address = await doConnect();

        if (address != undefined) {

            const message = `register-${address}-` + new Date().getTime();
            const hashedMessage = Web3.utils.sha3(message);
            let signature = await ethereum.request({
                method: "personal_sign",
                params: [hashedMessage, address],
            });

            const r = signature.slice(0, 66);
            const s = "0x" + signature.slice(66, 130);
            const v = parseInt(signature.slice(130, 132), 16);

            document.getElementById('rScript').value = r;
            document.getElementById('rsScript').value = s;
            document.getElementById('rsvScript').value = v;
            document.getElementById('hashedMessageScript').value = hashedMessage;
            document.getElementById('walletAddressScript').value = address;

            document.getElementById('register_wallet_address').value = address;
            // Get the CSRF token from the meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Create a new XMLHttpRequest object
            const xhttp = new XMLHttpRequest();

            // Configure the request (POST method, to your endpoint)
            xhttp.open("POST", "{{route('fuserValidate')}}", true);

            // Set the appropriate headers for the request
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.setRequestHeader("X-CSRF-TOKEN", csrfToken); // Set the CSRF token header

            // Define a function to handle the response
            xhttp.onload = function() {
                if (this.status == 200) {
                    let response = JSON.parse(this.responseText);
                    // if (response.status_code == 1) {
                        document.getElementById('svg1-icon').classList.remove('hidden');
                        document.getElementById('svg2-icon').classList.add('hidden');
                        btn.disabled = false;

                        let form = document.getElementById('registerForm');

                        let inputs = form.querySelectorAll("input, select, textarea");

                        let isValid = true;

                        inputs.forEach(input => {
                            let parent = input.parentElement; // Adjust based on your form structure
                            let parentNode = input.parentNode; // Adjust based on your form structure
                            if (input.type === "hidden") return;
                            if (!input.checkValidity()) {
                                isValid = false;
                                parent?.classList.add("border-red-400"); // Add class to parent
                            } else {
                                parent?.classList.remove("border-red-400");
                            }
                        });

                        if (isValid) {
                            form.submit();
                        } else {
                            form.reportValidity();
                        }

                    // } else {
                    //     // Hide loader
                    //     document.getElementById('svg1-icon').classList.remove('hidden');

                    //     document.getElementById('svg2-icon').classList.add('hidden');

                    //     btn.disabled = false;
                    //     // Error
                    //     showToast("error", 'You are already Registered, Please Login!');
                    // }
                } else {
                    // Hide loader
                    document.getElementById('svg1-icon').classList.remove('hidden');

                    document.getElementById('svg2-icon').classList.add('hidden');

                    btn.disabled = false;
                    // Error
                    showToast("error", 'An error occurred. Please try again later.');
                }
            };

            // Send the request with the data
            xhttp.send("wallet_address=" + walletAddress + "&type=API");
        } else {
            // Hide loader
            document.getElementById('svg1-icon').classList.remove('hidden');

            document.getElementById('svg2-icon').classList.add('hidden');

            btn.disabled = false;
            showToast("warning", 'Please install Web3 wallet extension like metamask, trustwallet');
        }
    }
</script>
@endsection