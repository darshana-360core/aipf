@extends('layouts.app')

@section('title', 'My Directs')

@section('content')
<section class="w-full p-3 md:p-5 mx-auto max-w-[1400px]">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5 overflow-hidden">
        <x-stat-box
            title="Direct Team Investment"
            value="{{ number_format($data['user']['direct_business'], 2) }} RTX"
            rtxval="${{ number_format($data['rtxPrice'] * $data['user']['direct_business'], 2) }}"
            bgColor="#0BF4C8"
            borderColor="#0BF4C8"
            imageSrc="{{ asset('assets/images/icons/direct-investment.webp') }}" />

        <x-stat-box
            title="Total Team Investment"
            value="{{ number_format($data['user']['my_business'], 2) }} RTX"
            rtxval="${{ number_format($data['rtxPrice'] * $data['user']['my_business'], 2) }}"
            bgColor="#FAD85D"
            borderColor="#FAD85D"
            imageSrc="{{ asset('assets/images/icons/total-team.webp') }}" />

    </div>
    <h2 class="text-lg sm:text-xl font-semibold text-white mb-4">My Directs</h2>
    <div class="w-full p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl">
        <div class="mb-4 border-b-2 border-[#322751]">
            <ul class="incomeOverview_tab flex flex-nowrap justify-center -mb-px text-sm font-medium text-center overflow-auto" data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-total_directs" data-tabs-target="#total_directs" type="button" role="tab" aria-controls="total_directs" aria-selected="false">Total Directs</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-2 sm:p-4 rounded-t-lg text-sm sm:text-base uppercase text-nowrap" id="table-active_directs" data-tabs-target="#active_directs" type="button" role="tab" aria-controls="active_directs" aria-selected="false">Active Directs</button>
                </li>
            </ul>
        </div>
        <div id="default-tab-content">
            <div class="hidden" id="total_directs" role="tabpanel" aria-labelledby="table-total_directs">
                <div class="overflow-x-auto">
                    <table id="tabledata1" class="w-full text-left border-collapse" style="padding-top: 15px;">
                        <thead>
                            <tr class="bg-white bg-opacity-10 text-white">
                                <th class="px-4 py-2">Sr.</th>
                                <!-- <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">User Id</span></th> -->
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Wallet Address</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Direct</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Team</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">RTX</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Business($)</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Stake RTX</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Stake ($)</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Registration Date</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Stake Date</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Rank</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Level</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $totalBusiness=0;
                            $totalStake=0;
                            @endphp
                            @if(count($data['data']) > 0)
                            @foreach ($data['data'] as $key => $value)
                            <tr>
                                <td class="text-nowrap px-4 py-2">{{ $key + 1 }}</td>
                                <!-- <td class="text-nowrap px-4 py-2 text-center text-[#30b8f5]">#{{ $value['refferal_code'] }}</td> -->
                                <td class="text-nowrap px-4 py-2 text-center">{{ substr($value['wallet_address'], 0, 6) }}...{{ substr($value['wallet_address'], -6) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['my_direct'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['my_team'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ number_format($value['my_business'], 2) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">${{ number_format($data['rtxPrice'] * $value['my_business'], 2) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center text-[#30b8f5]">{{ number_format($value['totalPackage'], 2) }} RTX</td>
                                <td class="text-nowrap px-4 py-2 text-center">${{ number_format($data['rtxPrice'] * $value['totalPackage'], 2) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ \Carbon\Carbon::parse($value['created_on'], 'UTC')->setTimezone('Europe/London')->format('d-m H:i') }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">@if($value['currentPackageDate'] != '-') {{ \Carbon\Carbon::parse($value['currentPackageDate'], 'UTC')->setTimezone('Europe/London')->format('d-m H:i') }} @else - @endif</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['rank'] == 0 ? "No Rank" : $value['rank'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['level'] == 0 ? "No X" : "X " . $value['level'] }}</td>
                            </tr>
                            @php
                                $totalBusiness += floatval($data['rtxPrice']) * floatval($value['my_business']);
                                $totalStake += floatval($value['totalPackage']);
                            @endphp
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    <h3>Total Business($) : {{ number_format($totalBusiness,3) }}</h3>
                    <h3>Total Stake RTX: {{  number_format($totalStake,3) }} RTX</h3>
                </div>
            </div>
            <div class="hidden" id="active_directs" role="tabpanel" aria-labelledby="table-active_directs">
                <div class="overflow-x-auto">
                    <table id="tabledata2" class="w-full text-left border-collapse" style="padding-top: 15px;">
                        <thead>
                            <tr class="bg-white bg-opacity-10 text-white">
                                <th class="px-4 py-2">Sr.</th>
                                <!-- <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">User Id</span></th> -->
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Wallet Address</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Direct</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Team</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">RTX</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Business($)</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Stake RTX</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Stake ($)</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Registration Date</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Stake Date</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Rank</span></th>
                                <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Level</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $totalBusinesss=0;
                            $totalStakes=0;
                            @endphp
                            @if(count($data['data']) > 0)
                            @foreach ($data['data'] as $key => $value)
                            @if($value['totalPackage'] > 1)
                            <tr>
                                <td class="text-nowrap px-4 py-2">{{ $key + 1 }}</td>
                                <!-- <td class="text-nowrap px-4 py-2 text-center text-[#30b8f5]">#{{ $value['refferal_code'] }}</td> -->
                                <td class="text-nowrap px-4 py-2 text-center">{{ substr($value['wallet_address'], 0, 6) }}...{{ substr($value['wallet_address'], -6) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['my_direct'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['my_team'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ number_format($value['my_business'], 2) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">${{ number_format($data['rtxPrice'] * $value['my_business'], 2) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center text-[#30b8f5]">{{ number_format($value['totalPackage'], 2) }} RTX</td>
                                <td class="text-nowrap px-4 py-2 text-center">${{ number_format($data['rtxPrice'] * $value['totalPackage'], 2) }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ \Carbon\Carbon::parse($value['created_on'], 'UTC')->setTimezone('Europe/London')->format('d-m H:i') }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">@if($value['currentPackageDate'] != '-') {{ \Carbon\Carbon::parse($value['currentPackageDate'], 'UTC')->setTimezone('Europe/London')->format('d-m H:i') }} @else - @endif</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['rank'] == 0 ? "No Rank" : $value['rank'] }}</td>
                                <td class="text-nowrap px-4 py-2 text-center">{{ $value['level'] == 0 ? "No X" : "X " . $value['level'] }}</td>
                            </tr>
                            @php
                                $totalBusinesss += floatval($data['rtxPrice']) * floatval($value['my_business']);
                                $totalStakes += floatval($value['totalPackage']);
                            @endphp
                            @endif
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    <h3>Total Business($) : {{  number_format($totalBusinesss,3)}}</h3>
                    <h3>Total Stake RTX : {{  number_format($totalStakes,3) }} RTX</h3>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection