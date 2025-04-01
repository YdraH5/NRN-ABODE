<div>
    <!-- Search Bar -->
    <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm no-print">
        <div class="flex gap-2 text-gray-700">
            <h1 class="no-print text-2xl font-semibold text-black">Reservations Report</h1>
        </div>
        <div class="relative w-1/2 ml-auto">
            <input id="search-input" wire:model.debounce.300ms.live="search" type="search" placeholder="Search..."
                class="no-print w-full h-12 pl-4 pr-12 py-2 text-gray-700 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
            <svg class="no-print absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" width="1.25rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
            </svg>
        </div>
        <button onclick="window.print()" class="no-print bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Print Report
        </button>
    </div>

    <!-- Print-Only Section -->
    <div class="print-only bg-white p-6 rounded-lg shadow-md mb-6">
        <!-- Logo and Title -->
        <div class="flex items-center justify-between mb-4">
            <img src="{{ asset('images/NRN LOGO.png') }}" class="h-16">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-800">Reservation Management Report</h1>
                <p class="text-gray-600 text-sm">Generated on: {{ date('F d, Y') }}</p>
            </div>
        </div>

        <h2 class="text-xl font-semibold mb-6 text-indigo-600">Reservation Summary</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-medium text-blue-600">Total Reservations</h3>
                <p class="text-4xl font-bold">{{ $totalReservations }}</p>
            </div>
            <div class="bg-green-100 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-medium text-green-600">Approved</h3>
                <p class="text-4xl font-bold">{{ $approvedCount }}</p>
            </div>
            <div class="bg-yellow-100 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-medium text-yellow-600">Pending</h3>
                <p class="text-4xl font-bold">{{ $pendingCount }}</p>
            </div>
            <div class="bg-red-100 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-medium text-red-600">Rejected</h3>
                <p class="text-4xl font-bold">{{ $rejectedCount }}</p>
            </div>
        </div>

        <!-- Prepared By Section -->
        <div class="mt-10 border-t pt-4">
            <p class="text-gray-700 font-medium">Prepared by: <span class="font-bold">{{ auth()->user()->name }}</span></p>
            <p class="text-gray-600 text-sm">Position: {{ auth()->user()->role }}</p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="print-only overflow-x-auto bg-white shadow-lg">
        <table class="min-w-full mx-2 border-collapse">
            <thead>
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th wire:click="doSort('user_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Name
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="user_name" />
                        </div>
                    </th>
                    <th wire:click="doSort('email')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Email
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="email" />
                        </div>
                    </th>
                    <th wire:click="doSort('building_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Room Info
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="building_name" />
                        </div>
                    </th>
                    <th wire:click="doSort('check_in')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Check In
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="check_in" />
                        </div>
                    </th>
                    <th wire:click="doSort('rental_period')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Rental Period
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="rental_period" />
                        </div>
                    </th>
                    <th wire:click="doSort('status')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Payment Status
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="status" />
                        </div>
                    </th>
                    <th wire:click="doSort('total_price')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Total Amount
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="total_price" />
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
        
                @foreach($reservations->filter(function ($reservation) {
                    return \Carbon\Carbon::parse($reservation->check_in)->isCurrentMonth() && 
                           \Carbon\Carbon::parse($reservation->check_in)->isCurrentYear();
                }) as $reservation)
                    <tr class="hover:bg-indigo-100">
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->user_name}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->email}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->building_name}}-{{$reservation->room_number}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->check_in_date}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->rental_period}} Months</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->reservation_status}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">₱{{ number_format($reservation->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Table Section -->
    <div class="no-print overflow-x-auto bg-white shadow-lg">
        <table class="min-w-full mx-2 border-collapse">
            <thead>
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th wire:click="doSort('user_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Name
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="user_name" />
                        </div>
                    </th>
                    <th wire:click="doSort('email')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Email
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="email" />
                        </div>
                    </th>
                    <th wire:click="doSort('building_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Room Info
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="building_name" />
                        </div>
                    </th>
                    <th wire:click="doSort('check_in')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Check In
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="check_in" />
                        </div>
                    </th>
                    <th wire:click="doSort('rental_period')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Rental Period
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="rental_period" />
                        </div>
                    </th>
                    <th wire:click="doSort('status')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Payment Status
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="status" />
                        </div>
                    </th>
                    <th wire:click="doSort('total_price')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Total Amount
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="total_price" />
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                <tr class="hover:bg-indigo-100">
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->user_name}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->email}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->building_name}}-{{$reservation->room_number}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->check_in_date}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->rental_period}} Months</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->reservation_status}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">₱{{ number_format($reservation->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="no-print py-4">
        <div class="mt-4">
            {{ $reservations->links() }}
        </div>
    </div>

    <!-- Modal for Viewing Receipt -->
    <x-modal name="view-receipt" title="Receipt">
        <x-slot name="body">
            <div class="p-4 flex flex-col items-center">
                @if($currentReceipt)
                <img src="{{ $currentReceipt }}" alt="Receipt Image" style="max-height: 400px; max-width: 100%;">
                @endif
                <div class="flex justify-end py-2">
                    <button wire:click ="reject({{$id}})" x-on:click="$dispatch('close-modal',{name:'view-receipt'})" type="button"
                        class="bg-red-400 hover:bg-red-600 text-white font-bold py-2 px-4 rounded mr-4">Reject</button>
                    @if($currentStatus === 'pending')
                    <button type="button"
                        class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded"
                        wire:click="approve({{ $id }})"
                        x-on:click="$dispatch('close-modal',{name:'view-receipt'})">Approve</button>
                    @endif
                </div>
            </div>
        </x-slot>
    </x-modal>
</div>