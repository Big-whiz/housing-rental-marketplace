<x-layout>
    <!-- Hero Banner with Search Filters -->
    <section class="bg-gradient-to-r from-blue-700 to-indigo-800 text-white py-20 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold tracking-tight mb-4">
                Find Your Next Home in Accra
            </h1>
            <p class="text-lg md:text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Affordable, verified apartments, rooms, and houses for rent in Ghana's capital.
            </p>

            <!-- Search Form -->
            <form action="/listings" method="GET" class="bg-white p-4 rounded-xl shadow-lg text-gray-800 max-w-3xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-3 items-center">
                <!-- Location Search -->
                <div class="text-left">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Location</label>
                    <input type="text" name="search" placeholder="e.g. East Legon, Osu..." class="w-full text-sm font-medium border-0 focus:ring-0 focus:outline-none p-1 placeholder-gray-400">
                </div>

                <!-- Property Type Filter -->
                <div class="text-left border-t md:border-t-0 md:border-l border-gray-100 md:pl-3">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Type</label>
                    <select name="property_type" class="w-full text-sm font-medium border-0 bg-transparent focus:ring-0 focus:outline-none p-1">
                        <option value="">All Types</option>
                        <option value="Apartment">Apartment</option>
                        <option value="House">House</option>
                        <option value="Studio">Studio</option>
                    </select>
                </div>

                <!-- Bedrooms Filter -->
                <div class="text-left border-t md:border-t-0 md:border-l border-gray-100 md:pl-3">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Bedrooms</label>
                    <select name="bedrooms" class="w-full text-sm font-medium border-0 bg-transparent focus:ring-0 focus:outline-none p-1">
                        <option value="">Any</option>
                        <option value="1">1 Bedroom</option>
                        <option value="2">2 Bedrooms</option>
                        <option value="3">3+ Bedrooms</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="pt-2 md:pt-0">
                    <button type="submit" class="w-full py-3 px-6 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Featured Listings Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Featured Listings</h2>
                <p class="text-gray-500 text-sm mt-1">Hand-picked verified rental properties in Accra</p>
            </div>
            <a href="/listings" class="text-blue-600 hover:text-blue-700 font-medium text-sm transition">
                View All Listings &rarr;
            </a>
        </div>

        @if($featuredListings->isEmpty())
            <!-- Fallback if database has not been seeded yet -->
            <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-gray-100">
                <p class="text-gray-500 mb-4">No verified listings available right now.</p>
                <div class="text-xs text-gray-400 max-w-md mx-auto">
                    <p class="font-semibold text-gray-500 mb-1">Developer Tip:</p>
                    <p>Run <code class="bg-gray-100 px-1 py-0.5 rounded">php artisan migrate:fresh --seed</code> in your terminal to populate beautiful sample listings!</p>
                </div>
            </div>
        @else
            <!-- Display Seeded/Database Listings -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featuredListings as $listing)
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md border border-gray-100 transition duration-200 flex flex-col">
                        <!-- Photo Slider / Image Placeholder -->
                        <div class="relative h-48 bg-gray-200">
                            @if(!empty($listing->photos) && is_array($listing->photos))
                                <img src="{{ $listing->photos[0] }}" alt="{{ $listing->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                                    No photo available
                                </div>
                            @endif

                            @if($listing->is_verified)
                                <!-- Verified Property Badge -->
                                <span class="absolute top-3 left-3 px-2.5 py-1 bg-green-600 text-white text-xs font-semibold rounded-full shadow-sm flex items-center gap-1">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293l-4-4a1 1 0 10-1.414 1.414L11.586 9H6a1 1 0 100 2h5.586l-3.293 3.293a1 1 0 101.414 1.414l4-4a1 1 0 000-1.414z"></path></svg>
                                    Verified
                                </span>
                            @endif
                        </div>

                        <!-- Card Body Details -->
                        <div class="p-5 flex-grow flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                                    <span>{{ $listing->property_type }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $listing->bedrooms }} {{ Str::plural('Bed', $listing->bedrooms) }}</span>
                                </div>
                                <h3 class="font-bold text-gray-900 text-lg line-clamp-1 mb-2">
                                    {{ $listing->title }}
                                </h3>
                                <p class="text-sm text-gray-500 line-clamp-2 mb-4">
                                    {{ $listing->description }}
                                </p>
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-50 mt-auto">
                                <div>
                                    <span class="text-xl font-extrabold text-blue-600">GHS {{ number_format($listing->price) }}</span>
                                    <span class="text-xs text-gray-400">/ month</span>
                                </div>
                                <a href="/listings/{{ $listing->id }}" class="px-3.5 py-1.5 bg-gray-100 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-semibold text-xs rounded-lg transition">
                                    Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="bg-gray-100 py-16 border-t border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900">How It Works</h2>
                <p class="text-gray-600 mt-2 text-sm">Connecting tenants with verified hosts in three simple steps.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
                    <div class="h-12 w-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg mx-auto mb-4">1</div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">Browse & Filter</h3>
                    <p class="text-gray-500 text-sm">Search through properties across Accra and narrow them down by location, price, and rooms.</p>
                </div>
                
                <!-- Step 2 -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
                    <div class="h-12 w-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg mx-auto mb-4">2</div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">Verify Listings</h3>
                    <p class="text-gray-500 text-sm">Look for the "Verified" badge indicating that our team has physically checked and authenticated the listing.</p>
                </div>
                
                <!-- Step 3 -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
                    <div class="h-12 w-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg mx-auto mb-4">3</div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">Contact directly</h3>
                    <p class="text-gray-500 text-sm">Chat in-app or directly launch WhatsApp to establish communication and schedule a physical viewing.</p>
                </div>
            </div>
        </div>
    </section>
</x-layout>
