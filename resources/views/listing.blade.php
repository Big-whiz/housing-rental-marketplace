<x-layout>
    <div class="bg-gray-100 py-6 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900">Find Rentals in Accra</h1>
            <p class="text-sm text-gray-500">Filter properties by budget, location, and property type.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Filters -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm h-fit">
                <h2 class="font-bold text-gray-900 text-lg mb-4">Filter Listings</h2>
                
                <form action="/listings" method="GET" class="space-y-6">
                    <!-- Text Search -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Search Keyword</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="e.g. East Legon, studio..." class="w-full text-sm border border-gray-300 rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>

                    <!-- Property Type -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Property Type</label>
                        <select name="property_type" class="w-full text-sm border border-gray-300 rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-white">
                            <option value="">All Types</option>
                            <option value="Apartment" {{ request('property_type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                            <option value="House" {{ request('property_type') == 'House' ? 'selected' : '' }}>House</option>
                            <option value="Studio" {{ request('property_type') == 'Studio' ? 'selected' : '' }}>Studio</option>
                        </select>
                    </div>

                    <!-- Bedrooms -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Bedrooms</label>
                        <select name="bedrooms" class="w-full text-sm border border-gray-300 rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-white">
                            <option value="">Any Bedrooms</option>
                            <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1 Bedroom</option>
                            <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2 Bedrooms</option>
                            <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3+ Bedrooms</option>
                        </select>
                    </div>

                    <!-- Budget Range -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Monthly Budget (GHS)</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full text-sm border border-gray-300 rounded-lg p-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full text-sm border border-gray-300 rounded-lg p-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="space-y-2 pt-2">
                        <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition">
                            Apply Filters
                        </button>
                        <a href="/listings" class="block w-full py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-center font-medium rounded-lg text-sm transition">
                            Clear All
                        </a>
                    </div>
                </form>
            </div>

            <!-- Listings Results List -->
            <div class="lg:col-span-3 space-y-6">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500 font-medium">
                        Showing {{ $listings->count() }} {{ Str::plural('property', $listings->count()) }} found
                    </p>
                </div>

                @if($listings->isEmpty())
                    <!-- Empty State -->
                    <div class="bg-white text-center py-16 px-4 rounded-xl border border-gray-200 shadow-sm">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="font-bold text-gray-950 text-lg">No listings match your search</h3>
                        <p class="text-sm text-gray-500 mt-1">Try clearing your filters or widening your budget range.</p>
                    </div>
                @else
                    <!-- Listing Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($listings as $listing)
                            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md border border-gray-200 transition duration-150 flex flex-col justify-between">
                                <div>
                                    <!-- Property Photo -->
                                    <div class="relative h-48 bg-gray-200">
                                        @if(!empty($listing->photos) && is_array($listing->photos))
                                            <img src="{{ $listing->photos[0] }}" alt="{{ $listing->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                                                No photo available
                                            </div>
                                        @endif

                                        @if($listing->is_verified)
                                            <!-- Verified Badge -->
                                            <span class="absolute top-3 left-3 px-2.5 py-1 bg-green-600 text-white text-xs font-semibold rounded-full shadow-sm flex items-center gap-1">
                                                Verified
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Details -->
                                    <div class="p-5">
                                        <div class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                                            <span>{{ $listing->property_type }}</span>
                                            <span>&bull;</span>
                                            <span>{{ $listing->bedrooms }} {{ Str::plural('Bed', $listing->bedrooms) }}</span>
                                        </div>
                                        <h3 class="font-bold text-gray-900 text-lg mb-1 hover:text-blue-600 transition">
                                            <a href="/listings/{{ $listing->id }}">{{ $listing->title }}</a>
                                        </h3>
                                        <p class="text-sm text-gray-500 line-clamp-1 mb-2">
                                            <span class="font-medium text-gray-600">Location:</span> {{ $listing->location }}
                                        </p>
                                        <p class="text-sm text-gray-500 line-clamp-2">
                                            {{ $listing->description }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Footer/Action -->
                                <div class="px-5 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-lg font-bold text-blue-600">GHS {{ number_format($listing->price) }}</span>
                                        <span class="text-xs text-gray-400">/ mo</span>
                                    </div>
                                    <a href="/listings/{{ $listing->id }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg transition">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>