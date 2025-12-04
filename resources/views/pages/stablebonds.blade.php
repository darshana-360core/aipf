@extends('layouts.app')

@section('title', 'Stable Bonds')

@section('content')
<section class="grid grid-cols-1 gap-5 mt-5">
    @if(isset($data['confirmTransactionWindow']))
        <div class="data-card container mx-auto">
            <div class="p-3 md:p-6 rounded-md border border-[#1d2753] bg-gradient-to-t from-[#265e8c] via-[#255480] to-[#243f82] relative shadow-inner w-full mx-auto">
                <div class="border-0 border-white rounded-xl">
                    <div class="relative text-center p-3 md:p-3 shadow-inner">
                        <div class="card-data text-l md:text-xl  font-semibold text-white">System has found transaction for stake Stable Bonds. Please verify transaction to activate. </div>
                        <div class="text-lg text-white mx-auto my-3">Stake Amount ${{$data['pending_package_amount']}}</div>
                        <div class="break-words card-data text-l md:text-xl font-semibold text-white">Transaction Hash : {{ substr($data['pending_transaction_hash'], 0, 4) }} ... {{ substr($data['pending_transaction_hash'], -4) }} <i class="las la-copy cursor-pointer" onclick="copyTransactionHash('{{$data['pending_transaction_hash']}}');"></i></div>


                        <div class="flex items-center justify-center my-4 relative group">
                            <!-- onclick="activatePackage(this);" -->
                            <a id="transactionStatusLink" class="mb-5 mt-2 block text-center" href="{{route('check_package_transaction')}}">
                                <button class="px-4 py-1 text-white buttonbg mx-auto flex items-center text-base capitalize tracking-wider" type="button">
                                    <span class="relative z-10 block px-6 py-3 rounded-sm">
                                        <div class="relative z-10 flex items-center space-x-2 justify-center">
                                            <span class="transition-all duration-500 group-hover:translate-x-1">Verify Transaction</span>
                                            <svg class="w-6 h-6 transition-transform duration-500 group-hover:translate-x-1" data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path clip-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" fill-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </span>
                                </button>
                            </a>
                        </div>
                        <h3 class="data-des text-base text-white">Your transaction is in process it will take 2-3 minutes to process please wait. </h3>
                    </div>
                </div>
            </div>
        </div>
        @endif
    <div class="w-full p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
            <div class="xl:col-span-2">
                
               <!--  @php
                    $current = 0;
                    $total = 12000;
                    $percent = ($current / $total) * 100;
                @endphp -->

                @php
                    // Dummy values for each tab
                    $current_90 = $data['bonanza']['2']['amount'] ?? 0;
                    $total_90 = 15000;
                    $percent_90 = $total_90 > 0 ? ($current_90 / $total_90) * 100 : 0;

                    $current_180 = $data['bonanza']['3']['amount'] ?? 0;
                    $total_180 = 5000;
                    $percent_180 = $total_180 > 0 ? ($current_180 / $total_180) * 100 : 0;
                @endphp
                <div class="grid grid-cols-1 text-left h-full relative">
                    <div class="group relative bg-[#171531] border border-[#322751] rounded-xl p-4 overflow-hidden text-left text-white">
                        <h2 class='text-xl sm:text-2xl mb-4 font-semibold'>Bali Trip</h2>
                        <!-- Tab Buttons -->
                        <div class="flex flex-wrap items-center justify-start gap-2 md:gap-3 mb-5 md:mb-20">
                            <button onclick="switchTab('90')" id="tab-90"
                                class="tab-btn w-full md:w-auto text-white text-sm sm:text-base flex items-center gap-1 sm:gap-2 font-normal capitalize border-opacity-50 rounded-md px-2 sm:px-3 py-2 active bg-gradient-to-t from-[#6B3FB9] to-indigo-500 border border-[#BD97FF] hover:from-[#7C4BC7] hover:to-indigo-600 transition-all duration-200">Direct Business</button>
                            <button onclick="switchTab('180')" id="tab-180"
                                class="tab-btn grayscale w-full md:w-auto text-white text-sm sm:text-base flex items-center gap-1 sm:gap-2 font-normal capitalize border-opacity-50 rounded-md px-2 sm:px-3 py-2 active bg-gradient-to-t from-[#6B3FB9] to-indigo-500 border border-[#BD97FF] hover:from-[#7C4BC7] hover:to-indigo-600 transition-all duration-200">Self Business</button>
                        </div>
                        <!-- Tab Content: 90 Days -->
                        <div id="tab-content-90" class="space-y-3">
                            @if($percent_90>=100)
                                <div>
                                    <h3>Congratulations 🎉, Please fill the form!</h3>
                                </div>
                            @endif
                            <h2 class="mb-2 text-lg w-full text-left">
                                Self Investment
                                <span class="text-yellow-300 text-base">(<span class="text-white">{{ $current_90 }}</span>/{{ $total_90 }})</span>
                            </h2>
                            <div class="flex w-full h-8 bg-gray-200 rounded-md px-0 overflow-hidden" role="progressbar"
                                aria-valuenow="{{ $percent_90 }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="flex flex-col justify-center rounded-md bg-[#8E86FF] text-xl font-semibold text-white text-center transition duration-500 py-2"
                                    style="width: {{ $percent_90 }}%">
                                    {{ round($percent_90, 2) }}%
                                </div>
                            </div>
                            @if (!$data['user_stablebond_details']->contains('tag', '90'))
                                @if($percent_90>=100)
                                    <div class="flex items-center justify-end">
                                        <a href='https://docs.google.com/forms/d/e/1FAIpQLSc5pvV6osWyMvQ2GzTFgieTsBCUHOc-w-pbtdbFGgrjZRPuMQ/viewform?pli=1'>
                                            <button class="mt-2 tab-btn w-full md:w-auto text-white text-sm sm:text-base flex items-center gap-1 sm:gap-2 font-normal capitalize border-opacity-50 rounded-md px-2 sm:px-3 py-2 bg-gradient-to-t from-[#6B3FB9] to-indigo-500 border border-[#BD97FF] hover:from-[#7C4BC7] hover:to-indigo-600 transition-all duration-200">
                                                Fill Form
                                            </button>
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="flex items-center justify-end">
                                    <h2 class="text-green-600 sm:text-lg font-medium sm:font-semibold leading-none">Form Submitted Thank You!</h2>
                                </div>
                            @endif

                        </div>
                        <!-- Tab Content: 180 Days -->
                        <div id="tab-content-180" class="space-y-3 hidden">
                            @if($percent_180>=100)
                                <div>
                                    <h3>Congratulations 🎉, Please fill the form!</h3>
                                </div>
                            @endif
                            <h2 class="mb-2 text-lg w-full text-left">
                                Self Investment
                                <span class="text-yellow-300 text-base">(<span class="text-white">{{ $current_180 }}</span>/{{ $total_180 }})</span>
                            </h2>
                            <div class="flex w-full h-8 bg-gray-200 rounded-md px-0 overflow-hidden" role="progressbar"
                                aria-valuenow="{{ $percent_180 }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="flex flex-col justify-center rounded-md bg-[#8E86FF] text-xl font-semibold text-white text-center transition duration-500 py-2"
                                    style="width: {{ $percent_180 }}%">
                                    {{ round($percent_180, 2) }}%
                                </div>
                            </div>
                            @if (!$data['user_stablebond_details']->contains('tag', '180'))
                                @if($percent_180>=100)
                                <div class="flex items-center justify-end">
                                    <a href='https://docs.google.com/forms/d/e/1FAIpQLSc5pvV6osWyMvQ2GzTFgieTsBCUHOc-w-pbtdbFGgrjZRPuMQ/viewform?pli=1'>
                                    <button class="mt-2 tab-btn w-full md:w-auto text-white text-sm sm:text-base flex items-center gap-1 sm:gap-2 font-normal capitalize border-opacity-50 rounded-md px-2 sm:px-3 py-2 bg-gradient-to-t from-[#6B3FB9] to-indigo-500 border border-[#BD97FF] hover:from-[#7C4BC7] hover:to-indigo-600 transition-all duration-200">
                                        Fill Form
                                    </button>
                                    </a>
                                </div>
                                @endif
                            @else
                                <div class="flex items-center justify-end">
                                    <h2 class="text-green-600 sm:text-lg font-medium sm:font-semibold leading-none">Form Submitted Thank You!</h2>
                                </div>
                            @endif
                        </div>

                        <!-- Background + Rocket -->
                        <div class="w-full h-full absolute top-0 left-0 opacity-[0.2] z-0 pointer-events-none">
                            <img src="{{ asset('assets/images/wavebgbox.svg') }}" alt="Star Background"
                                class="w-full h-full object-cover mx-auto">
                        </div>
                        <img src="{{ asset('assets/images/rocketIcon.webp') }}" alt="rocketIcon"
                            class="w-12 h-12 lg:w-20 lg:h-20 xl:w-32 xl:h-32 absolute animate-slow-bounce top-1 lg:top-2 xl:top-3 right-1 object-contain pointer-events-none">
                    </div>
                </div>

                {{-- Modal --}}
                @if($percent_90>=100 || $percent_180>=100)
                <div id="congratsModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden justify-center items-center z-50 px-4">
                    <div class="relative bg-gradient-to-br from-[#1f1d2b] to-[#2a263b] border border-[#3f3b53] rounded-2xl shadow-2xl p-8 w-full max-w-md text-center text-white animate-scale-fade">
                        <!-- Close button (top-right) -->
                        <button onclick="closeModal()" class="absolute top-3 right-3 text-white text-2xl transition leading-none">
                            &times;
                        </button>
                        <!-- Content -->
                        <h2 class="text-3xl font-bold text-yellow-400 mb-3 animate-pulse">🎉 Congratulations!</h2>
                        <p class="text-lg text-gray-300">You’ve completed your investment goal!</p>

                        <button onclick="closeModal()" class="mt-6 px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-black font-semibold rounded-full transition duration-200">
                            Close
                        </button>
                    </div>
                </div>
                @endif
            </div>
            <div>
                <h2 class='text-lg'>Stable Bonds Staking</h2>
                <p class='text-sm text-gray-400 mb-4'>Earn stable returns by staking RTX directly</p>
                <div class="grid grid-cols-1 sm:grid-cols-1 xl:grid-cols-1 gap-3 mt-5">
                    <!-- <x-item-box
                        imageSrc=""
                        title="Total Staked"
                        :values="number_format($data['total_staked_amount'], 3) .' RTX'"
                        flex="flex-col"
                        imgHide="hidden"
                        bgColor="[#171531]" /> -->

                    <x-item-box
                        imageSrc=""
                        title="Your Staked"
                        :values="number_format($data['staked_amount'], 3) .' RTX'"
                        flex="flex-col"
                        imgHide="hidden"
                        bgColor="[#171531]" />

                    <x-item-box
                        imageSrc=""
                        title="Compounded Stake"
                        :values="number_format(($data['compound_amount'] - $data['total_unstake_amount']), 3) .' RTX'"
                        flex="flex-col"
                        imgHide="hidden"
                        bgColor="[#171531]" />

                    <x-item-box
                        imageSrc=""
                        title="Generated ROI"
                        :values="number_format($data['generated_roi'], 3) . ' RTX'"
                        flex="flex-col"
                        imgHide="hidden"
                        bgColor="[#171531]" />
                </div>
            </div>
        </div>
        
        <div x-data="{ activeTab: 'stake' }" class="w-full">

            <!-- Tabs -->
            <div class="flex items-center justify-center space-x-4 border-b border-[#322751] mb-4 mt-6">
                <button
                    @click="activeTab = 'stake'"
                    :class="activeTab === 'stake'
                ? 'text-[#8688ff] border-b-2 border-[#c29023] bg-gradient-to-r from-[#ffcd60] to-[#9564ff] bg-clip-text text-transparent'
                : 'text-gray-400 hover:text-white'"
                    class="px-4 py-2 text-lg md:text-xl font-medium rounded-t-md uppercase">
                    Stake
                </button>
                <button
                    @click="activeTab = 'unstake'"
                    :class="activeTab === 'unstake'
                ? 'text-[#8688ff] border-b-2 border-[#c29023] bg-gradient-to-r from-[#ffcd60] to-[#9564ff] bg-clip-text text-transparent'
                : 'text-gray-400 hover:text-white'"
                    class="px-4 py-2 text-lg md:text-xl font-medium rounded-t-md uppercase">
                    Unstake
                </button>
            </div>

            <!-- Tab Content -->
            <div class="text-sm text-gray-300">
                <div x-show="activeTab === 'stake'" x-transition>
                    @include('components.stake-usdt')
                </div>
                <div x-show="activeTab === 'unstake'" x-transition>
                    @include('components.unstake-usdt')
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal Backdrop -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-[999] p-4">
    <div class="relative w-full max-w-md md:max-w-lg lg:max-w-xl bg-[#06050c] rounded-lg overflow-hidden shadow-lg p-1">
        <!-- Close Icon -->
        <!-- Close Button -->
        <button onclick="closeImageModal()" class="absolute top-0 right-0 rounded-full p-2 shadow-md bg-red-500 text-white transition-all duration-200">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 8.586L15.95 2.636a1 1 0 1 1 1.414 1.414L11.414 10l5.95 5.95a1 1 0 0 1-1.414 1.414L10 11.414l-5.95 5.95a1 1 0 0 1-1.414-1.414L8.586 10 2.636 4.05a1 1 0 1 1 1.414-1.414L10 8.586z" clip-rule="evenodd" />
            </svg>
        </button>
        <!-- Responsive Image -->
        <img 
            src="{{ asset('assets/images/stablebonds/bali-stable-bond.jpg') }}" 
            alt="Popup Image" 
            class="w-full h-auto object-contain max-h-[90vh] border border-[#ae83fe] rounded-lg"
        >
    </div>
</div>
<!-- Fill Form Modal -->
 <div id="fillFormModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden justify-center items-center z-[52] px-4">
    <div class="relative bg-gradient-to-br from-[#1f1d2b] to-[#2a263b] border border-[#3f3b53] rounded-2xl shadow-2xl p-4 sm:p-5 w-full max-w-2xl text-left text-white animate-scale-fade overflow-y-auto max-h-[90vh]">
        <!-- Close Button -->
        <button onclick="closeFormModal()" class="absolute top-3 right-3 text-white text-3xl transition leading-none">
            &times;
        </button>
        <h2 class="text-xl font-semibold mb-4 text-white text-left border-b border-white/20 pb-2.5">Fill the details <span class="text-xl text-yellow-400 animate-pulse" id="tagname"></span></h2>
        <form class="space-y-2 sm:space-y-3" method="POST" id="user_detail_form" action="{{ route('user_details_store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Country -->
                <div>
                    <label class="block text-sm opacity-90 mb-1">Country</label>
                    <input type="text" class="w-full p-2 rounded outline-none bg-[#2c273f] border border-white/10 text-white" placeholder="Enter Country" name="country">
                    <!-- <select class="w-full p-2 rounded outline-none bg-[#2c273f] border border-white/10 text-white" name="country">
                    <option value="">Select Country</option>
                        <option>Afghanistan</option>
                        <option>Albania</option>
                        <option>Algeria</option>
                        <option>Andorra</option>
                        <option>Angola</option>
                        <option>Argentina</option>
                        <option>Armenia</option>
                        <option>Australia</option>
                        <option>Austria</option>
                        <option>Azerbaijan</option>
                        <option>Bahamas</option>
                        <option>Bahrain</option>
                        <option>Bangladesh</option>
                        <option>Barbados</option>
                        <option>Belarus</option>
                        <option>Belgium</option>
                        <option>Belize</option>
                        <option>Benin</option>
                        <option>Bhutan</option>
                        <option>Bolivia</option>
                        <option>Bosnia and Herzegovina</option>
                        <option>Botswana</option>
                        <option>Brazil</option>
                        <option>Brunei</option>
                        <option>Bulgaria</option>
                        <option>Burkina Faso</option>
                        <option>Burundi</option>
                        <option>Cambodia</option>
                        <option>Cameroon</option>
                        <option>Canada</option>
                        <option>Cape Verde</option>
                        <option>Central African Republic</option>
                        <option>Chad</option>
                        <option>Chile</option>
                        <option>China</option>
                        <option>Colombia</option>
                        <option>Comoros</option>
                        <option>Congo (Brazzaville)</option>
                        <option>Congo (Kinshasa)</option>
                        <option>Costa Rica</option>
                        <option>Croatia</option>
                        <option>Cuba</option>
                        <option>Cyprus</option>
                        <option>Czech Republic</option>
                        <option>Denmark</option>
                        <option>Djibouti</option>
                        <option>Dominica</option>
                        <option>Dominican Republic</option>
                        <option>Ecuador</option>
                        <option>Egypt</option>
                        <option>El Salvador</option>
                        <option>Equatorial Guinea</option>
                        <option>Eritrea</option>
                        <option>Estonia</option>
                        <option>Eswatini</option>
                        <option>Ethiopia</option>
                        <option>Fiji</option>
                        <option>Finland</option>
                        <option>France</option>
                        <option>Gabon</option>
                        <option>Gambia</option>
                        <option>Georgia</option>
                        <option>Germany</option>
                        <option>Ghana</option>
                        <option>Greece</option>
                        <option>Grenada</option>
                        <option>Guatemala</option>
                        <option>Guinea</option>
                        <option>Guinea-Bissau</option>
                        <option>Guyana</option>
                        <option>Haiti</option>
                        <option>Honduras</option>
                        <option>Hungary</option>
                        <option>Iceland</option>
                        <option>India</option>
                        <option>Indonesia</option>
                        <option>Iran</option>
                        <option>Iraq</option>
                        <option>Ireland</option>
                        <option>Israel</option>
                        <option>Italy</option>
                        <option>Jamaica</option>
                        <option>Japan</option>
                        <option>Jordan</option>
                        <option>Kazakhstan</option>
                        <option>Kenya</option>
                        <option>Kiribati</option>
                        <option>Kuwait</option>
                        <option>Kyrgyzstan</option>
                        <option>Laos</option>
                        <option>Latvia</option>
                        <option>Lebanon</option>
                        <option>Lesotho</option>
                        <option>Liberia</option>
                        <option>Libya</option>
                        <option>Liechtenstein</option>
                        <option>Lithuania</option>
                        <option>Luxembourg</option>
                        <option>Madagascar</option>
                        <option>Malawi</option>
                        <option>Malaysia</option>
                        <option>Maldives</option>
                        <option>Mali</option>
                        <option>Malta</option>
                        <option>Marshall Islands</option>
                        <option>Mauritania</option>
                        <option>Mauritius</option>
                        <option>Mexico</option>
                        <option>Micronesia</option>
                        <option>Moldova</option>
                        <option>Monaco</option>
                        <option>Mongolia</option>
                        <option>Montenegro</option>
                        <option>Morocco</option>
                        <option>Mozambique</option>
                        <option>Myanmar</option>
                        <option>Namibia</option>
                        <option>Nauru</option>
                        <option>Nepal</option>
                        <option>Netherlands</option>
                        <option>New Zealand</option>
                        <option>Nicaragua</option>
                        <option>Niger</option>
                        <option>Nigeria</option>
                        <option>North Korea</option>
                        <option>North Macedonia</option>
                        <option>Norway</option>
                        <option>Oman</option>
                        <option>Pakistan</option>
                        <option>Palau</option>
                        <option>Panama</option>
                        <option>Papua New Guinea</option>
                        <option>Paraguay</option>
                        <option>Peru</option>
                        <option>Philippines</option>
                        <option>Poland</option>
                        <option>Portugal</option>
                        <option>Qatar</option>
                        <option>Romania</option>
                        <option>Russia</option>
                        <option>Rwanda</option>
                        <option>Saint Kitts and Nevis</option>
                        <option>Saint Lucia</option>
                        <option>Saint Vincent</option>
                        <option>Samoa</option>
                        <option>San Marino</option>
                        <option>Sao Tome and Principe</option>
                        <option>Saudi Arabia</option>
                        <option>Senegal</option>
                        <option>Serbia</option>
                        <option>Seychelles</option>
                        <option>Sierra Leone</option>
                        <option>Singapore</option>
                        <option>Slovakia</option>
                        <option>Slovenia</option>
                        <option>Solomon Islands</option>
                        <option>Somalia</option>
                        <option>South Africa</option>
                        <option>South Korea</option>
                        <option>South Sudan</option>
                        <option>Spain</option>
                        <option>Sri Lanka</option>
                        <option>Sudan</option>
                        <option>Suriname</option>
                        <option>Sweden</option>
                        <option>Switzerland</option>
                        <option>Syria</option>
                        <option>Taiwan</option>
                        <option>Tajikistan</option>
                        <option>Tanzania</option>
                        <option>Thailand</option>
                        <option>Timor-Leste</option>
                        <option>Togo</option>
                        <option>Tonga</option>
                        <option>Trinidad and Tobago</option>
                        <option>Tunisia</option>
                        <option>Turkey</option>
                        <option>Turkmenistan</option>
                        <option>Tuvalu</option>
                        <option>Uganda</option>
                        <option>Ukraine</option>
                        <option>United Arab Emirates</option>
                        <option>United Kingdom</option>
                        <option>United States</option>
                        <option>Uruguay</option>
                        <option>Uzbekistan</option>
                        <option>Vanuatu</option>
                        <option>Vatican City</option>
                        <option>Venezuela</option>
                        <option>Vietnam</option>
                        <option>Yemen</option>
                        <option>Zambia</option>
                        <option>Zimbabwe</option>
                    </select> -->
                </div>
                <input type="hidden" id="tag" name="tag">
                <!-- Region -->
                <div>
                    <label class="block text-sm opacity-90 mb-1">Region</label>
                    <input type="text" class="w-full p-2 rounded outline-none bg-[#2c273f] border border-white/10 text-white" placeholder="Enter Region" name="region">
                </div>
            </div>
            <!-- First & Last Name -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm opacity-90 mb-1">First Name</label>
                    <input type="text" class="w-full p-2 rounded outline-none bg-[#2c273f] border border-white/10 text-white" placeholder="Enter First Name" name="fname">
                </div>
                <div>
                    <label class="block text-sm opacity-90 mb-1">Last Name</label>
                    <input type="text" class="w-full p-2 rounded outline-none bg-[#2c273f] border border-white/10 text-white" placeholder="Enter Last Name" name="lname">
                </div>
            </div>

            <!-- Email & WhatsApp -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm opacity-90 mb-1">Email Address</label>
                    <input type="email" class="w-full p-2 rounded outline-none bg-[#2c273f] border border-white/10 text-white" placeholder="Enter Email Address" name="email">
                </div>
                <div>
                    <label class="block text-sm opacity-90 mb-1">WhatsApp Number</label>
                    <input type="tel" class="w-full p-2 rounded outline-none bg-[#2c273f] border border-white/10 text-white" placeholder="Enter WhatsApp Number" name="wapp">
                </div>
            </div>

            <!-- Passport Number -->
            <div>
                <label class="block text-sm opacity-90 mb-1">Passport Number</label>
                <input type="text" class="w-full p-2 rounded outline-none bg-[#2c273f] border border-white/10 text-white" placeholder="Enter Passport Number" name="pass_num">
            </div>

            <!-- Passport Upload -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm opacity-90 mb-1">Upload Passport (Front)</label>
                    <input type="file" class="w-full p-2 outline-none bg-[#2c273f] border border-white/10 rounded text-white" name="pass_front">
                </div>
                <div>
                    <label class="block text-sm opacity-90 mb-1">Upload Passport (Back)</label>
                    <input type="file" class="w-full p-2 outline-none bg-[#2c273f] border border-white/10 rounded text-white" name="pass_back">
                </div>
            </div>

            <!-- Passport Issue & Expiry -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm opacity-90 mb-1">Passport Issue Date</label>
                    <input type="text" class="w-full p-2 outline-none bg-[#2c273f] border border-white/10 rounded text-white" placeholder="Enter Passport Issue (DD-MM-YYYY)" name="pass_issue_date">
                </div>
                <div>
                    <label class="block text-sm opacity-90 mb-1">Passport Expiry Date</label>
                    <input type="text" class="w-full p-2 outline-none bg-[#2c273f] border border-white/10 rounded text-white" placeholder="Enter Passport Expiry (DD-MM-YYYY)" name="pass_expiry_date">
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-center gap-2 text-center mt-4">
                <button type="submit" onclick="openSuccessModal()" class="mt-4 tab-btn w-full md:w-auto text-white text-sm sm:text-base flex items-center gap-1 sm:gap-2 font-normal capitalize border-opacity-50 rounded-md px-2 sm:px-3 py-2 bg-gradient-to-t from-[#6B3FB9] to-indigo-500 border border-[#BD97FF] hover:from-[#7C4BC7] hover:to-indigo-600 transition-all duration-200">
                   Submit Details
                </button>
            </div>
        </form>
    </div>
</div>
<div id="successModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden justify-center items-center z-50 px-4">
    <div class="relative bg-gradient-to-br from-[#1f1d2b] to-[#2a263b] border border-[#3f3b53] rounded-2xl shadow-2xl p-8 w-full max-w-md text-center text-white animate-scale-fade">
        <!-- Close button (top-right) -->
        <button onclick="closeSuccessModal()" class="absolute top-3 right-3 text-white text-2xl transition leading-none">
            &times;
        </button>
        
        <!-- Content -->
        <h2 class="text-3xl font-bold text-yellow-400 mb-3 animate-pulse">🎉 Achieved!</h2>
        <p class="text-lg text-gray-300">Thank you for submitting your details. Our team will review and connect with you shortly.</p>

        <button onclick="closeSuccessModal()" class="mt-6 px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-black font-semibold rounded-full transition duration-200">
            Close
        </button>
    </div>
</div>

<!-- fill form modal js -->
<script>
    function openFormModal(type) {        
        let tag=document.getElementById('tag');
        let tagname=document.getElementById('tagname');
        if (type=='360') {
            tag.value='360'
            tagname.innerText='(Mega Event Traveller)'
        }else if(type=='180'){
            tag.value='180'
            tagname.innerText='(Classic Stalker)'
        }else if(type=='90'){
            tag.value='90'
            tagname.innerText='(Executive Access)'
        }
        document.getElementById('fillFormModal').classList.remove('hidden');
        document.getElementById('fillFormModal').classList.add('flex');
    }

    function closeFormModal() {
        document.getElementById('fillFormModal').classList.add('hidden');
        document.getElementById('fillFormModal').classList.remove('flex');
    }
</script>
<!-- thank you popup js -->
 <script>
    function openSuccessModal() {
        // Close the form modal if needed
        closeFormModal(); // Optional
        // Show the success modal
        // const modal = document.getElementById('successModal');
        // modal.classList.remove('hidden');
        // modal.classList.add('flex');
        document.getElementById("user_detail_form").submit();
    }

    function closeSuccessModal() {
        const modal = document.getElementById('successModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function closeFormModal() {
        const modal = document.getElementById('fillFormModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

<script>
    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.style.display = 'none';
    }

    // Auto-open on page load
    window.addEventListener('DOMContentLoaded', () => {
        document.getElementById('imageModal').style.display = 'flex';
    });
</script>
@if($percent_90>=100 || $percent_180>=100)
<script>
    document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('congratsModal').classList.remove('hidden');
            document.getElementById('congratsModal').classList.add('flex');
    });

    function closeModal() {
        const modal = document.getElementById('congratsModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endif
<script>
    function switchTab(tabId) {
        const tabs = ['90', '180'];
        tabs.forEach((id) => {
            // Toggle button grayscale
            const tabButton = document.getElementById(`tab-${id}`);
            if (tabId === id) {
                tabButton.classList.remove('grayscale');
            } else {
                tabButton.classList.add('grayscale');
            }
            // Toggle content visibility
            const tabContent = document.getElementById(`tab-content-${id}`);
            if (tabId === id) {
                tabContent.classList.remove('hidden');
            } else {
                tabContent.classList.add('hidden');
            }
        });
    }
    // Set default tab on page load
    // document.addEventListener('DOMContentLoaded', () => switchTab('90'));
</script>


    @if($percent_180 >= 100)
        <script>
            document.addEventListener('DOMContentLoaded', () => switchTab('180'));
        </script>
    @elseif($percent_90 >= 100)
        <script>
            document.addEventListener('DOMContentLoaded', () => switchTab('90'));
        </script>
    @else
        <script>
            document.addEventListener('DOMContentLoaded', () => switchTab('180'));
        </script>
    @endif
@endsection