<div id="message" class="fixed bottom-3 max-w-[93%] right-3 z-[52] rankinginfo3 bg-gray-600 text-white p-2 rounded shadow leading-none opacity-0 translate-y-15 transition-all duration-500"></div>
<!-- Footer -->
<footer class="sticky top-full mt-12 md:mt-10 z-[51]">
    <div class="max-w-[1420px] mx-auto px-3 py-3 bg-[#121222] border border-[#322751] rounded-xl flex flex-col md:flex-row items-center justify-between gap-4">
        <span class="text-sm text-white">
            &copy; {{ date('Y') }} Orbit-X • All rights reserved.
        </span>
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
    </div>
</footer>
<script>
    function displayToster(msg) {
        const message = document.getElementById('message');
        message.innerHTML = msg;
        message.classList.remove('opacity-0', 'translate-y-15');
        message.classList.add('opacity-100', 'translate-y-0');
        setTimeout(function() {
            message.classList.remove('opacity-100', 'translate-y-0');
            message.classList.add('opacity-0', 'translate-y-15');
        }, 3000);
    }
</script>