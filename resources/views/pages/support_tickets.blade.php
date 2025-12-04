@extends('layouts.app')

@section('title', 'Support Ticket')

@section('content')
<section class="w-full p-3 md:p-5 mx-auto max-w-[1400px]">
    <div class="grid grid-cols-1 gap-5 relative z-10">
        <div class="grid grid-cols-1 xl:grid-cols-4">
            <div class="cols-span-1 xl:col-span-1"></div>
            <div class="cols-span-1 xl:col-span-2 grid-cols-1 grid">
                <div class="p-4 rounded-xl w-full mx-auto border border-[#2b2b2f] bg-black relative boxbgsvg1">
                    <h3 class="font-bold text-xl md:text-2xl mb-4">Create a support tickets</h3>
                    <form class="relative" action="{{route('supportTicketProcess')}}" enctype="multipart/form-data" method="POST">
                        @method('POST')
                        @csrf
                        <!-- subject -->
                        <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-30 p-3 rounded gap-3 bg-black bg-opacity-50">
                            <svg class="w-6 h-6 min-w-6 min-h-6" version="1.1" viewBox="0 0 38 32" enable-background="new 0 0 38 32" xml:space="preserve">
                                <g>
                                    <path fill="#ffffff" d="M36.5,0h-35C0.673,0,0,0.673,0,1.5v29C0,31.327,0.673,32,1.5,32h35c0.827,0,1.5-0.673,1.5-1.5v-29
		C38,0.673,37.327,0,36.5,0z M37,30.5c0,0.275-0.225,0.5-0.5,0.5h-35C1.225,31,1,30.775,1,30.5v-29C1,1.225,1.225,1,1.5,1h35
		C36.775,1,37,1.225,37,1.5V30.5z" />
                                    <path fill="#ffffff" d="M17.5,16h-11C5.673,16,5,16.673,5,17.5v8C5,26.327,5.673,27,6.5,27h11c0.827,0,1.5-0.673,1.5-1.5v-8
		C19,16.673,18.327,16,17.5,16z M18,25.5c0,0.275-0.225,0.5-0.5,0.5h-11C6.225,26,6,25.775,6,25.5v-8C6,17.225,6.225,17,6.5,17h11
		c0.275,0,0.5,0.225,0.5,0.5V25.5z" />
                                    <path fill="#ffffff" d="M31.5,5h-25C5.673,5,5,5.673,5,6.5v5C5,12.327,5.673,13,6.5,13h25c0.827,0,1.5-0.673,1.5-1.5v-5
		C33,5.673,32.327,5,31.5,5z M32,11.5c0,0.275-0.225,0.5-0.5,0.5h-25C6.225,12,6,11.775,6,11.5v-5C6,6.225,6.225,6,6.5,6h25
		C31.775,6,32,6.225,32,6.5V11.5z" />
                                    <path fill="#ffffff" d="M32,17H22c-0.276,0-0.5,0.224-0.5,0.5S21.724,18,22,18h10c0.276,0,0.5-0.224,0.5-0.5S32.276,17,32,17z" />
                                    <path fill="#ffffff" d="M32,21H22c-0.276,0-0.5,0.224-0.5,0.5S21.724,22,22,22h10c0.276,0,0.5-0.224,0.5-0.5S32.276,21,32,21z" />
                                    <path fill="#ffffff" d="M32,25H22c-0.276,0-0.5,0.224-0.5,0.5S21.724,26,22,26h10c0.276,0,0.5-0.224,0.5-0.5S32.276,25,32,25z" />
                                </g>
                            </svg>
                            <input type="text" name="subject" id="subject" placeholder="Enter subject here" required="required" class="border-l pl-4 border-white border-opacity-15 outline-none shadow-none bg-transparent w-full block text-base">
                        </div>

                        <!-- file -->
                        <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-30 p-3 rounded gap-3 bg-black bg-opacity-50">
                            <svg class="w-6 h-6 min-w-6 min-h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.75 10C2.75 9.58579 2.41421 9.25 2 9.25C1.58579 9.25 1.25 9.58579 1.25 10H2.75ZM21.25 14C21.25 14.4142 21.5858 14.75 22 14.75C22.4142 14.75 22.75 14.4142 22.75 14H21.25ZM15.3929 4.05365L14.8912 4.61112L15.3929 4.05365ZM19.3517 7.61654L18.85 8.17402L19.3517 7.61654ZM21.654 10.1541L20.9689 10.4592V10.4592L21.654 10.1541ZM3.17157 20.8284L3.7019 20.2981H3.7019L3.17157 20.8284ZM20.8284 20.8284L20.2981 20.2981L20.2981 20.2981L20.8284 20.8284ZM1.35509 5.92658C1.31455 6.33881 1.61585 6.70585 2.02807 6.7464C2.4403 6.78695 2.80734 6.48564 2.84789 6.07342L1.35509 5.92658ZM22.6449 18.0734C22.6855 17.6612 22.3841 17.2941 21.9719 17.2536C21.5597 17.2131 21.1927 17.5144 21.1521 17.9266L22.6449 18.0734ZM14 21.25H10V22.75H14V21.25ZM2.75 14V10H1.25V14H2.75ZM21.25 13.5629V14H22.75V13.5629H21.25ZM14.8912 4.61112L18.85 8.17402L19.8534 7.05907L15.8947 3.49618L14.8912 4.61112ZM22.75 13.5629C22.75 11.8745 22.7651 10.8055 22.3391 9.84897L20.9689 10.4592C21.2349 11.0565 21.25 11.742 21.25 13.5629H22.75ZM18.85 8.17402C20.2034 9.3921 20.7029 9.86199 20.9689 10.4592L22.3391 9.84897C21.9131 8.89241 21.1084 8.18853 19.8534 7.05907L18.85 8.17402ZM10.0298 2.75C11.6116 2.75 12.2085 2.76158 12.7405 2.96573L13.2779 1.5653C12.4261 1.23842 11.498 1.25 10.0298 1.25V2.75ZM15.8947 3.49618C14.8087 2.51878 14.1297 1.89214 13.2779 1.5653L12.7405 2.96573C13.2727 3.16993 13.7215 3.55836 14.8912 4.61112L15.8947 3.49618ZM10 21.25C8.09318 21.25 6.73851 21.2484 5.71085 21.1102C4.70476 20.975 4.12511 20.7213 3.7019 20.2981L2.64124 21.3588C3.38961 22.1071 4.33855 22.4392 5.51098 22.5969C6.66182 22.7516 8.13558 22.75 10 22.75V21.25ZM1.25 14C1.25 15.8644 1.24841 17.3382 1.40313 18.489C1.56076 19.6614 1.89288 20.6104 2.64124 21.3588L3.7019 20.2981C3.27869 19.8749 3.02502 19.2952 2.88976 18.2892C2.75159 17.2615 2.75 15.9068 2.75 14H1.25ZM14 22.75C15.8644 22.75 17.3382 22.7516 18.489 22.5969C19.6614 22.4392 20.6104 22.1071 21.3588 21.3588L20.2981 20.2981C19.8749 20.7213 19.2952 20.975 18.2892 21.1102C17.2615 21.2484 15.9068 21.25 14 21.25V22.75ZM10.0298 1.25C8.15538 1.25 6.67442 1.24842 5.51887 1.40307C4.34232 1.56054 3.39019 1.8923 2.64124 2.64124L3.7019 3.7019C4.12453 3.27928 4.70596 3.02525 5.71785 2.88982C6.75075 2.75158 8.11311 2.75 10.0298 2.75V1.25ZM2.84789 6.07342C2.96931 4.83905 3.23045 4.17335 3.7019 3.7019L2.64124 2.64124C1.80633 3.47616 1.48944 4.56072 1.35509 5.92658L2.84789 6.07342ZM21.1521 17.9266C21.0307 19.1609 20.7695 19.8266 20.2981 20.2981L21.3588 21.3588C22.1937 20.5238 22.5106 19.4393 22.6449 18.0734L21.1521 17.9266Z" fill="#ffffff" />
                                <path d="M13 2.5V5C13 7.35702 13 8.53553 13.7322 9.26777C14.4645 10 15.643 10 18 10H22" stroke="#ffffff" stroke-width="1.5" />
                            </svg>
                            <input type="file" name="file" class="block w-full text-sm file:mr-4 file:rounded-md file:border-0 file:bg-[#32a7e2] file:py-2.5 file:px-4 file:text-sm file:font-semibold file:text-white hover:file:bg-[#32a7e2] focus:outline-none disabled:pointer-events-none disabled:opacity-60">
                        </div>
                        <!-- Message -->
                        <div class="relative mb-4 flex items-center justify-between border border-white border-opacity-30 p-3 rounded gap-3 bg-black bg-opacity-50">
                            <textarea type="text" rows="4" name="message" id="message" placeholder="Enter Message here" required="required" class=" outline-none shadow-none bg-transparent w-full block text-base"></textarea>
                        </div>
                        <!-- button start -->
                        <div class="flex items-center justify-center mt-8 relative group">
                            <button class="w-full relative inline-block p-px font-semibold leading-none text-white cursor-pointer rounded-sm" type="submit">
                                <span class="absolute inset-0 rounded-sm bg-gradient-to-r from-teal-400 via-blue-500 to-purple-500 p-[2px]"></span>
                                <span class="relative z-10 block px-6 py-3 rounded-sm">
                                    <div class="relative z-10 flex items-center space-x-2 justify-center">
                                        <span class="transition-all duration-500 group-hover:translate-x-1">Create Ticket</span>
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
                                </span>
                            </button>
                        </div>
                        <!-- button end -->
                    </form>
                </div>
            </div>
            <div class="cols-span-1 xl:col-span-1"></div>
        </div>
        <div class="grid grid-cols-1 gap-5 mt-4">
            <div class="grid-cols-1 grid gap-5">
                <div class="p-4 rounded-xl w-full mx-auto border border-[#2b2b2f] bg-black relative boxbgsvg1 space-y-4">
                    <div class="overflow-x-auto">
                        <table id="withdrawalsTable" class="w-full text-left border-collapse" style="padding-top: 15px;">
                            <thead>
                                <tr class="bg-white bg-opacity-10 text-white">
                                    <th class="px-4 py-2">Ticket Id.</th>
                                    <th class="px-4 py-2">Subject</th>
                                    <th class="px-4 py-2">Message</th>
                                    <th class="px-4 py-2">Attachment</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Reply</th>
                                    <th class="px-4 py-2">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($data['data']))
                                @foreach($data['data'] as $key => $value)
                                    <tr>
                                        <td class="text-nowrap mr-3 px-4 py-2 flex items-center">{{ $value['id'] }}</td>
                                        <td class="text-nowrap px-4 py-2">{{ $value['subject'] }}</td>
                                        <td class="text-nowrap px-4 py-2">{{ $value['message'] }}</td>
                                        <td class="text-nowrap px-4 py-2"><a target="_blank" href="{{asset('storage/'.$value['file'])}}" class="text-blue-600 flex items-center gap-2">View <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="Interface / External_Link">
                                        <path id="Vector" d="M10.0002 5H8.2002C7.08009 5 6.51962 5 6.0918 5.21799C5.71547 5.40973 5.40973 5.71547 5.21799 6.0918C5 6.51962 5 7.08009 5 8.2002V15.8002C5 16.9203 5 17.4801 5.21799 17.9079C5.40973 18.2842 5.71547 18.5905 6.0918 18.7822C6.5192 19 7.07899 19 8.19691 19H15.8031C16.921 19 17.48 19 17.9074 18.7822C18.2837 18.5905 18.5905 18.2839 18.7822 17.9076C19 17.4802 19 16.921 19 15.8031V14M20 9V4M20 4H15M20 4L13 11" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                </svg></a></td>
                                        <td class="text-nowrap px-4 py-2 {{ $value['status'] == 1 ? 'text-green-400' : ($value['status'] == 2 ? 'text-red-300' : 'text-yellow-400') }}">{{ $value['status'] == 1 ? "Complete" : ($value['status'] == 2 ? "Reject" : "Pending") }}</td>
                                        <td class="text-nowrap px-4 py-2">{{ $value['reply'] }}</td>
                                        <td class="text-nowrap px-4 py-2 text-[#30b8f5]">{{date('d-m-Y h:i:s', strtotime($value['created_on']))}}</td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection