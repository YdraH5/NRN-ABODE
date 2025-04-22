@section('title', 'Home')
@section('renters')
<x-renter-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Renter Dashboard
            </h2>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600">Welcome back, {{ Auth::user()->name }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </x-slot>

    @foreach($reservations as $reservation)
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Lease Summary Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">Lease Agreement</h3>
                                <p class="text-gray-600">Your current rental details</p>
                            </div>
                        </div>
                        
                        <!-- Contract Modal -->
                        <div id="contractContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                            <div class="bg-white rounded-lg shadow-xl relative max-w-5xl w-full">
                                <div class="p-4 border-b flex justify-between items-center">
                                    <h3 class="text-lg font-semibold text-gray-800">Lease Contract</h3>
                                    <button id="closeContractBtn" class="text-gray-500 hover:text-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-4">
                                    <iframe id="contractFrame" 
                                        src="{{ route('renters.downloadContract', ['user_id' => Auth::user()->id, 'apartment_id' => $reservation->apartment_id, 'reservation_id' => $reservation->reservation_id]) }}" 
                                        class="w-full h-[70vh] border rounded" frameborder="0">
                                    </iframe>
                                </div>
                            </div>
                        </div>

                        <button id="viewContractBtn" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            View Contract
                        </button>
                    </div>
                    
                    @if (session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Lease Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-2 rounded-full mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Lease Start</p>
                                    <p class="font-semibold text-gray-800">{{ date('F jS Y', strtotime($reservation->check_in)) }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-2 rounded-full mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Lease End</p>
                                    <p class="font-semibold text-gray-800">{{ date('F jS Y', strtotime($reservation->end_date)) }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-2 rounded-full mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Monthly Rent</p>
                                    <p class="font-semibold text-gray-800">₱{{ number_format($reservation->price, 2) }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-2 rounded-full mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Status</p>
                                    <p class="font-semibold text-green-600">Active</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contract Actions -->
                    <div class="border-t pt-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div class="max-w-lg">
                                <h4 class="font-medium text-gray-800 mb-1">Contract Extension</h4>
                                <p class="text-sm text-gray-600">You can extend your rental period at any time. Please submit your request at least 30 days before your current lease ends.</p>
                            </div>
                            <button 
                                x-data="{ id: {{$reservation->reservation_id}} }" 
                                x-on:click="$dispatch('open-modal', { name: 'extend' })"
                                type="button" 
                                class="flex-shrink-0 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 shadow-md flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Extend Contract
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Extend Contract Modal -->
            <div>
                <x-modal name="extend" title="Extend Lease Agreement" maxWidth="lg">
                    <x-slot:body>
                        <form action="{{ route('renters.extend') }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="apartment_id" value="{{ $reservation->apartment_id }}">
                            <input type="hidden" name="reservation_id" value="{{ $reservation->reservation_id }}">
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Number of Months</label>
                                    <input type="number" min="1" name="extend" placeholder="Enter number of months to extend" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                
                                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-blue-700">
                                                Your extension request will be reviewed by property management. You'll receive a confirmation once approved.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                                <button x-on:click="$dispatch('close-modal', {name:'extend'})" type="button" 
                                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Cancel
                                </button>
                                <button type="submit" 
                                    class="inline-flex justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Submit Request
                                </button>
                            </div>
                        </form>
                    </x-slot:body>
                </x-modal>
            </div>

            <!-- Announcements Section -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-100 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Announcements</h3>
                            <p class="text-gray-600">Important updates from property management</p>
                        </div>
                    </div>
                    
                    @if($announcements->count() > 0)
                        <div class="space-y-4">
                            @foreach($announcements as $announcement)
                                <div class="bg-white rounded-lg border @if($announcement->priority == 'High') border-red-200 bg-red-50 @elseif($announcement->priority == 'Medium') border-yellow-200 bg-yellow-50 @else border-blue-200 bg-blue-50 @endif overflow-hidden shadow-sm">
                                    <div class="p-5">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-800 mb-1">
                                                    {{ $announcement->title }}
                                                </h4>
                                                <p class="text-gray-600 mb-2">{{ $announcement->content }}</p>
                                            </div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                @if($announcement->priority == 'High') bg-red-100 text-red-800
                                                @elseif($announcement->priority == 'Medium') bg-yellow-100 text-yellow-800
                                                @else bg-blue-100 text-blue-800 @endif">
                                                {{ $announcement->priority }}
                                            </span>
                                        </div>
                                        <div class="flex items-center text-sm text-gray-500 mt-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Posted on {{ \Carbon\Carbon::parse($announcement->start_date)->format('M d, Y') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h4 class="mt-2 text-lg font-medium text-gray-700">No announcements</h4>
                            <p class="mt-1 text-gray-500">There are no announcements at this time.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-100 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Payment Information</h3>
                            <p class="text-gray-600">Your upcoming and past payments</p>
                        </div>
                    </div>
                    
                    @if($due_dates->isEmpty())
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h4 class="mt-2 text-lg font-medium text-gray-700">No payment dues</h4>
                            <p class="mt-1 text-gray-500">There are no payments due at this time.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($due_dates as $index => $due)
                                    @php
                                        $previousDue = $due_dates->slice(0, $index)->last();
                                        $canPay = !$previousDue || $previousDue->status === 'paid';
                                        $isPaid = $due->status === 'paid';
                                        $isPending = $due->status === 'pending';
                                        
                                        // Calculate days until due date
                                        $dueDate = \Carbon\Carbon::parse($due->payment_due_date);
                                        $today = \Carbon\Carbon::today();
                                        $daysUntilDue = $today->diffInDays($dueDate, false); // Negative if past due
                                        
                                        // Determine status
                                        $status = '';
                                        $statusColor = '';
                                        $highlightRow = false;
                                        
                                        if ($isPaid) {
                                            $status = 'Paid';
                                            $statusColor = 'bg-green-100 text-green-800';
                                        } elseif ($isPending) {
                                            $status = 'Processing';
                                            $statusColor = 'bg-yellow-100 text-yellow-800';
                                        } elseif ($daysUntilDue <= 0) {
                                            $status = 'Overdue';
                                            $statusColor = 'bg-red-100 text-red-800';
                                            $highlightRow = true;
                                        } elseif ($daysUntilDue <= 10) {
                                            $status = 'Due Soon';
                                            $statusColor = 'bg-orange-100 text-orange-800';
                                            $highlightRow = true;
                                        } else {
                                            $status = 'Upcoming';
                                            $statusColor = 'bg-blue-100 text-blue-800';
                                        }
                                    @endphp
                                    
                                    @if(!$isPaid)
                                    <tr class="@if($highlightRow) bg-{{ $daysUntilDue <= 0 ? 'red' : 'orange' }}-50 @endif hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $dueDate->format('F j, Y') }}</div>
                                            @if($daysUntilDue <= 10)
                                            <div class="text-xs @if($daysUntilDue <= 0) text-red-600 @else text-orange-600 @endif mt-1">
                                                @if($daysUntilDue < 0)
                                                    {{ abs($daysUntilDue) }} day(s) overdue
                                                @elseif($daysUntilDue == 0)
                                                    Due today
                                                @else
                                                    Due in {{ $daysUntilDue }} day(s)
                                                @endif
                                            </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">₱{{ number_format($due->amount_due, 2) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                                {{ $status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div x-data="{ showWarning: false }" class="relative">
                                                @if($isPending)
                                                    <span class="text-gray-500">Processing payment</span>
                                                @elseif($canPay)
                                                    <button 
                                                        x-on:click="$dispatch('open-modal', {name:'pay-bill-{{$index}}'})"
                                                        class="text-blue-600 hover:text-blue-900">
                                                        Make Payment
                                                    </button>
                                                @else
                                                    <button 
                                                        x-on:click="showWarning = true" 
                                                        @click.outside="showWarning = false"
                                                        class="text-gray-400 cursor-not-allowed relative">
                                                        Make Payment
                                                        <div x-show="showWarning" x-transition class="absolute z-10 w-48 mt-2 bg-white shadow-lg rounded-md p-2 text-xs text-red-600">
                                                            Please pay the earlier due payments first.
                                                        </div>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modals -->
@foreach($due_dates as $index => $due)
@php
    $isPaid = $due->status === 'paid';
    $isPending = $due->status === 'pending';
@endphp

@if(!$isPaid)
<x-modal name="pay-bill-{{$index}}" title="Make Payment" maxWidth="2xl">
    <x-slot:body>
        <form action="{{ route('renters.pay') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="due_id" value="{{ $due->id }}">
            <input type="hidden" name="amount_due" value="{{ $due->amount_due }}">
            <input type="hidden" name="apartment_id" value="{{ $reservation->apartment_id }}">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Amount Due</label>
                    <input type="text" readonly value="₱{{ number_format($due->amount_due, 2) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                    <input type="text" readonly value="{{ date('F j, Y', strtotime($due->payment_due_date)) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                    <select id="paymentMethod-{{$index}}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                        name="payment_method" 
                        onchange="toggleImageUpload({{ $index }})">
                        <option value="" disabled selected>Select Payment Method</option>
                        <option value="gcash">GCash</option>
                        <option value="cash">Cash (Office Payment)</option>
                        <option value="stripe">Credit/Debit Card</option>
                    </select>
                </div>

                <div id="imageUpload-{{$index}}" style="display:none;" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Proof of Payment</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="file-upload-{{$index}}" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input id="file-upload-{{$index}}" name="receipt" type="file" class="sr-only" onchange="previewImage(this, {{ $index }})">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, PDF up to 5MB</p>
                                <!-- Image preview container -->
                                <div id="imagePreview-{{$index}}" class="mt-4 hidden">
                                    <img id="previewImage-{{$index}}" src="#" alt="Preview" class="max-h-40 mx-auto">
                                    <button type="button" onclick="removeImage({{ $index }})" class="mt-2 text-sm text-red-600 hover:text-red-800">Remove Image</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($gcashDetails && $gcashDetails->gcash_number)
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-800 mb-2">GCash Payment Instructions</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-blue-700 mb-2">1. Open GCash app</p>
                                <p class="text-sm text-blue-700 mb-2">2. Go to "Send Money"</p>
                                <p class="text-sm text-blue-700 mb-2">3. Enter GCash number:</p>
                                <p class="font-bold text-blue-800">{{ $gcashDetails->gcash_number }}</p>
                            </div>
                            @if($gcashDetails->gcash_qr_image)
                            <div class="flex justify-center">
                                <img src="{{ asset('storage/' . $gcashDetails->gcash_qr_image) }}" alt="GCash QR Code" class="h-40">
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <button x-on:click="$dispatch('close-modal', {name:'pay-bill-{{$index}}'})" type="button" 
                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </button>
                <button type="submit" 
                    class="inline-flex justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Submit Payment
                </button>
            </div>
        </form>
    </x-slot:body>
</x-modal>
@endif
@endforeach

<script>
    function previewImage(input, index) {
    const previewContainer = document.getElementById(`imagePreview-${index}`);
    const previewImage = document.getElementById(`previewImage-${index}`);
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('hidden');
        }
        
        reader.readAsDataURL(file);
    }
}

function removeImage(index) {
    const fileInput = document.getElementById(`file-upload-${index}`);
    const previewContainer = document.getElementById(`imagePreview-${index}`);
    
    fileInput.value = ''; // Clear the file input
    previewContainer.classList.add('hidden');
}

// Update your existing toggleImageUpload function to hide preview when switching methods
function toggleImageUpload(index) {
    const selectElement = document.getElementById(`paymentMethod-${index}`);
    const imageUploadDiv = document.getElementById(`imageUpload-${index}`);
    const previewContainer = document.getElementById(`imagePreview-${index}`);

    if (selectElement.value === 'gcash') {
        imageUploadDiv.style.display = 'block';
    } else {
        imageUploadDiv.style.display = 'none';
        if (previewContainer) {
            previewContainer.classList.add('hidden');
        }
    }
}

        // Contract Modal Handling
        document.addEventListener('DOMContentLoaded', function() {
            const contractContainer = document.getElementById('contractContainer');
            const viewContractBtn = document.getElementById('viewContractBtn');
            const closeContractBtn = document.getElementById('closeContractBtn');

            viewContractBtn.addEventListener('click', function() {
                contractContainer.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });

            closeContractBtn.addEventListener('click', function() {
                contractContainer.classList.add('hidden');
                document.body.style.overflow = '';
            });

            contractContainer.addEventListener('click', function(e) {
                if (e.target === contractContainer) {
                    contractContainer.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !contractContainer.classList.contains('hidden')) {
                    contractContainer.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>
    @endforeach
    @stop
</x-renter-layout>
