<h2 class="text-lg font-semibold mb-4">My Packages</h2>
<div class="overflow-x-auto">
    <table id="cryptoTable" class="w-full text-left border-collapse" style="padding-top: 15px;">
        <thead>
            <tr class="bg-white bg-opacity-10 text-white">
                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md">Sr No.</th>
                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md">Amount In RTX</th>
                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md">Amount In $</th>
                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md">Stake</th>
                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md">Lock Period</th>
                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md">Transaction Hash</th>
                <th class="whitespace-nowrap text-sm md:text-base font-normal px-4 py-3 cursor-pointer bg-[#34333a] first:rounded-tl-md last:rounded-tr-md">Date</th>
            </tr>
        </thead>
        <tbody>
            @if (count($data['my_packages']) > 0)
            @php
                $lockPeriods = [
                    0 => '24 Hours',
                    1 => '30 Days',
                    2 => '90 Days',
                    3 => '180 Days',
                    4 => '360 Days'
                ];
            @endphp
            @foreach ($data['my_packages'] as $key => $value)
            <tr class="border-b border-white/5 hover:bg-[#34333a]/20">
                <td class="whitespace-nowrap px-4 py-4 text-sm md:text-base font-light leading-none text-gray-400">{{ $key + 1 }}</td>
                <td class="whitespace-nowrap px-4 py-4 text-sm md:text-base font-light leading-none text-gray-400">{{ number_format($value['amount'], 2) }} RTX</td>
                <td class="whitespace-nowrap px-4 py-4 text-sm md:text-base font-light leading-none text-gray-400">${{ number_format($value['amount'] * $data['rtxPrice'], 2) }}</td>
                <td class="whitespace-nowrap px-4 py-4 text-sm md:text-base font-light leading-none text-gray-400">{{ $value['package_id'] == 1 ? "Stake" : ($value['package_id'] == 2 ? "LP Bond" : "Stable Bond"); }}</td>
                <td class="whitespace-nowrap px-4 py-4 text-sm md:text-base font-light leading-none text-gray-400">{{ $lockPeriods[$value['lock_period']] ?? '-' }}</td>
                <td class="whitespace-nowrap px-4 py-4 text-sm md:text-base font-light leading-none text-gray-400">
                    <a href="https://bscscan.com/tx/{{ $value['transaction_hash'] }}" target="_blank" class="text-blue-600 flex items-center gap-2">{{ substr($value['transaction_hash'], 0, 6) }}...{{ substr($value['transaction_hash'], -4) }}</a>
                </td>
                <td class="whitespace-nowrap px-4 py-4 text-sm md:text-base font-light leading-none text-gray-400">{{ \Carbon\Carbon::parse($value['created_on'], 'UTC')->setTimezone('Europe/London')->format('d-m H:i') }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>