@props([
'package' => null,
'walletAddress' => null,
'referrer' => null,
'affiliateData' => null,
'link' => '',
])

@php
$hasValidReferrer = !empty($referrer);
@endphp

<div class="group relative bg-gradient-to-br from-[#845dcb] to-[#6b3fb9] border border-[#845dcb]/30 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300 z-10">
    <div class="w-full h-full absolute top-0 left-0 p-2 z-0 pointer-events-none opacity-10">
        <img src="{{ asset('assets/images/boxbgline.svg') }}" alt="background" class="w-auto h-auto object-contain mx-auto" />
    </div>

    <div class="relative z-10">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold">Referral Program</h3>
            </div>
            @if ($hasValidReferrer)
            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
            @endif
        </div>

        @if (!$walletAddress)
        <div class="text-center py-4">
            <p class="text-white/80 text-sm mb-2">Connect your wallet to</p>
            <p class="text-white font-medium">Access Referral Program</p>
        </div>
        @else
        <div class="space-y-4">

            <div class="text-center py-2">
                @if($package == 0)
                    <p class="text-white/80 text-sm">Your referral link will be activated once you stake RTX tokens.</p>
                @else
                <p class="text-white/80 text-sm">Start earning rewards by</p>
                <p class="text-white font-medium">sharing your referral link</p>
                @endif 
            </div>

            <div class="grid grid-cols-2 gap-3 @if($package == 0) blur-sm @endif">
                <button @if($package > 0) onclick="copyReferralLink('{{ $link }}')" @endif
                    class="bg-white/15 hover:bg-white/25 border border-white/20 rounded-lg px-3 py-2 text-sm font-medium transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Copy Link
                </button>
                <button  @if($package > 0) onclick="document.getElementById('affiliate-modal').classList.remove('hidden')"  @endif
                    class="bg-white/15 hover:bg-white/25 border border-white/20 rounded-lg px-3 py-2 text-sm font-medium transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                    </svg>
                    Share
                </button>
            </div>

            <div class="border-t border-white/20 pt-3 mt-3">
                <p class="text-xs text-white/70 text-center">🎁 Earn rewards • 🔗 Permanent links • 📈 Track performance</p>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    function copyReferralLink(link) {
        navigator.clipboard.writeText(link).then(() => {
            alert("Referral link copied!");
        }).catch(() => {
            alert("Failed to copy.");
        });
    }
</script>