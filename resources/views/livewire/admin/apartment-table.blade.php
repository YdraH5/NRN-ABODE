<div> 
     <!-- Search Bar -->
     <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm no-print">
        <div class="flex gap-2 text-gray-700">
            <h1 class="no-print text-2xl font-semibold text-black">Apartments</h1>
        </div>
        <div class="no-print relative w-1/2 ml-auto">
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
                    <h1 class="text-2xl font-bold text-gray-800">Apartment Management Report</h1>
                    <p class="text-gray-600 text-sm">Generated on: {{ date('F d, Y') }}</p>
                </div>
            </div>
            
            <h2 class="text-xl font-semibold mb-6 text-indigo-600">Apartment Report</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-medium text-blue-600">Available</h3>
                    <p class="text-4xl font-bold">{{ $availableCount }}</p>
                </div>
                <div class="bg-green-100 p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-medium text-green-600">Occupied</h3>
                    <p class="text-4xl font-bold">{{ $occupiedCount }}</p>
                </div>
                <div class="bg-yellow-100 p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-medium text-yellow-600">Reserved</h3>
                    <p class="text-4xl font-bold">{{ $reservedCount }}</p>
                </div>
                <div class="bg-red-100 p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-medium text-red-600">Unavailable</h3>
                    <p class="text-4xl font-bold">{{ $unavailableCount }}</p>
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
                    @if (session('success'))
                    <div class="alert alert-success text-green-700">
                        {{ session('success') }}
                    </div>    
                    @endif
                    
                    <tr class="bg-indigo-500 text-white uppercase text-sm">
                        <th wire:click="doSort('room_number')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                            <div class="inline-flex items-center justify-center">
                                Room Number
                                <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="room_number" />
                            </div>
                        </th>               
                        <th wire:click="doSort('building')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                            <div class="inline-flex items-center justify-center">
                                Building
                                <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="building" />
                            </div>
                        </th>  
                        <th wire:click="doSort('categ_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                            <div class="inline-flex items-center justify-center">
                                Category
                                <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="categ_name" />
                            </div>
                        </th>  
                        <th wire:click="doSort('renters_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                            <div class="inline-flex items-center justify-center">
                                Renters/Reservist
                                <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="renters_name" />
                            </div>
                        </th>  
                        <th wire:click="doSort('status')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                            <div class="inline-flex items-center justify-center">
                                Status
                                <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="status" />
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($apartmentsPrint as $apartments)
                    <tr class="hover:bg-indigo-100">
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->room_number}}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->building}}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->categ_name}}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->renters_name ?? 'Vacant'}}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->status}}</td>
                    </tr>
                    @endforeach  
                </tbody>
            </table>
        </div>
    <!-- Table -->
    <div class="no-print overflow-x-auto bg-white shadow-lg">
        <table class="min-w-full mx-2 border-collapse">
            <thead> 
                @if (session('success'))
                <div class="alert alert-success text-green-700">
                    {{ session('success') }}
                </div>    
                @endif
                
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th wire:click="doSort('room_number')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Room Number
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="room_number" />
                        </div>
                    </th>               
                    <th wire:click="doSort('building')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Building
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="building" />
                        </div>
                    </th>  
                    <th wire:click="doSort('categ_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Category
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="categ_name" />
                        </div>
                    </th>  
                    <th wire:click="doSort('renters_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Renters/Reservist
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="renters_name" />
                        </div>
                    </th>  
                    <th wire:click="doSort('status')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Status
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="status" />
                        </div>
                    </th>
                    <th wire:click="doSort('status')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Occupants
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="status" />
                        </div>
                    </th>
                    <th class="no-print py-3 px-4 text-center border-b border-indigo-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($apartment as $apartments)
                <tr class="hover:bg-indigo-100">
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->room_number}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->building}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->categ_name}}</td>
                    @if($apartments->renters_name == NULL)
                    <td class="py-3 px-4 text-center border-b border-gray-300">Vacant</td>
                    @else
                        <td class="py-3 px-4 text-center border-b border-gray-300">
                            {{$apartments->renters_name}}
                    @endif
                        </td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->status}}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">
                        @php
                        $occupants = App\Models\Reservation::where('user_id', $apartments->renter_id)
                            ->select('occupants')
                            ->get();
                        @endphp
                        @foreach ($occupants as $reservation)
                            {{ $reservation->occupants }}
                        @endforeach
                        </td>
                        <td class="no-print py-3 px-4 text-center border-b border-gray-300">
                            <div class="flex justify-center gap-1"> 

                             <button
                             x-data="{ id: {{$apartments->id}} }"
                             x-data x-on:click="$wire.set('id', id); $dispatch('open-modal',{name:'add-renter'})"
                             wire:click="saveApartment(id)"
                             @if($apartments->status !== 'Available') disabled title ="disabled" 
                             @else title ="Add renter" 
                             @endif
                             >
                             @include('components.add-renter')
                             </button>
                             <!-- modal for adding a renters to apartment when there is a walk in customer -->
                             <x-modal name="add-renter" title="Add Renter">
                                <x-slot name="body">
                                    <form wire:submit.prevent="saveRenter" class="relative space-y-4">
                                        <!-- Email Input Field -->
                                        <div>
                                            <label class="block font-medium opacity-70">Email</label>
                                            @error('email') 
                                                <span class="error text-red-900">{{ $message }}</span> 
                                            @enderror
                                            <input type="text" 
                                                wire:model="email" 
                                                placeholder="Enter email" 
                                                class="mt-2 text-gray-600 focus:outline-none focus:border-indigo-700 font-normal w-full h-10 pl-3 border border-gray-300 rounded-md" 
                                                wire:keyup="searchUser">

                                            <!-- Search Results -->
                                            @if(!$selectedEmail)
                                                <ul class="absolute bg-white border rounded mt-1 w-full max-h-40 overflow-y-auto z-10">
                                                    @if($users && $users->isNotEmpty())
                                                        @foreach($users as $user)
                                                            @if($user->role === null)
                                                                <li wire:click="selectUser('{{ $user->id }}', '{{ $user->email }}')" 
                                                                    class="p-1 cursor-pointer hover:bg-gray-200">
                                                                    {{ $user->email }}
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <li class="p-2 text-gray-500">No emails found</li>
                                                    @endif
                                                </ul>
                                            @endif
                                            
                                        </div>

                                        <!-- Check-in Date -->
                                        <div>
                                            <label class="block font-medium opacity-70">Check-in Date</label>
                                            <input type="date" wire:model="check_in" class="mt-2 text-gray-600 focus:outline-none focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 w-full h-10 pl-3 border border-gray-300 rounded-md">
                                            @error('check_in') <span class="error text-red-900">{{ $message }}</span> @enderror
                                        </div>
                                        <!-- oCCUPANTS -->
                                        <div>
                                            <label class="block font-medium opacity-70">Number of Occupants
                                            </label>
                                            <input type="number" wire:model="occupants" placeholder="Number of months" class="mt-2 text-gray-600 focus:outline-none focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 w-full h-10 pl-3 border border-gray-300 rounded-md">
                                            @error('rental_period') <span class="error text-red-900">{{ $message }}</span> @enderror
                                        </div>
                                        <!-- Rental Period -->
                                        <div>
                                            <label class="block font-medium opacity-70">Rental Period (Months)</label>
                                            <input type="number" wire:model="rental_period" placeholder="Number of months" class="mt-2 text-gray-600 focus:outline-none focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 w-full h-10 pl-3 border border-gray-300 rounded-md">
                                            @error('rental_period') <span class="error text-red-900">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex items-center justify-between py-4">
                                            <button type="submit" 
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                                                Submit
                                            </button>
                                            <button x-on:click="$dispatch('close-modal', {name: 'add-renter'})" 
                                                    type="button" 
                                                    class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-md">
                                                Close
                                            </button>
                                        </div>
                                    </form>
                                </x-slot>
                            </x-modal>
                            <!-- end of modal adding renter -->

                        </div>
                    </td>
                </tr>
                @endforeach  
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="py-4 no-print">
        <div class="flex items-center mb-3">
            <label for="perPage" class="no-print mr-2 mt-2 text-sm font-medium text-gray-700">Per Page:</label>
            <select id="perPage" wire:model.live="perPage" class="no-print border border-gray-300 rounded px-2 py-1 h-8 w-20 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="" disabled selected>Select</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
        </div>
        <div class="mt-4">
        {{ $apartment->links()}}
        </div>
    </div>
  </div>
  
</div>
