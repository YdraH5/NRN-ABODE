<div>
    <div>
        <!-- Search Bar -->
        <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm">
            <div class="flex gap-2 text-gray-700">
                <h1 class="text-2xl font-semibold text-black">Reservations</h1>
            </div>
            <div class="relative w-1/2 ml-auto">
                <input id="search-input" wire:model.debounce.300ms.live="search" type="search" placeholder="Search..."
                    class="w-full h-12 pl-4 pr-12 py-2 text-gray-700 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" width="1.25rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
                </svg>
            </div>
        </div>
        <!-- Table -->
        <div class="overflow-x-auto bg-white shadow-lg">
            <table class="min-w-full mx-2 border-collapse">
                <thead>
                    @if (session('success'))
                    <tr>
                        <td colspan="8" class="text-center bg-green-200 text-green-700 py-2">
                            {{ session('success') }}
                        </td>
                    </tr>
                    @endif
                    <tr class="bg-indigo-500 text-white uppercase text-sm">
                        <th class="py-3 px-4 text-center border-b border-indigo-600">NAME</th>
                        <th class="py-3 px-4 text-center border-b border-indigo-600">EMAIL</th>
                        <th class="py-3 px-4 text-center border-b border-indigo-600">ROOM INFO</th>
                        <th class="py-3 px-4 text-center border-b border-indigo-600">CHECK IN</th>
                        <th class="py-3 px-4 text-center border-b border-indigo-600">RENTAL PERIOD</th>
                        <th class="py-3 px-4 text-center border-b border-indigo-600">PAYMENT STATUS</th>
                        <th class="py-3 px-4 text-center border-b border-indigo-600">TOTAL AMOUNT</th>
                        <th class="py-3 px-4 text-center border-b border-indigo-600">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                    <tr class="hover:bg-indigo-100 ">
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->user_name}}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->email}}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->building_name}}-{{$reservation->room_number}}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->check_in_date}}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->rental_period}} Months</td>
                        @if($reservation->status === 'approval')
                        <td class="text-center border border-black-900 bg-yellow-100">Need approval</td>
                        @else
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->status}}</td>
                        @endif
                        <td class="py-3 px-4 text-center border-b border-gray-300">₱{{$reservation->total_price}}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">
                            <button wire:click="showReceipt('{{ asset($reservation->receipt) }}', '{{ $reservation->status }}', '{{ $reservation->reservation_id }}')"
                                x-data x-on:click="$dispatch('open-modal',{name:'view-receipt'})">
                                @include('components.view-icon')
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $reservations->links('components.pagination') }}
        </div>
    </div>
    <x-modal name="view-receipt" title="Receipt">
        <x-slot name="body">
            <div class="p-4 flex flex-col items-center">
                @if($currentReceipt)
                <img src="{{ $currentReceipt }}" alt="Receipt Image" style="max-height: 400px; max-width: 100%;">
                @endif
                <div class="flex justify-end py-2">
                    <button wire:click ="close()"x-on:click="$dispatch('close-modal',{name:'view-receipt'})" type="button"
                        class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-4">Close</button>
                    @if($currentStatus === 'approval')
                    <button type="button"
                        class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded"
                        wire:click="approve({{ $id }})"
                        x-on:click="$dispatch('close-modal',{name:'view-receipt'})">Approve</button>
                    @endif
                </div>
            </div>
        </x-slot>
    </x-modal>
