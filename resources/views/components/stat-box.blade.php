@props([
'title',
'valuesDolur' => '',
'value',
'rtxval',
'bgColor' => '#ffffff',
'borderColor' => '#ffffff',
'imageSrc',
'altText' => '',
])

<div class="group relative flex flex-row items-center justify-between gap-2 md:gap-4 rounded-3xl px-6 pt-8 pb-12 text-left text-black border"
    style="background-color: {{ $bgColor }}; border-color: {{ $borderColor }};">

    <div class="flex flex-col relative z-10">
        <p class="text-base lg:text-lg leading-none mb-6 font-semibold">{{ $title }}</p>
        @if($valuesDolur)
        <h2 class="text-lg lg:text-xl text-black font-semibold leading-none mb-1.5 valuesDolur" style="line-height: 1;">
            {{ $valuesDolur }}
        </h2>
         @endif
        <h4 class="text-lg lg:text-xl text-black font-semibold leading-none">{{ $value }}</h4>
        @if($title=='Direct Team Investment'||$title=='Total Team Investment')
            <h4 class="text-lg lg:text-xl text-black font-semibold leading-none">{{ $rtxval }}</h4>
        @endif
    </div>

    <div class="max-w-28 h-auto max-h-24 md:max-w-32 flex-shrink-0 absolute bottom-3 right-3 z-[9] pointer-events-none opacity-45">
        <img src="{{ $imageSrc }}" alt="{{ $altText }}" class="object-contain w-full h-full rounded" />
    </div>

    <div class="w-full h-full absolute top-0 left-0 p-2 z-0 pointer-events-none opacity-35">
        <img src={{ asset('assets/images/boxbgline.svg') }} alt="boxbgline" class="w-auto h-auto object-contain mx-auto" />
    </div>
    <div class="hidden md:flex w-10 h-full absolute top-0 -left-8 z-0 pointer-events-none flex-col items-center justify-center gap-6"><span class="bg-[#0f0f1c] w-full h-3.5 rounded-full block"></span><span class="bg-[#0f0f1c] w-full h-3.5 rounded-full block"></span><span class="bg-[#0f0f1c] w-full h-3.5 rounded-full block"></span></div>
    <div class="hidden md:flex w-10 h-full absolute top-0 -right-8 z-0 pointer-events-none flex-col items-center justify-center gap-6"><span class="bg-[#0f0f1c] w-full h-3.5 rounded-full block"></span><span class="bg-[#0f0f1c] w-full h-3.5 rounded-full block"></span><span class="bg-[#0f0f1c] w-full h-3.5 rounded-full block"></span></div>
</div>