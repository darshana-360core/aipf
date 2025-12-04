@props([
'title',
'valuesDolur' => '',
'value',
'bgColor' => '#ffffff',
'borderColor' => '#ffffff',
'imageSrc',
'lable' => '',
'unit' => '',
])

<div class="w-full px-2">
<div class="group relative flex flex-row items-center justify-between gap-2 md:gap-4 rounded-3xl px-6 py-4 text-left text-black border"
    style="background-color: {{ $bgColor }}; border-color: {{ $borderColor }};">
    <div class="flex flex-col relative w-full z-10">
        <div class="flex items-center justify-between mb-4">
            <span class="w-12 h-12 bg-white bg-opacity-35 rounded-full flex items-center justify-center">
                <div class="w-6 h-6 bg-white rounded-full"></div>
            </span>
            <p class="text-sm font-medium px-3 py-1 bg-white bg-opacity-35 rounded-full">{{ $lable }}</p>
        </div>
        <p class="text-base lg:text-lg leading-none mb-3 font-medium opacity-70">{{ $title }}</p>
        @if($valuesDolur)
        <h2 class="text-lg lg:text-xl text-black font-semibold leading-none mb-1.5 valuesDolur" style="line-height: 1;">
            {{ $valuesDolur }}
        </h2>
        @endif
        <h4 class="text-lg lg:text-xl text-black font-semibold leading-none" style="line-height: 1;">{{ $value }} {{ $unit }}</h4>
    </div>

    <div class="max-w-20 h-auto max-h-20 md:max-w-20 flex-shrink-0 absolute bottom-3 right-3 z-[9] pointer-events-none opacity-10 invert">
        <img src="{{ $imageSrc }}" alt="{{ $lable }}" class="object-contain w-full h-full rounded" />
    </div>

    <div class="w-full h-full absolute top-0 left-0 p-2 z-0 pointer-events-none opacity-35">
        <img src="{{ asset('assets/images/boxbgline.svg') }}" alt="boxbgline" class="w-auto h-auto object-contain mx-auto" />
    </div>

    <!-- Side dots -->
    <div class="hidden md:flex w-8 h-full absolute top-0 -left-6 z-0 pointer-events-none flex-col items-center justify-center gap-6">
        <span class="bg-[#0f0f1c] w-full h-3.5 rounded-full block"></span>
        <span class="bg-[#0f0f1c] w-full h-3.5 rounded-full block"></span>
        <span class="bg-[#0f0f1c] w-full h-3.5 rounded-full block"></span>
    </div>
    <div class="hidden md:flex w-8 h-full absolute top-0 -right-6 z-0 pointer-events-none flex-col items-center justify-center gap-6">
        <span class="bg-[#0f0f1c] w-full h-3.5 rounded-full block"></span>
        <span class="bg-[#0f0f1c] w-full h-3.5 rounded-full block"></span>
        <span class="bg-[#0f0f1c] w-full h-3.5 rounded-full block"></span>
    </div>
    </div>
</div>