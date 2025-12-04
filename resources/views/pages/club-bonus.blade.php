@extends('layouts.app')

@section('title', 'Club Bonus')

@section('content')
<!-- Flatpickr CSS -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> -->

<section class="grid grid-cols-1 gap-5 mt-5">
    <div class="w-full p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-3 mb-6">
                <div class="w-2 h-12 bg-gradient-to-b from-blue-400 to-purple-600 rounded-full"></div>
                <h1 class="text-4xl md:text-5xl font-bold text-white">Club Bonus</h1>
                <div class="w-2 h-12 bg-gradient-to-b from-purple-600 to-pink-600 rounded-full"></div>
            </div>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Participate in our revolutionary reward distribution system powered by rank achivement.
            </p>
        </div>

        <div class="w-full p-4 md:p-5 bg-[#171531] border border-[#845dcb] rounded-xl">
            
                <div id="total_directs">
                    <div class="overflow-x-auto">
                        <table id="clubBonus1" class="w-full text-left border-collapse" style="padding-top: 15px;">
                            <thead>
                                <tr class="bg-white bg-opacity-10 text-white">
                                    <th class="px-4 py-2">Sr.</th>
                                    <!-- <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">User Id</span></th> -->
                                    <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Wallet Address</span></th>
                                    <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Amount</span></th>
                                    <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Club</span></th>
                                    <th class="px-4 py-2 text-center text-center"><span class="text-nowrap w-full block text-center">Date</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($data['club_data']))
                                    @foreach ($data['club_data'] as $key => $value)
                                    <tr>
                                        <td class="text-nowrap px-4 py-2">{{ $key + 1 }}</td>
                                        <td class="text-nowrap px-4 py-2 text-center">{{ substr($value['wallet_address'], 0, 6) }}...{{ substr($value['wallet_address'], -6) }}</td>
                                        <td class="text-nowrap px-4 py-2 text-center">{{ round($value['clubBonus'], 3) }}</td>
                                        <td class="text-nowrap px-4 py-2 text-center">{{$value['refrence']}}</td>
                                        <td class="text-nowrap px-4 py-2 text-center">{{ date('d-m-Y', strtotime($value['created_on'])) }}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            
        </div>
    </div>
</section>
    @section('script')
    <script>
        $(document).ready(function () {
            // table
            if ($.fn.DataTable.isDataTable("#clubBonus1")) {
                $("#clubBonus1").DataTable().destroy(); // Destroy existing DataTable instance
            }

            $("#clubBonus1").DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "lengthMenu": [5, 10, 25, 50, 100],
                "pageLength": 100,
                "info": true
            });
        });
    </script>
    @endsection
@endsection