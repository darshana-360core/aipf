@props([
    'currentLevel' => 0,
])

@php
$totalLevels = 15;
$centerIndex = 7;
$baseHeight = 5;
$step = 15;

function getCenteredLevels($active, $totalLevels, $centerIndex)
{
    $levels = [];

    for ($i = -$centerIndex; $i < $totalLevels - $centerIndex; $i++) {
        $val = (($active + $i - 1) % $totalLevels + $totalLevels) % $totalLevels + 1;
        $levels[] = $val;
    }

    return $levels;
}

function getSizeByIndex($index, $centerIndex, $baseHeight, $step)
{
    $relativePos = abs($centerIndex - $index);
    return $baseHeight + (7 - $relativePos) * $step;
}

$orderedLevels = getCenteredLevels($currentLevel, $totalLevels, $centerIndex);
@endphp

<div class="w-full">
    <div
        class="relative overflow-hidden w-full py-2 px-1 bg-[#121222] border border-[#322751] rounded-xl grid gap-px xl:gap-3 xl:px-5 py-5 items-center"
        style="grid-template-columns: repeat({{ $totalLevels }}, minmax(0, 1fr));">
        @foreach ($orderedLevels as $index => $level)
            @php
                $height = getSizeByIndex($index, $centerIndex, $baseHeight, $step);
                $isCenter = $currentLevel != 0 && $index === $centerIndex;
                $isAchieved = $level <= $currentLevel;
            @endphp

            <div
                style="gap: {{ $height }}px"
                class="transition-all max-w-16 duration-300 px-1 rounded-full flex flex-col justify-between items-center py-3 md:py-3 text-lg
                    {{ $isCenter 
                        ? 'bg-gradient-to-t from-[#fac35d] to-[#FAD85D] border-2 border-white text-black font-semibold scale-110' 
                        : (
                            $isAchieved 
                                ? 'bg-gradient-to-t from-[#fac35d] to-[#FAD85D] border border-green-300 text-black' 
                                : 'bg-gradient-to-t from-[#6b3fb9] to-indigo-500 border border-[#bd97ff] text-white'
                          )
                    }}">
                <span class="block text-xs xl:text-base transform rotate-90 md:rotate-0">
                    {{ $isCenter ? 'Curr.' : 'Level' }}
                </span>

                <span class="md:bg-white md:bg-opacity-15 md:w-10 md:h-10 md:rounded-full flex items-center justify-center text-xs md:text-base">
                    {{ $level }}
                </span>
            </div>
        @endforeach
    </div>
</div>
