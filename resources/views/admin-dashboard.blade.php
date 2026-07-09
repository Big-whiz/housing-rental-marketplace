<x-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Dashboard Header -->
        <div class="border-b pb-6 mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Admin Approval Queue</h1>
            <p class="text-gray-500 text-sm mt-1">Review, verify, and approve property listings submitted by landlords.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Admin Table Card -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-150 bg-gray-50 flex items-center justify-between">
                <h2 class="font-bold text-gray-900 text-lg">Property Approval Queue</h2>
                <span class="text-xs px-2.5 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold">{{ $listings->count() }} Total Listings</span>
            </div>

            @if($listings->isEmpty())
                <div class="p-8 text-center text-gray-500 text-sm">
                    No properties in the system.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b border-gray-150">
                            <tr>
                                <th scope="col" class="px-6 py-3.5">Property Detail</th>
                                <th scope="col" class="px-6 py-3.5">Landlord</th>
                                <th scope="col" class="px-6 py-3.5">Price</th>
                                <th scope="col" class="px-6 py-3.5">Type</th>
                                <th scope="col" class="px-6 py-3.5">Status</th>
                                <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-150">
                            @foreach($listings as $listing)
                                <tr class="bg-white hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 bg-gray-100 rounded overflow-hidden flex-shrink-0 border border-gray-200">
                                                @if(!empty($listing->photos) && is_array($listing->photos))
                                                    <img src="{{ $listing->photos[0] }}" alt="" class="h-full w-full object-cover">
                                                @else
                                                    <div class="h-full w-full flex items-center justify-center text-gray-300 text-[10px]">No image</div>
                                                @endif
                                            </div>
                                            <div>
                                                <a href="/listings/{{ $listing->id }}" class="hover:text-blue-600 transition">{{ $listing->title }}</a>
                                                <span class="block text-xs font-normal text-gray-400 mt-0.5">{{ $listing->location }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-xs font-medium">
                                        <p class="text-gray-800">{{ $listing->user->name ?? 'Deleted Landlord' }}</p>
                                        <p class="text-gray-400 mt-0.5">{{ $listing->user->phone ?? 'No phone' }}</p>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        GHS {{ number_format($listing->price) }}
                                    </td>
                                    <td class="px-6 py-4 text-xs font-semibold text-gray-600">
                                        {{ $listing->property_type }} ({{ $listing->bedrooms }} Beds)
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block text-[10px] px-2 py-0.5 rounded-full font-bold {{ $listing->is_verified ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ $listing->is_verified ? 'Verified' : 'Pending Review' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if(!$listing->is_verified)
                                            <!-- Approve Form -->
                                            <form action="{{ route('admin.approve', $listing->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-3.5 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-bold shadow-sm transition">
                                                    Verify & Approve
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Approved</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-layout>
