<h2 class="text-lg font-semibold mb-4">My Packages</h2>
<div class="overflow-x-auto">
    <table id="cryptoTable" class="w-full text-left border-collapse" style="padding-top: 15px;">
        <thead>
            <tr class="bg-white bg-opacity-10 text-white">
                <th class="px-4 py-2">Sr No.</th>
                <th class="px-4 py-2">Amount</th>
                <th class="px-4 py-2">Roi</th>
                <th class="px-4 py-2">Days</th>
                <th class="px-4 py-2">Capping</th>
                <th class="px-4 py-2">Max Capping</th>
            </tr>
        </thead>
        <tbody>
            @if (count($data['my_packages']) > 0)
            @foreach ($data['my_packages'] as $key => $value)
            <tr>
                <td class="text-nowrap px-4 py-2">{{ $key + 1 }}</td>
                <td class="text-nowrap px-4 py-2">{{ $value['amount'] }}</td>
                <td class="text-nowrap px-4 py-2">0.5%</td>
                <td class="text-nowrap px-4 py-2">{{ $value['created_on'] }}</td>
                <td class="text-nowrap px-4 py-2">{{ ($value['amount']*2) }}</td>
                <td class="text-nowrap px-4 py-2">{{ ($value['amount']*5) }}</td>

            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>