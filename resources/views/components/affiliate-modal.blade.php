@props([
'link' => '',
'referrer' => null,
'paths' => ['/my/stake', '/my/lpbonds', '/my/stablebonds'],
])

@php
$defaultPath = $paths[0];
$generatedLink = $link ?? url($defaultPath) . '?ref=abcd12';
@endphp

<div id="affiliate-modal" class="fixed inset-0 z-[9999] bg-black/60 hidden flex items-center justify-center">
    <div class="bg-[#20202a] rounded-2xl p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto border border-[#322751] relative">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-white">Affiliate Manager</h2>
            <button onclick="document.getElementById('affiliate-modal').classList.add('hidden')" class="text-gray-400 hover:text-white">✖</button>
        </div>

        @if (!$link)
        <div class="text-center py-8 text-gray-400">Connect your wallet to manage affiliate links</div>
        @else
        {{-- Referral Info --}}
        @if ($referrer)
        <div class="bg-blue-900/20 border border-blue-700/30 rounded-lg p-4 mb-4">
            <h3 class="text-sm font-semibold text-blue-400 mb-2">You were referred by</h3>
            <p class="text-blue-300 font-mono">{{$referrer}}</p>
        </div>
        @endif

        {{-- Target Page Dropdown --}}
        <!-- <div class="mb-4">
            {{ substr($referrer, 0, 6) }}...{{ substr($referrer, -4) }}
            <label class="block text-sm font-medium text-gray-300 mb-2">Target Page</label>
            <select id="targetPath" onchange="updateAffiliateLink()" class="w-full bg-[#2a2a35] border border-[#322751] rounded-lg px-3 py-2 text-white">
                @foreach ($paths as $path)
                <option value="{{ $path }}">{{ $path }}</option>
                @endforeach
            </select>
        </div> -->

        {{-- Referral Link --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-2">Referral Link</label>
            <div class="flex gap-2">
                <input type="text" id="generatedLink" value="{{ $generatedLink }}" readonly class="flex-1 bg-[#2a2a35] border border-[#322751] rounded-lg px-3 py-2 text-white text-sm font-mono">
                <button onclick="copyReferralLink(document.getElementById('generatedLink').value)" class="bg-[#845dcb] text-white px-4 py-2 rounded-lg">Copy</button>
            </div>
        </div>

        {{-- Share + QR Actions --}}
        <div class="flex gap-3 mb-4">
            <button onclick="shareReferralLink()" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                </svg>
                Share
            </button>
            <button onclick="toggleQRCode()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                </svg>
                QR Code
            </button>
        </div>

        {{-- QR Code Display --}}
        <div id="qrcodeContainer" class="hidden text-center py-4">
            <div id="qrcode" class="inline-block bg-white p-4 rounded-lg"></div>
            <p class="text-xs text-gray-400 mt-2">Scan with mobile device to share easily</p>
        </div>

        {{-- Social Media Sharing --}}
        <div class="bg-[#1a1a23] rounded-lg p-4 mt-4">
            <h3 class="text-sm font-semibold text-white mb-4">Share on Social Media</h3>
            <div class="grid grid-cols-3 gap-3">
                @foreach ([
                ['platform' => 'twitter', 'label' => 'Twitter', 'color' => 'bg-[#1da1f2]'],
                ['platform' => 'facebook', 'label' => 'Facebook', 'color' => 'bg-[#4267b2]'],
                ['platform' => 'telegram', 'label' => 'Telegram', 'color' => 'bg-[#0088cc]'],
                ['platform' => 'whatsapp', 'label' => 'WhatsApp', 'color' => 'bg-[#25d366]'],
                ['platform' => 'linkedin', 'label' => 'LinkedIn', 'color' => 'bg-[#0077b5]'],
                ['platform' => 'reddit', 'label' => 'Reddit', 'color' => 'bg-[#ff4500]'],
                ] as $social)
                <button onclick="shareTo('{{ $social['platform'] }}')" class="{{ $social['color'] }} hover:opacity-80 text-white py-2 px-3 rounded-lg text-sm">
                    {{ $social['label'] }}
                </button>
                @endforeach
            </div>
        </div>

        {{-- Affiliate Tips --}}
        <div class="bg-yellow-900/20 border border-yellow-700/30 rounded-lg p-4 mt-4">
            <h3 class="text-sm font-semibold text-yellow-400 mb-2">💡 Affiliate Tips</h3>
            <ul class="text-xs text-yellow-300 space-y-1">
                <li>• Share your link on social media to reach more people</li>
                <li>• Target specific staking pages based on your audience's interests</li>
                <li>• Referral links never expire and are tied to your wallet address</li>
                <li>• Both you and your referrals benefit from the program</li>
            </ul>
        </div>

        @endif
    </div>
</div>

{{-- QR Code Library --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    function updateAffiliateLink() {
        const path = document.getElementById('targetPath').value;
        const newLink = window.location.origin + path + '?ref=abcd12';
        document.getElementById('generatedLink').value = newLink;
        if (document.getElementById('qrcodeContainer').classList.contains('block')) {
            new QRCode(document.getElementById("qrcode"), {
                text: newLink,
                width: 200,
                height: 200,
            });
        }
    }

    function copyReferralLink(link) {
        navigator.clipboard.writeText(link).then(() => {
            showToast('success', 'Referral link copied successfully!');
        }).catch(() => {
            showToast('error', 'Failed to copy the link.');
        });
    }

    function shareReferralLink() {
        const link = document.getElementById('generatedLink').value;
        if (navigator.share) {
            navigator.share({
                title: 'Join OrbitX',
                text: 'Join me on OrbitX for amazing DeFi opportunities!',
                url: link,
            });
        } else {
            copyReferralLink(link);
        }
    }

    function toggleQRCode() {
        const container = document.getElementById('qrcodeContainer');
        container.classList.toggle('hidden');
        container.classList.toggle('block');
        const link = document.getElementById('generatedLink').value;
        container.innerHTML = `<div id="qrcode" class="inline-block bg-white p-4 rounded-lg"></div>`;
        new QRCode(document.getElementById("qrcode"), {
            text: link,
            width: 200,
            height: 200,
        });
    }

    function shareTo(platform) {
        const link = document.getElementById('generatedLink').value;
        const text = encodeURIComponent('Join me on OrbitX for amazing DeFi opportunities!');
        const encodedLink = encodeURIComponent(link);
        let url = '';
        switch (platform) {
            case 'twitter':
                url = `https://twitter.com/intent/tweet?text=${text}&url=${encodedLink}`;
                break;
            case 'facebook':
                url = `https://www.facebook.com/sharer/sharer.php?u=${encodedLink}`;
                break;
            case 'telegram':
                url = `https://t.me/share/url?url=${encodedLink}&text=${text}`;
                break;
            case 'whatsapp':
                url = `https://wa.me/?text=${text} ${encodedLink}`;
                break;
            case 'linkedin':
                url = `https://www.linkedin.com/sharing/share-offsite/?url=${encodedLink}`;
                break;
            case 'reddit':
                url = `https://reddit.com/submit?url=${encodedLink}&title=${text}`;
                break;
        }
        if (url) window.open(url, '_blank', 'width=600,height=400');
    }
</script>