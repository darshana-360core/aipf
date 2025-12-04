@extends('layouts.app')

@section('title', 'Technical Upgradation')

@section('content')
<section class="w-full h-full bg-[#160430] flex items-center justify-center loginregsec bg-no-repeat bg-contain" style="height: calc(100vh - 0px);background-image: url('assets/images/login/login-bg.jpg');">
  <div class="flex justify-center w-full h-full">
    <div class="max-w-screen-xl m-0 sm:m-10 shadow rounded-lg flex justify-center flex-1">
      <div class="lg:max-w-[580px] w-full p-6 sm:p-12 flex items-center justify-center">
        <div class="w-full px-4 md:px-5 py-6 md:py-10 backdrop-blur-[30px] bg-transparent border border-red-400 border-opacity-35 rounded-xl overflow-auto" style="max-height: calc(100vh - 30px);">
          <div>
            <img src={{ asset('assets/images/logo.webp') }} width="64" height="48" alt="Logo" class="w-24 mx-auto object-contain">
          </div>
          <div class="mt-4 flex flex-col items-center">
            <h1 class="text-xl xl:text-2xl font-bold mb-3 text-white">
              Technical Upgradation!
            </h1>
            <!-- <p class="w-full p-4 md:p-5 bg-[#171531] border border-red-300 text-red-300 rounded-xl mb-4 leading-none mx-auto max-w-fit"> The server returned a "503 Service Unavailable".</p> -->
            <div class="w-full flex-1 text-center">
              <p class="w-full mb-2 leading-[1.2] mx-auto max-w-fit">
                We’re currently performing a technical upgrade to enhance system performance and reliability.

During this process, some features may be temporarily unavailable.
Our team is working diligently to complete the upgrade as quickly as possible.

We apologize for any inconvenience and appreciate your patience.
              </p>
              <div class="mx-auto max-w-sm mt-8">
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
  </div>
</section>
@endsection

@section('script')

@endsection