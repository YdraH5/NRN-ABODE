@section('title', 'Full Details')

@include('layouts-visitor.app')

<div class="flex flex-col sm:flex-row items-center justify-center bg-white shadow-lg px-4 sm:px-32">
    <!-- Image section -->
    <div class="w-full h-auto p-2 bg-white">
    <h3 class="text-2xl sm:text-3xl font-heavy text-gray-800 mb-3">
        {{$apartment->categ_name}}
    </h3>
    <div class="h-auto">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-start w-full">
            @if (isset($images[$apartment->id]) && $images[$apartment->id]->isNotEmpty())
                <!-- Display images for the specific apartment -->
                <div class="col-span-1 sm:col-span-1 w-full">
                    <!-- First image larger on the left -->
                    <div class="relative group w-full h-[415px]">
                        <img src="{{ asset($images[$apartment->id][0]->image) }}" 
                            class="block w-full h-full object-cover clickable-image transition-transform duration-300" 
                            alt="Featured Apartment Image">
                        <div class="absolute top-0 left-0 w-full h-full bg-black opacity-0 transition-opacity duration-300 group-hover:opacity-20"></div>
                    </div>
                </div>

                <!-- Remaining 4 images on the right in 2 columns and 2 rows -->
                <div class="grid grid-cols-2 gap-4 col-span-2 sm:col-span-2">
                    @foreach ($images[$apartment->id]->take(5)->slice(1) as $image)
                        <div class="relative group w-full h-[200px]">
                            <img src="{{ asset($image->image) }}" 
                                class="block w-full h-full object-cover clickable-image transition-transform duration-300" 
                                alt="Apartment Image">
                            <div class="absolute top-0 left-0 w-full h-full bg-black opacity-0 transition-opacity duration-300 group-hover:opacity-20"></div>
                        </div>
                    @endforeach
                </div>
            @elseif (isset($images['fallback']) && $images['fallback']->isNotEmpty())
                <!-- Display fallback images -->
                <div class="col-span-1 sm:col-span-1 w-full">
                    <!-- First fallback image larger on the left -->
                    <div class="relative group w-full h-[415px]">
                        <img src="{{ asset($images['fallback'][0]->image) }}" 
                            class="block w-full h-full object-cover clickable-image transition-transform duration-300" 
                            alt="Fallback Featured Image">
                        <div class="absolute top-0 left-0 w-full h-full bg-black opacity-0 transition-opacity duration-300 group-hover:opacity-20"></div>
                    </div>
                </div>

                <!-- Remaining 4 fallback images on the right in 2 columns and 2 rows -->
                <div class="grid grid-cols-2 gap-4 col-span-2 sm:col-span-2">
                    @foreach ($images['fallback']->take(5)->slice(1) as $image)
                        <div class="relative group w-full h-[200px]">
                            <img src="{{ asset($image->image) }}" 
                                class="block w-full h-full object-cover clickable-image transition-transform duration-300" 
                                alt="Fallback Apartment Image">
                            <div class="absolute top-0 left-0 w-full h-full bg-black opacity-0 transition-opacity duration-300 group-hover:opacity-20"></div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>


</div>

<!-- Main container -->
<div class="flex flex-col sm:flex-row items-start justify-between bg-white shadow-lg p-4 sm:p-6 space-y-6 sm:space-y-0 sm:space-x-6 px-4 sm:px-[140px] min-h-screen">
    <!-- Left side: Apartment details -->
    @php
        // Decode the JSON-encoded description
        $features = json_decode($apartment->description, true);

        // Check for JSON errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            $features = []; // Reset to empty array if JSON decoding fails
        }

        // Initialize an array to hold feature descriptions
        $featureDescriptions = [];

        // Construct feature descriptions based on selected features
        if (isset($features['cr']) && $features['cr']) {
            $featureDescriptions[] = 'CR';
        }
        if (isset($features['livingRoom']) && $features['livingRoom']) {
            $featureDescriptions[] = 'Living Room';
        }
        if (isset($features['kitchen']) && $features['kitchen']) {
            $featureDescriptions[] = 'Kitchen';
        }
        if (isset($features['balcony']) && $features['balcony']) {
            $featureDescriptions[] = 'Balcony';
        }
        if (isset($features['aircon']) && $features['aircon']) {
            $featureDescriptions[] = 'Aircon';
        }
        if (isset($features['bed']) && $features['bed']) {
            $featureDescriptions[] = 'Bed';
        }
        if (isset($features['parking']) && $features['parking']) {
            $featureDescriptions[] = 'Parking Space';
        }
        if (!empty($features['otherText'])) {
            $featureDescriptions[] = 'Other: ' . $features['otherText'];
        }
        // Get tenant capacity (pax)
        $guests = isset($features['pax']) ? $features['pax'] : 'unknown number of guests';
    @endphp
    <!-- Replace the "What this room offers" section with this enhanced version -->
<div class="w-full sm:w-2/3 text-center sm:text-left flex flex-col justify-center">
    <!-- Price and availability header -->
    <div class="bg-blue-50 p-4 rounded-lg mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $apartment->categ_name }}</h2>
                <p class="text-lg text-blue-600 font-semibold">₱{{ number_format($apartment->price, 2) }} <span class="text-sm text-gray-600">/month</span></p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-medium 
                {{ $available > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $available > 0 ? $available . ' room' . ($available > 1 ? 's' : '') . ' available' : 'Currently unavailable' }}
            </span>
        </div>
    </div>

    <!-- Room description paragraph -->
    <div class="mb-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-3">About this room</h3>
        <p class="text-gray-700 leading-relaxed">
            The {{ $apartment->categ_name }} is designed to comfortably accommodate 
            @if($features['pax'] == 1)
                a single tenant.
            @else
                up to {{ $features['pax'] }} people.
            @endif
            
            @if($features['livingRoom'])
            The space features a welcoming living area 
            @endif
            
            @if($features['kitchen'])
            with a functional kitchen 
            @endif
            
            @if($features['cr'])
            and includes a private comfort room. 
            @endif
            
            @if($features['balcony'])
            Step outside to enjoy your private balcony space. 
            @endif
            
            @if($features['aircon'])
            Climate control is provided with air conditioning 
            @endif
            
            @if($features['bed'])
            and comes with comfortable sleeping arrangements. 
            @endif
            
            @if($features['parking'])
            Parking space is available for your convenience.
            @endif
            
            @if(!empty($features['otherText']))
            Additional features include: {{ $features['otherText'] }}.
            @endif
        </p>
    </div>

    <!-- Detailed features section -->
    <div class="mb-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-3">Room features</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span class="text-black">Capacity: {{ $features['pax'] }} person{{ $features['pax'] > 1 ? 's' : '' }}</span>
            </div>
            
            @if($features['livingRoom'])
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-black">Living Room</span>
            </div>
            @endif
            
            @if($features['kitchen'])
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3V3zm8 5v10m4-10v10m-4-5h4"></path>
                </svg>
                <span class="text-black">Kitchen</span>
            </div>
            @endif
            
            @if($features['cr'])
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4m14-4v4M5 8h14M5 12h14m-7 4h2a2 2 0 012 2v2H9v-2a2 2 0 012-2z"></path>
                </svg>
                <span class="text-black">Private Comfort Room</span>
            </div>
            @endif
            
            @if($features['balcony'])
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                </svg>
                <span class="text-black">Balcony</span>
            </div>
            @endif
            
            @if($features['aircon'])
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
                <span class="text-black">Air Conditioning</span>
            </div>
            @endif
            
            @if($features['bed'])
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m14 0a2 2 0 00-2-2H8a2 2 0 00-2 2m14 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7"></path>
                </svg>
                <span class="text-black">Bed Included</span>
            </div>
            @endif
            
            @if($features['parking'])
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                </svg>
                <span class="text-black">Parking Space</span>
            </div>
            @endif
            
            @if(!empty($features['otherText']))
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-black">{{ $features['otherText'] }}</span>
            </div>
            @endif
        </div>
    </div>

    <!-- Additional information section -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h3 class="text-xl font-semibold text-gray-800 mb-3">Good to know</h3>
        <ul class="space-y-2">
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-black">Monthly rental contract</span>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-black">24/7 security</span>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-black">Water and electricity included</span>
            </li>
        </ul>
    </div>
</div>

    <!-- Right side: Livewire component (sticky) -->
    <div class="w-full sm:w-1/3 border border-gray-300 shadow-md bg-white p-4 sticky top-20 self-start">
        <div class="grid grid-cols-1">
            @livewire('view-detail', ['categoryId' => $apartment->categ_id,
                                    'available' => $available,          
                                    'room_available' => $room_available])
        </div>
    </div>
</div>

<!-- Full-screen Modal -->
<div id="image-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <img id="modal-image" class="max-w-full max-h-full">
    <span id="close-modal" class="absolute top-2 right-4 text-white text-2xl cursor-pointer">&times;</span>
</div>

<script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>

