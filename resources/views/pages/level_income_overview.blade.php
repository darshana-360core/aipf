@extends('layouts.app')

@section('title', 'Level Income Overview')
@section('content')
<section class="w-full p-3 md:p-5 mx-auto max-w-[1400px]">
    <div class="p-4 rounded-xl mx-auto relative w-full h-full my-10 bg-gradient-to-t from-[#6b3fb9] to-indigo-500 border border-[#bd97ff]">
        <form method="POST" action="{{route('flevelIncomeOverview')}}">
            @method('POST')
            @csrf
            <div id="date-range-picker" date-rangepicker class="flex flex-wrap sm:flex-nowrap gap-2 items-center justify-center text-white">
                <div class="w-full relative flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-black bg-opacity-0">
                    <svg class="w-7 h-7 min-w-7 min-h-7" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                    <input id="datepicker-range-start" @if(isset($data['start_date'])) value="{{$data['start_date']}}" @endif placeholder="Select date start" name="start_date" type="text" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base" autocomplete="off">
                </div>
                <span class="mx-4 hidden sm:block">TO</span>
                <div class="w-full relative flex items-center justify-between border border-white border-opacity-15 p-3 rounded gap-3 bg-black bg-opacity-0">
                    <svg class="w-7 h-7 min-w-7 min-h-7" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                    <input id="datepicker-range-end" @if(isset($data['end_date'])) value="{{$data['end_date']}}" @endif placeholder="Select date end" name="end_date" type="text" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base" autocomplete="off">
                </div>
                <button type="submit"><svg class="w-12 h-12 min-w-12 min-h-12 cursor-pointer bg-white bg-opacity-10 border border-white border-opacity-20 p-2 rounded-lg ml-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg></button>
                <a href="{{route('fincomeOverview')}}"><svg class="w-12 h-12 min-w-12 min-h-12 cursor-pointer bg-white bg-opacity-10 border border-white border-opacity-20 p-2 rounded-lg ml-4" viewBox="0 0 36 36"><path xmlns="http://www.w3.org/2000/svg" fill="#ffffff" d="M34 3H12.475V1.128c0-1.046-.74-1.435-1.645-.865L.69 6.652c-.905.57-.922 1.527-.038 2.127l10.215 6.931c.884.602 1.607.235 1.607-.811V13H34a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zM.024 26.184c0-.727.5-1.137 1.197-1.137H4.13c1.576 0 2.849 1.061 2.849 2.667c0 1.061-.439 1.772-1.409 2.227v.03c1.288.183 2.303 1.258 2.303 2.576c0 2.137-1.424 3.288-3.516 3.288h-3.12c-.697 0-1.212-.439-1.212-1.151v-8.5zm2.273 3.135h1.182c.742 0 1.227-.439 1.227-1.196c0-.713-.561-1.076-1.227-1.076H2.297v2.272zm0 4.516h1.788c.818 0 1.424-.47 1.424-1.318c0-.712-.545-1.197-1.606-1.197H2.297v2.515zm9.217-7.713c.258-.696.85-1.257 1.621-1.257c.805 0 1.365.53 1.621 1.257l2.971 8.243c.092.242.121.454.121.561c0 .591-.484 1-1.045 1c-.637 0-.955-.333-1.107-.788l-.453-1.424H11.03l-.455 1.409c-.15.47-.469.803-1.09.803c-.607 0-1.122-.454-1.122-1.061c0-.242.076-.424.106-.5l3.045-8.243zm.168 5.501h2.879l-1.41-4.395h-.029l-1.44 4.395zm11.378-6.758c1.106 0 3.258.363 3.258 1.696c0 .546-.379 1.016-.94 1.016c-.621 0-1.046-.53-2.318-.53c-1.879 0-2.849 1.591-2.849 3.439c0 1.803.985 3.349 2.849 3.349c1.272 0 1.788-.637 2.409-.637c.682 0 1 .682 1 1.03c0 1.455-2.288 1.788-3.409 1.788c-3.076 0-5.212-2.439-5.212-5.576c0-3.151 2.121-5.575 5.212-5.575zm4.471 1.212c0-.621.455-1.121 1.137-1.121c.651 0 1.137.424 1.137 1.121v3.273l3.727-3.97c.167-.182.455-.424.879-.424c.576 0 1.121.439 1.121 1.091c0 .393-.242.712-.742 1.212l-2.863 2.818l3.5 3.651c.363.364.637.697.637 1.152c0 .712-.562 1.045-1.183 1.045c-.44 0-.727-.258-1.151-.712l-3.924-4.243v3.864c0 .591-.455 1.091-1.137 1.091c-.651 0-1.137-.424-1.137-1.091v-8.757z"/></svg></a>
            </div>
        </form>
    </div>
    <div class="w-full p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl">
        <div id="default-tab-content">
            <div class="w-full p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" style="padding-top: 15px;">
                        <thead>
                            <tr class="bg-white bg-opacity-10 text-white">
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting">Sr.</th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="text-nowrap w-full block text-center">Amount</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="text-nowrap w-full block text-center">Tag</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting"><span class="text-nowrap w-full block text-center">Referral Code</span></th>
                                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md sorting text-end"><span class="w-full block text-end">Date</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($data['levelEarningLogs']))
                            @php
                                $sr = ($data['levelEarningLogs']->currentPage() - 1) * $data['levelEarningLogs']->perPage() + 1;
                            @endphp
                            @foreach ($data['levelEarningLogs'] as $key => $value)
                            <tr>
                                <td class="text-nowrap px-4 py-2">{{$sr++}}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ number_format($value['amount'], 3) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ intval(preg_replace('/[^0-9]/', '', $value['tag'])) }}-Level</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['refrence'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-end text-[#30b8f5]">{{ \Carbon\Carbon::parse($value['created_on'], 'UTC')->setTimezone('Europe/London')->format('d-m H:i') }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="mt-6">
                        {{ $data['levelEarningLogs']->withQueryString()->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
