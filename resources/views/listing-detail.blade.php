<x-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Back Button -->
        <a href="/listings" class="inline-flex items-center gap-1 text-sm font-semibold text-gray-500 hover:text-blue-600 transition mb-6">
            &larr; Back to all listings
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Property Details Content (Left 2 Columns) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title & Header info -->
                <div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-md">
                                {{ $listing->property_type }}
                            </span>
                            @if($listing->is_verified)
                                <span class="px-2.5 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded-md">
                                    Verified Property
                                </span>
                            @endif
                        </div>

                        <!-- Favorite Toggle -->
                        @auth
                            <form action="{{ route('listings.favorite', $listing->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2 bg-gray-100 hover:bg-red-50 rounded-full transition shadow-sm" title="Favorite">
                                    @if(auth()->user()->favorites->contains($listing->id))
                                        <!-- Solid Red Heart -->
                                        <svg class="h-5 w-5 fill-current text-red-600" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                    @else
                                        <!-- Outlined Heart -->
                                        <svg class="h-5 w-5 fill-none stroke-current stroke-2 text-gray-500 hover:text-red-600" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    @endif
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="p-2 bg-gray-100 hover:bg-red-50 rounded-full transition shadow-sm" title="Login to Favorite">
                                <svg class="h-5 w-5 fill-none stroke-current stroke-2 text-gray-500" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </a>
                        @endauth
                    </div>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $listing->title }}</h1>
                    <p class="text-sm font-medium text-gray-500">
                        <span class="text-gray-700">Location:</span> {{ $listing->location }}
                    </p>
                </div>

                <!-- Photos Carousel/Grid -->
                <div class="bg-white rounded-xl overflow-hidden border border-gray-200 p-2 shadow-sm">
                    @if(!empty($listing->photos) && is_array($listing->photos))
                        <!-- Main Image -->
                        <div class="h-96 w-full rounded-lg overflow-hidden bg-gray-100">
                            <img src="{{ $listing->photos[0] }}" alt="{{ $listing->title }}" class="w-full h-full object-cover">
                        </div>

                        <!-- Thumbnails (if multiple exist) -->
                        @if(count($listing->photos) > 1)
                            <div class="grid grid-cols-3 gap-2 mt-2">
                                @foreach($listing->photos as $photo)
                                    <div class="h-24 rounded-lg overflow-hidden border border-gray-100 hover:border-blue-500 transition cursor-pointer">
                                        <img src="{{ $photo }}" alt="property thumbnail" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="h-96 w-full flex items-center justify-center bg-gray-100 text-gray-400">
                            No Photos Available
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4">
                    <h2 class="text-xl font-bold text-gray-900">Description</h2>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line text-sm">
                        {{ $listing->description }}
                    </p>

                    <!-- Key features list -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-4 border-t border-gray-100">
                        <div>
                            <span class="block text-xs font-semibold text-gray-400 uppercase">Bedrooms</span>
                            <span class="text-sm font-bold text-gray-800">{{ $listing->bedrooms }} Bedrooms</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-400 uppercase">Property Type</span>
                            <span class="text-sm font-bold text-gray-800">{{ $listing->property_type }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-400 uppercase">Monthly Price</span>
                            <span class="text-sm font-bold text-blue-600">GHS {{ number_format($listing->price) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Map Location (Google Maps API Embed) -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4">
                    <h2 class="text-xl font-bold text-gray-900">Location Map</h2>
                    <div class="h-80 w-full rounded-lg overflow-hidden border border-gray-200 shadow-inner">
                        <iframe 
                            width="100%" 
                            height="100%" 
                            frameborder="0" 
                            style="border:0;" 
                            src="https://maps.google.com/maps?q={{ urlencode($listing->location) }}&t=&z=14&ie=UTF8&iwloc=&output=embed" 
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>

            <!-- Landlord Contact Sidebar (Right 1 Column) -->
            <div class="space-y-6">
                <!-- Pricing & Contact Panel -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6">
                    <div>
                        <span class="text-3xl font-extrabold text-blue-600">GHS {{ number_format($listing->price) }}</span>
                        <span class="text-sm text-gray-400">/ month</span>
                    </div>

                    <!-- Landlord Profile info -->
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-700 uppercase">
                            {{ substr($listing->user->name ?? 'L', 0, 2) }}
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-400 uppercase">Listed By Landlord</span>
                            <span class="text-sm font-bold text-gray-900">{{ $listing->user->name ?? 'Property Owner' }}</span>
                            @if($listing->user->is_verified ?? false)
                                <span class="inline-block text-[10px] px-1.5 py-0.2 bg-green-100 text-green-800 rounded font-medium">Verified Agent</span>
                            @endif
                        </div>
                    </div>

                    <!-- Contact Actions & In-App Chat -->
                    <div class="space-y-4 pt-4 border-t border-gray-100">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">In-App Chat</h3>
                        
                        <!-- Scrollable Message Thread -->
                        <div class="h-48 overflow-y-auto space-y-3 p-3 bg-gray-50 rounded-lg border border-gray-150 flex flex-col" id="chat-box" style="scroll-behavior: smooth;">
                            @if($messages->isEmpty())
                                <div class="text-center text-xs text-gray-400 my-auto py-8">
                                    No messages yet. Ask the landlord a question!
                                </div>
                            @else
                                @foreach($messages as $msg)
                                    @php
                                        // Simple logic: if message is from tenant, float it right
                                        $isTenant = ($msg->sender->role ?? 'tenant') === 'tenant';
                                    @endphp
                                    <div class="flex flex-col {{ $isTenant ? 'items-end' : 'items-start' }} space-y-1">
                                        <div class="max-w-[85%] rounded-lg px-3 py-2 text-xs shadow-sm {{ $isTenant ? 'bg-blue-600 text-white rounded-br-none' : 'bg-white text-gray-800 border border-gray-200 rounded-bl-none' }}">
                                            <p class="leading-relaxed">{{ $msg->message }}</p>
                                        </div>
                                        <span class="text-[9px] text-gray-400 px-1">
                                            {{ $isTenant ? 'You' : ($msg->sender->name ?? 'Landlord') }} &bull; {{ $msg->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Chat Submission Form -->
                        <form action="{{ route('listings.messages.store', $listing->id) }}" method="POST" class="space-y-2">
                            @csrf
                            <input type="text" name="message" required placeholder="Type your message..." autocomplete="off" class="w-full text-xs border border-gray-300 rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <button type="submit" class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-lg transition shadow-sm">
                                Send Message
                            </button>
                        </form>

                        <div class="pt-2 border-t border-gray-100">
                            <!-- WhatsApp Deep Link -->
                            @if(!empty($listing->user->phone))
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $listing->user->phone) }}?text=Hello%20{{ urlencode($listing->user->name) }},%20I%20am%20interested%20in%20your%20listing:%20{{ urlencode($listing->title) }}" 
                                   target="_blank" 
                                   class="block w-full py-2.5 bg-green-500 hover:bg-green-600 text-white font-bold text-xs rounded-lg text-center shadow-sm transition">
                                    Chat on WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>

                    <script>
                        // Auto-scroll chat box to bottom
                        window.onload = function() {
                            var chatBox = document.getElementById("chat-box");
                            if (chatBox) {
                                chatBox.scrollTop = chatBox.scrollHeight;
                            }
                        }
                    </script>
                </div>

                <!-- MoMo Reservation Deposit Panel -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wider">Reserve with MoMo</h3>
                    <p class="text-xs text-gray-500">Secure the room instantly by placing a holding deposit.</p>
                    
                    @auth
                        <form action="{{ route('listings.pay', $listing->id) }}" method="POST" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Select Network</label>
                                <select name="network" required class="w-full text-xs border border-gray-300 rounded-lg p-2 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    <option value="MTN">MTN Mobile Money</option>
                                    <option value="Vodafone">Telecel Cash (Vodafone)</option>
                                    <option value="AirtelTigo">AT Money (AirtelTigo)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Momo Wallet Number</label>
                                <input type="text" name="momo_phone" value="{{ auth()->user()->phone }}" required placeholder="e.g. +233241234567" class="w-full text-xs border border-gray-300 rounded-lg p-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Deposit Amount (GHS)</label>
                                <input type="number" name="amount" required value="200" class="w-full text-xs border border-gray-300 rounded-lg p-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <p class="text-[9px] text-gray-400 mt-1">Recommended holding deposit: GHS 200</p>
                            </div>
                            
                            <button type="submit" class="w-full py-2.5 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-extrabold text-xs rounded-lg transition shadow-sm uppercase tracking-wider">
                                Pay holding Deposit
                            </button>
                        </form>
                    @else
                        <div class="text-center p-4 bg-gray-50 border border-dashed border-gray-200 rounded-lg">
                            <p class="text-xs text-gray-500 mb-2">Please sign in to place a holding deposit.</p>
                            <a href="{{ route('login') }}" class="inline-block px-4 py-1.5 bg-blue-600 text-white font-semibold text-xs rounded hover:bg-blue-700 transition">
                                Sign In
                            </a>
                        </div>
                    @endauth
                </div>

                <!-- Safety Tip Panel -->
                <div class="bg-amber-50 border border-amber-200 p-5 rounded-xl space-y-2">
                    <h3 class="text-amber-800 font-bold text-sm flex items-center gap-1.5">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 002 0V6zm-1 8a1 1 0 100-2 1 1 0 000 2z"></path></svg>
                        Viewing Safety Tip
                    </h3>
                    <p class="text-xs text-amber-700 leading-relaxed">
                        Do not make any upfront payments or viewing fee deposits before visiting the property in person. Always verify the location and landlord details before signing lease agreements.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating WhatsApp Action Button (FAB) -->
    @if(!empty($listing->user->phone))
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $listing->user->phone) }}?text=Hello%20{{ urlencode($listing->user->name) }},%20I%20am%20interested%20in%20your%20listing:%20{{ urlencode($listing->title) }}%20(GHS%20{{ number_format($listing->price) }})" 
           target="_blank" 
           title="Chat with Landlord on WhatsApp"
           class="fixed bottom-6 right-6 h-14 w-14 bg-green-500 hover:bg-green-600 text-white rounded-full shadow-lg flex items-center justify-center transition duration-150 transform hover:scale-110 z-50">
            <!-- WhatsApp Vector Icon -->
            <svg class="h-8 w-8 fill-current" viewBox="0 0 24 24">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.42 9.864-9.864.002-2.637-1.03-5.115-2.908-6.995-1.878-1.88-4.357-2.912-6.997-2.914-5.443 0-9.865 4.42-9.869 9.866-.001 1.77.463 3.5 1.34 5.01L1.885 22.09l6.3-1.654-.538-.382zM17.487 14.39c-.3-.15-1.774-.875-2.048-.975-.275-.1-.475-.15-.675.15-.2.3-.775.975-.95 1.175-.175.2-.35.225-.65.075-.3-.15-1.267-.467-2.413-1.488-.892-.796-1.493-1.78-1.668-2.08-.175-.3-.018-.462.13-.61.135-.133.3-.35.45-.525.15-.175.2-.3.3-.5s.05-.375-.025-.525c-.075-.15-.675-1.625-.925-2.225-.244-.589-.491-.51-.675-.52-.175-.007-.375-.01-.575-.01-.2 0-.525.075-.8.375-.275.3-1.05 1.025-1.05 2.5 0 1.475 1.075 2.9 1.225 3.1.15.2 2.11 3.22 5.11 4.52.714.31 1.27.496 1.703.633.717.228 1.37.196 1.885.119.575-.085 1.774-.725 2.025-1.425.25-.7.25-1.3.175-1.425-.075-.125-.275-.2-.575-.35z"/>
            </svg>
        </a>
    @endif
</x-layout>
