<x-layout>
    <div class="bg-gray-100 py-6 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900">My Favorites</h1>
            <p class="text-sm text-gray-500">View all properties you have saved.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($listings->isEmpty())
            <div class="bg-white text-center py-16 px-4 rounded-xl border border-gray-200 shadow-sm max-w-lg mx-auto">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <h3 class="font-bold text-gray-950 text-lg">No favorite listings yet</h3>
                <p class="text-sm text-gray-500 mt-1 mb-4">Start exploring listings in Accra and click the heart icon to save them here.</p>
                <a href="/listings" class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-lg transition">
                    Explore Rooms
                </a>
            </div>
        @else
            <!-- Listings Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                                    <span class="absolute top-3 left-3 px-2.5 py-1 bg-green-600 text-white text-xs font-semibold rounded-full shadow-sm">
                                        Verified
                                    </span>
                                @endif

                                <!-- Favorite Remove Heart Button -->
                                <form action="{{ route('listings.favorite', $listing->id) }}" method="POST" class="absolute top-3 right-3">
                                    @csrf
                                    <button type="submit" class="p-2 bg-white hover:bg-red-50 text-red-500 rounded-full transition shadow-sm" title="Remove Favorite">
                                        <svg class="h-4 w-4 fill-current text-red-600" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                    </button>
                                </form>
                            </div>

                            <!-- Details -->
                            <div class="p-5">
                                <div class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                                    <span>{{ $listing->property_type }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $listing->bedrooms }} {{ Str::plural('Bed', $listing->bedrooms) }}</span>
                                </div>
                                <h3 class="font-bold text-gray-900 text-base mb-1 hover:text-blue-600 transition truncate">
                                    <a href="/listings/{{ $listing->id }}">{{ $listing->title }}</a>
                                </h3>
                                <p class="text-xs text-gray-500 truncate">
                                    <span class="font-medium text-gray-600">Location:</span> {{ $listing->location }}
                                </p>
                            </div>
                        </div>

                        <!-- Footer/Action -->
                        <div class="px-5 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-base font-bold text-blue-600">GHS {{ number_format($listing->price) }}</span>
                                <span class="text-[10px] text-gray-400">/ mo</span>
                            </div>
                            <a href="/listings/{{ $listing->id }}" class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-lg transition">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layout>
