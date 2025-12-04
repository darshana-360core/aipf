@props([
'imageSrc',
'title',
'valuesDolur' => '',
'values',
'flex' => 'flex-col',
'textAlign' => 'text-center',
'imageSize' => 'w-14 h-14 xl:w-24 xl:h-24',
'bgColor' => 'bg-[#121222]',
'padding' => 'p-4',
'imgHide' => '',
])

<div class="group relative flex {{ $flex }} items-center gap-2 md:gap-4 {{ $bgColor }} border border-[#322751] rounded-xl {{ $padding }} overflow-hidden {{ $textAlign }} text-white">
    <div class="{{ $imageSize }} {{ $imgHide }} flex-shrink-0 mb-2">
        <img src="{{ asset($imageSrc) }}" alt="{{ $title }}" class="group-hover:scale-105 transition-all duration-100 object-center origin-center ease-linear w-full h-full object-contain rounded" />
    </div>
    <div class="flex flex-col">
        <p class="text-sm lg:text-base text-gray-200 leading-none mb-2" style="line-height: 1;">{{ $title }}</p>
        @if($valuesDolur)
        <h2 class="text-lg lg:text-xl text-white font-semibold leading-none mb-1.5 valuesDolur" style="line-height: 1;">
            {{ $valuesDolur }}
        </h2>
        @endif
        <h4 class="text-lg lg:text-xl text-white font-semibold leading-none" style="line-height: 1;">{{ $values }}</h4>
    </div>
    <div class="w-full h-full absolute top-0 left-0 opacity-[0.15] p-0 z-0 pointer-events-none">
        <img src="{{ asset('assets/images/wavebgbox.svg') }}" alt="{{ $title }}" class="w-full h-full object-cover mx-auto hue-rotate-[225deg]" />
    </div>
</div>