<x-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Dashboard Header -->
        <div class="border-b pb-6 mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Tenant Dashboard</h1>
            <p class="text-gray-500 text-sm mt-1">Manage your saved listings, view chat inquiries, and track payment transactions.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Columns: Favorites and Message Threads -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Favorites Section -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-150 bg-gray-50">
                        <h2 class="font-bold text-gray-900 text-lg">My Favorites</h2>
                    </div>

                    @if($favorites->isEmpty())
                        <div class="p-8 text-center text-gray-500 text-sm">
                            You haven't favorited any listings yet. <a href="/listings" class="text-blue-600 font-bold hover:underline">Explore rooms</a>
                        </div>
                    @else
                        <div class="divide-y divide-gray-150">
                            @foreach($favorites as $listing)
                                <div class="p-6 flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-4">
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
                                            <p class="text-xs text-gray-500 mt-0.5">{{ $listing->location }} &bull; GHS {{ number_format($listing->price) }}/mo</p>
                                        </div>
                                    </div>
                                    <div>
                                        <form action="{{ route('listings.favorite', $listing->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-gray-100 hover:bg-red-50 text-gray-700 hover:text-red-600 rounded-lg text-xs font-semibold transition border border-gray-200">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Chat Messages / Inquiries -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-150 bg-gray-50">
                        <h2 class="font-bold text-gray-900 text-lg">My Inquiries & Chats</h2>
                    </div>

                    @if($messages->isEmpty())
                        <div class="p-8 text-center text-gray-500 text-sm">
                            You have no active message threads.
                        </div>
                    @else
                        <div class="divide-y divide-gray-150">
                            @foreach($messages as $listingId => $thread)
                                @php
                                    $listing = $thread->first()->listing;
                                @endphp
                                <div class="p-6 space-y-4">
                                    <div class="flex items-center justify-between border-b pb-2">
                                        <h3 class="font-bold text-gray-900 text-sm">
                                            Regarding: <a href="/listings/{{ $listing->id ?? '#' }}" class="text-blue-600 hover:underline">{{ $listing->title ?? 'Deleted Listing' }}</a>
                                        </h3>
                                        <span class="text-[10px] text-gray-400">Landlord: {{ $thread->first()->receiver->name ?? 'N/A' }}</span>
                                    </div>
                                    <div class="space-y-3 bg-gray-50 p-4 rounded-lg border border-gray-100 max-h-48 overflow-y-auto">
                                        @foreach($thread->sortBy('created_at') as $msg)
                                            <div class="flex flex-col {{ $msg->sender_id === auth()->id() ? 'items-end' : 'items-start' }}">
                                                <div class="max-w-[85%] rounded-lg px-3 py-1.5 text-xs shadow-sm {{ $msg->sender_id === auth()->id() ? 'bg-blue-600 text-white rounded-br-none' : 'bg-white text-gray-800 border border-gray-200 rounded-bl-none' }}">
                                                    <p>{{ $msg->message }}</p>
                                                </div>
                                                <span class="text-[8px] text-gray-400 mt-0.5">{{ $msg->created_at->diffForHumans() }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right 1 Column: Payment History -->
            <div>
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-150 bg-gray-50">
                        <h2 class="font-bold text-gray-900 text-lg">MoMo Payment History</h2>
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
                                        <span class="text-[10px] font-bold uppercase px-2.5 py-0.5 rounded-full bg-green-100 text-green-800">
                                            {{ $payment->status }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500 space-y-1">
                                        <p class="truncate"><span class="font-semibold text-gray-700">For:</span> {{ $payment->listing->title ?? 'Property' }}</p>
                                        <p class="truncate"><span class="font-semibold text-gray-700">Ref:</span> {{ $payment->transaction_reference }}</p>
                                        <span class="block text-[9px] text-gray-400 mt-1">{{ $payment->created_at->format('M d, Y H:i') }}</span>
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
