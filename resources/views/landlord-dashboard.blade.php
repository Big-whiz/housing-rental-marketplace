<x-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Dashboard Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b pb-6 mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">Landlord Portal</h1>
                <p class="text-gray-500 text-sm mt-1">Manage listings, view tenant inquiries, and monitor transactions.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="/landlords" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold text-sm shadow-sm transition">
                    + Add New Listing
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Side: Manage Listings (2 Columns) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Listings Card -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-150 bg-gray-50">
                        <h2 class="font-bold text-gray-900 text-lg">My Listings</h2>
                    </div>

                    @if($listings->isEmpty())
                        <div class="p-8 text-center text-gray-500 text-sm">
                            You have no active listings. Click "+ Add New Listing" to create one.
                        </div>
                    @else
                        <div class="divide-y divide-gray-150">
                            @foreach($listings as $listing)
                                <div class="p-6 flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        <!-- Thumbnail -->
                                        <div class="h-16 w-16 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 flex-shrink-0">
                                            @if(!empty($listing->photos) && is_array($listing->photos))
                                                <img src="{{ $listing->photos[0] }}" alt="" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-gray-300 text-xs">No image</div>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900 text-sm hover:text-blue-600 transition">
                                                <a href="/listings/{{ $listing->id }}">{{ $listing->title }}</a>
                                            </h3>
                                            <p class="text-xs text-gray-500 mt-0.5">
                                                {{ $listing->location }} &bull; GHS {{ number_format($listing->price) }}/mo
                                            </p>
                                            <span class="inline-block mt-2 text-[10px] px-2 py-0.5 rounded-full font-semibold {{ $listing->is_verified ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                                {{ $listing->is_verified ? 'Verified' : 'Pending Admin Approval' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <!-- Delete Button Form -->
                                        <form action="{{ route('listings.delete', $listing->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this property listing?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-semibold transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Incoming Inquiries -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-150 bg-gray-50">
                        <h2 class="font-bold text-gray-900 text-lg">Tenant Inquiries</h2>
                    </div>

                    @if($messages->isEmpty())
                        <div class="p-8 text-center text-gray-500 text-sm">
                            No tenant inquiries received yet.
                        </div>
                    @else
                        <div class="divide-y divide-gray-150">
                            @foreach($messages as $msg)
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <span class="font-bold text-gray-900 text-sm">{{ $msg->sender->name ?? 'Anonymous Tenant' }}</span>
                                            <span class="text-xs text-gray-400">({{ $msg->sender->email ?? 'N/A' }})</span>
                                        </div>
                                        <span class="text-[10px] text-gray-400">{{ $msg->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mb-2">
                                        Regarding Listing: 
                                        <a href="/listings/{{ $msg->listing->id ?? '#' }}" class="font-semibold text-blue-600 hover:underline">
                                            {{ $msg->listing->title ?? 'Deleted Listing' }}
                                        </a>
                                    </p>
                                    <div class="bg-gray-50 p-3 rounded-lg text-xs text-gray-700 italic border border-gray-100">
                                        "{{ $msg->message }}"
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Side: Transactions History (1 Column) -->
            <div>
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-150 bg-gray-50">
                        <h2 class="font-bold text-gray-900 text-lg">Payments Tracking</h2>
                    </div>

                    @if($payments->isEmpty())
                        <div class="p-8 text-center text-gray-500 text-sm">
                            No payment transactions recorded.
                        </div>
                    @else
                        <div class="divide-y divide-gray-150">
                            @foreach($payments as $payment)
                                <div class="p-5 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-gray-950 text-sm">GHS {{ number_format($payment->amount) }}</span>
                                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full {{ $payment->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ $payment->status }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        <p><span class="font-semibold text-gray-700">From:</span> {{ $payment->user->name ?? 'Tenant' }}</p>
                                        <p class="truncate"><span class="font-semibold text-gray-700">Ref:</span> {{ $payment->transaction_reference ?? 'N/A' }}</p>
                                        <p class="truncate"><span class="font-semibold text-gray-700">For:</span> {{ $payment->listing->title ?? 'Property' }}</p>
                                        <span class="block text-[10px] text-gray-400 mt-1">{{ $payment->created_at->format('M d, Y H:i') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>
