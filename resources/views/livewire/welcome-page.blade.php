<div id="overview">
    <div class="bg-gray-100 text-white min-h-screen">
       <!-- Hero Section -->
    <div class="relative w-screen h-[calc(100vh-4rem)] flex items-center justify-center text-white bg-cover bg-center"
    style="background-image: url('images/NRNBUILDING3.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">

    <!-- Darker Gradient Overlay -->
    <div class="absolute inset-0 bg-black/60"></div> <!-- Increased darkness to 60% opacity -->

    <div class="relative text-center px-6 md:px-12">
        <h1 class="text-4xl md:text-6xl font-bold">Your Home, <br>Your Comfort,<br> Your NRN Apartment</h1>
        <p class="mt-4 text-lg md:text-xl opacity-80 max-w-lg mx-auto">
            Experience modern living with comfort and convenience.   </p>
        <a href="#about-us">
            <button class="mt-6 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg">
                Learn More
            </button>
        </a>
    </div>
    </div>
        <div id="about-us"></div>
        <!-- Designed for Comfort Section -->        
        <div class="bg-gray-100 text-black px-4 md:px-16 py-8 md:py-16"data-aos="fade-up">
            <!-- Summary Section -->
            <div class="text-center max-w-3xl mx-auto mb-10">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Discover Comfortable Living</h2>
                @isset($settings->discover_description)
                <p class="text-lg text-gray-600 mt-2">
                    {{ $settings->discover_description }}
                </p>
                @else
                <p class="text-lg text-gray-600 mt-2">
                    Experience a peaceful and convenient lifestyle at NRN Building in Mission Hills, Roxas City. 
                    Our well-designed rooms, secure parking, and modern amenities offer the perfect place to call home. 
                    Whether you're here for a short stay or a long-term residence, we prioritize your comfort.
                </p>
                @endisset
            </div>
            <div class="min-w-full grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                <!-- Left Image -->
                <div class="md:col-span-1 flex justify-center md:justify-start md:-mt-16">
                    <img src="images/NRNBUILDING.png" alt="Building" class="rounded-lg w-full md:w-3/4 h-48 md:h-64 object-cover shadow-lg">
                </div>
    
                <!-- Center Text -->
                <div class="md:col-span-1 text-center">
                    <h2 class="text-2xl md:text-3xl font-bold mb-4">Designed for <span class="text-[#89CFF0]">Comfort</span>, built for <span class="text-[#89CFF0]">You</span>.</h2>
                    @isset($settings->designed_description)
                    <p class="text-base md:text-lg leading-relaxed">
                        {{ $settings->designed_description }}
                    </p>
                    @else
                    <p class="text-base md:text-lg leading-relaxed">
                        NRN Building in Mission Hills, Roxas City features 30 elegant rooms, dedicated parking, and free air conditioning for your comfort.
                    </p>
                    @endisset
                </div>
    
                <!-- Right Image -->
                <div class="md:col-span-1 flex justify-center md:justify-end md:mt-16">
                    <img src="images/LIVING.jpg" alt="Living Room Area" class="rounded-lg w-full md:w-3/4 h-48 md:h-64 object-cover shadow-lg">
                </div>
            </div>
        </div>
        <div id="nearby" ></div>
        <!-- Nearby Establishments Section -->
        <div class="text-black flex flex-col items-center justify-center p-4 md:p-5 text-center px-4 md:px-16 py-8 md:py-16my-2"data-aos="fade-up">
            <h3 class="font-heavy text-xl md:text-2xl mb-1 text-black">Nearby Establishments</h3>
            <hr class="w-1/2 border-t-2 border-gray-300 mb-4">
            @isset($settings->neary_description)
            <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-2xl pb-8">{{ $settings->neary_description }}</p>
            @else
            <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-2xl pb-8">Explore key locations surrounding the NRN Building, offering essential services, entertainment, and convenience—all within close proximity.</p>
            @endisset
            <div class="min-w-full carousel-container overflow-hidden relative w-full max-w-6xl mx-auto">
                <div class="carousel-wrapper flex transition-transform duration-500 ease-in-out" id="carousel">
                    @foreach($nearby as $establishment)
                        <div class="carousel-item w-full md:w-1/3 flex-shrink-0 px-2 md:px-4">
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 hover:bg-slate-200 flex flex-col h-full">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('storage/' . $establishment->image_url) }}" alt="{{ $establishment->name }}" class="w-full h-40 md:h-52 object-cover">
                                </div>
                                <div class="p-4 flex-grow flex flex-col justify-between">
                                    <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-2">{{ $establishment->name }}</h3>
                                    <p class="text-sm md:text-base text-gray-600 flex-grow">Located just {{$establishment->distance}} kilometers from the NRN Building, {{ $establishment->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Carousel Navigation Buttons -->
                <button class="carousel-prev absolute top-1/2 left-0 transform -translate-y-1/2 bg-gray-800 text-white rounded-full shadow-lg p-2 hover:bg-gray-700" onclick="prevSlide()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 19-7-7 7-7" />
                    </svg>
                </button>
                <button class="carousel-next absolute top-1/2 right-0 transform -translate-y-1/2 bg-gray-800 text-white rounded-full shadow-lg p-2 hover:bg-gray-700" onclick="nextSlide()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 5 7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
            <!-- Apartments Section -->
            <div id="rooms" ></div>
            <div class="bg-gray-100 py-8"data-aos="fade-up">
                <div  class="text-black flex flex-col items-center justify-center p-4 md:p-5 text-center my-2">
                    <h3 class="font-heavy text-xl md:text-2xl mb-1 text-black">Apartments We Recommend for You</h3>
                    <hr class="w-1/2 border-t-2 border-gray-300 mb-4">
                    @isset($settings->apartment_description)
                    <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-2xl pb-8">
                        {{ $settings->apartment_description }}
                    </p>
                    @else
                    <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-2xl pb-8">Browse our carefully selected apartment listings, designed to provide comfort, affordability, and an ideal living experience near the NRN Building.</p>
                    @endisset
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 min-w-full px-4 md:px-16">
                        @foreach ($categories as $category)
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 hover:bg-slate-200">
                                <div id="default-carousel-{{$category->category_id}}" class="relative group" data-carousel="static">
                                    <!-- Carousel wrapper -->
                                    <div class="overflow-hidden relative h-56 sm:h-64 xl:h-80 2xl:h-96 shadow-md">
                                        @foreach ($images[$category->category_id] as $image)
                                        <div class="hidden duration-200 ease-in-out" data-carousel-item>
                                            <img src="{{ asset($image->image) }}" style="width:100%;height:100%;" class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2 clickable-image" alt="...">
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- Slider indicators -->
                                    <div class="flex absolute bottom-5 left-1/2 transform -translate-x-1/2 space-x-3 z-30">
                                        @for ($i = 0; $i < $images[$category->category_id]->count(); $i++)
                                            <button type="button" class="w-2 h-2 rounded-full bg-white" aria-current="false" aria-label="Slide {{$i+1}}" data-carousel-slide-to="{{$i}}"></button>
                                        @endfor
                                    </div>
                                    <!-- Slider controls -->
                                    <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group-hover:opacity-100 opacity-0 transition-opacity" data-carousel-prev>
                                        <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-yellow-100/30 group-hover:bg-yellow-100/50 group-focus:ring-4 group-focus:ring-white">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white group-hover:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group-hover:opacity-100 opacity-0 transition-opacity" data-carousel-next>
                                        <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-yellow-100/30 group-hover:bg-yellow-100/50 group-focus:ring-4 group-focus:ring-white">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white group-hover:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                                <!-- Description -->
                                <div class="p-2 sm:p-6">
                                    <h3 class="text-left text-xl sm:text-2xl font-semibold mb-2 text-gray-700">{{ $category->category_name }}</h3>
                                    
                                    <div class="flex items-center mb-2">
                                        <h6 class="text-lg sm:text-xl font-semibold text-gray-700 mr-2">Price:</h6>
                                        <p class="text-md sm:text-lg text-gray-800">₱{{ number_format($category->price, 2) }}/month</p>
                                    </div>
                                    
                                    <div class="flex items-center mb-2">
                                        <h6 class="text-lg sm:text-xl font-semibold text-gray-700 mr-2">Capacity:</h6>
                                        <p class="text-md sm:text-lg text-gray-800">{{ $category->description['pax'] }} people</p>
                                    </div>
                                    
                                    <!-- Show only 3 key amenities initially -->
                                    <div class="mb-3">
                                        <h6 class="text-sm font-semibold text-gray-600 mb-1">Key Features:</h6>
                                        <div class="flex flex-wrap gap-2">
                                            @php
                                                $shownFeatures = 0;
                                                $featuresToShow = 3;
                                                $features = [
                                                    ['condition' => $category->description['aircon'], 'label' => 'Aircon'],
                                                    ['condition' => $category->description['cr'], 'label' => 'Private CR'],
                                                    ['condition' => $category->description['kitchen'], 'label' => 'Kitchen'],
                                                    ['condition' => $category->description['livingRoom'], 'label' => 'Living Room'],
                                                    ['condition' => $category->description['balcony'], 'label' => 'Balcony'],
                                                    ['condition' => $category->description['bed'], 'label' => 'Bed Included'],
                                                    ['condition' => $category->description['parking'], 'label' => 'Parking']
                                                ];
                                            @endphp

                                            @foreach($features as $feature)
                                                @if($feature['condition'] && $shownFeatures < $featuresToShow)
                                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full flex items-center">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        {{ $feature['label'] }}
                                                    </span>
                                                    @php $shownFeatures++; @endphp
                                                @endif
                                            @endforeach

                                            @if(array_sum(array_column($features, 'condition')) > $featuresToShow)
                                                <span class="text-xs text-blue-600 px-2 py-1">+{{ array_sum(array_column($features, 'condition')) - $featuresToShow }} more...</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button wire:click="viewDetails({{ $category->category_id }})" 
                                                class="inline-block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition duration-300 text-sm">
                                            View All Features & Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <script>
                let currentIndex = 0;
                const carousel = document.getElementById('carousel');
                const items = document.querySelectorAll('.carousel-item');
                const totalItems = items.length;
            
                function updateCarousel() {
                    const offset = -currentIndex * 100;
                    carousel.style.transform = `translateX(${offset}%)`;
                }
            
                function nextSlide() {
                    if (currentIndex < totalItems - 1) {
                        currentIndex++;
                    } else {
                        currentIndex = 0; // Loop back to the first item
                    }
                    updateCarousel();
                }
            
                function prevSlide() {
                    if (currentIndex > 0) {
                        currentIndex--;
                    } else {
                        currentIndex = totalItems - 1; // Loop back to the last item
                    }
                    updateCarousel();
                }
            </script>
    
        <!-- Location Section -->
        <div id="location" class="text-black flex flex-col items-center justify-center p-4 md:p-5 text-center my-2 shadow-lg"data-aos="fade-up">
            <h3 class="font-heavy text-xl md:text-2xl mb-1 text-black">NRN Building Location</h3>
            <hr class="w-1/3 border-t-2 border-gray-300 mb-4">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3908.8019578203007!2d122.76057597408091!3d11.56605044413493!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a5f3009ecc8dab%3A0x145584f32319a34c!2sMission%20Hills%20Ave%2C%20Roxas%20City%2C%20Capiz!5e0!3m2!1sen!2sph!4v1728137691267!5m2!1sen!2sph" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    <!-- Footer Section -->
    <footer class="bg-gray-100 text-black py-10 shadow-lg">
        <div class="max-w-6xl mx-auto px-6 text-center">
            @isset($owner)
                <h2 class="text-2xl md:text-3xl font-bold mb-4">CONTACT US</h2>
                <div class="flex flex-col md:flex-row justify-center items-center gap-4 text-lg">
                    <p class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21 8V7a5 5 0 0 0-5-5H8a5 5 0 0 0-5 5v1a5 5 0 0 0 5 5h8a5 5 0 0 0 5-5Z"></path>
                        </svg>
                        Owner: {{ $owner->name }}
                    </p>
                    <p class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5Zm12 6-4-3v6l4-3Z"></path>
                        </svg>
                        <a href="mailto:{{ $owner->email }}" class="hover:text-blue-400">{{ $owner->email }}</a>
                    </p>
                    <p class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6.6 10.8a15.9 15.9 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1.1-.3c.9.3 1.9.5 2.9.5a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1 20 20 0 0 1-20-20 1 1 0 0 1 1-1h3a1 1 0 0 1 1 1c0 1 0 2 .5 2.9a1 1 0 0 1-.3 1.1l-2.2 2.2Z"></path>
                        </svg>
                        <a href="tel:{{ $owner->phone_number }}" class="hover:text-blue-400">{{ $owner->phone_number }}</a>
                    </p>
                </div>
            @else
                <p class="text-gray-400">No owner information available.</p>
            @endisset
            <div class="border-t border-gray-700 my-6"></div>
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} NRN Building. All rights reserved.</p>
        </div>
    </footer>

    </div>
</div>