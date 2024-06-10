
    <div class="bg-gray-900 text-white min-h-screen">
        <!-- Overview section -->
        <div class="carousel">
            <div class="carousel-slide active" style="background-image: url('images/NRNBUILDING.png');">
                <div class="overlay"></div>
                <div class="content">
                    <h1>Welcome to Jasmine Ridge Loft</h1>
                    <p>Experience luxury and indulgence at our exquisite hotel in the heart of the Philippines. Immerse yourself in opulence and enjoy world-class amenities and services tailored to your every need, from the moment you step through our doors.</p>
                </div>
            </div>
            <div class="carousel-slide" style="background-image: url('images/test.jpg');">
                <div class="overlay"></div>
                <div class="content">
                    <h1>Discover Tranquility</h1>
                    <p>Find peace and relaxation in our serene environment, designed to rejuvenate your senses and offer a sanctuary away from the hustle and bustle of daily life.</p>
                </div>
            </div>
            <div class="carousel-slide" style="width:100;background-image: url('images/test3.jpg');">
                <div class="overlay"></div>
                <div class="content">
                    <h1>Unparalleled Comfort</h1>
                    <p>Enjoy our plush accommodations and premium services that ensure a stay of absolute comfort and luxury, making every moment unforgettable.</p>
                </div>
            </div>
            <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
            <button class="next" onclick="changeSlide(1)">&#10095;</button>
        </div>
        
        <!-- Apartments Section -->
        <div class="container mx-auto py-16 px-4">
            @foreach($apartment as $apartments)
            <div class="flex flex-col lg:flex-row items-center justify-center space-y-4 lg:space-y-0 lg:space-x-8 bg-white text-gray-800 shadow-md rounded-lg p-4 mb-8">
                <div class="max-w-2xl w-full">
                    <div id="default-carousel" class="relative" data-carousel="static">
                        <!-- Carousel wrapper -->
                        <div class="overflow-hidden relative h-56 rounded-lg sm:h-64 xl:h-80 2xl:h-96">
                            @foreach ($images[$apartments->id] as $image)
                            <div class="hidden duration-200 ease-in-out" data-carousel-item>
                                <img src="{{ asset($image->image) }}" style="width:350px;height:250px;" class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2" alt="...">
                            </div>
                            @endforeach
                        </div>
                        <!-- Slider indicators -->
                        <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
                            @for ($i = 0;$i < $images[$apartments->id]->count(); $i++)
                            <button type="button" value="{{$i}}" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                            @endfor
                        </div>
                        <!-- Slider controls -->
                        <button type="button" class="flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none" data-carousel-prev>
                            <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 bg-gray-800/30 group-hover:bg-white/50 group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white group-focus:ring-gray-800/70 group-focus:outline-none">
                                <svg class="w-6 h-6 opacity-30 text-white sm:w-6 sm:h-6 text-gray-800" fill="none" stroke="blue" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M15 19l-7-7 7-7"></path></svg>
                                <span class="hidden">Previous</span>
                            </span>
                        </button>
                        <button type="button" class="flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none" data-carousel-next>
                            <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 bg-gray-800/30 group-hover:bg-white/50 group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white group-focus:ring-gray-800/70 group-focus:outline-none">
                                <svg class="w-6 h-6 opacity-30 text-white sm:w-6 sm:h-6 text-gray-800" fill="none" stroke="blue" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M9 5l7 7-7 7"></path></svg>
                                <span class="hidden">Next</span>
                            </span>
                        </button>
                    </div>
                </div>
                <!-- Description -->
                <div class="w-full lg:w-1/2">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">{{$apartments->categ_name}}</h2>
                    <span class="text-gray-700 font-medium">Description</span>
                    <p class="text-gray-700 mb-4">{{$apartments->description}}</p>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700 font-medium">Rating:</span>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 1l1.82 5.59h5.81L12.93 9.5l1.56 5.41H11.82L10 16.03 8.18 14.91H4.56l1.56-5.41L2.37 6.59h5.81L10 1z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">4.5</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700 font-medium">Price:</span>
                        <span class="text-gray-700">{{$apartments->price}}</span>
                    </div>
                    <a href="{{route('visitors.display',['apartment'=>$apartments->id])}}">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mt-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            View Details
                        </button>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

