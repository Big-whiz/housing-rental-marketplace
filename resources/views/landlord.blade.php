<x-layout>
    <!-- Hero Header -->
    <div class="bg-gradient-to-r from-blue-700 to-indigo-800 text-white py-16 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">List Your Property in Accra</h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto mb-6">
                Connect with verified tenants looking for rooms, apartments, and houses across Ghana's capital.
            </p>
            <a href="/landlord/dashboard" class="inline-block px-5 py-2.5 bg-white text-blue-700 hover:bg-gray-100 rounded-lg font-bold text-sm shadow-sm transition">
                Go to Landlord Dashboard Portal
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b pb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Property Listing Form</h2>
                    <p class="text-sm text-gray-500 mt-1">Provide accurate details to get your listing verified and active.</p>
                </div>
            </div>

            <!-- Functional Form with CSRF and File Uploads -->
            <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Title -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Listing Title</label>
                    <input type="text" name="title" placeholder="e.g. Modern 2-Bedroom Apartment in East Legon" required class="w-full text-sm border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>

                <!-- Price and Type -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Monthly Rent (GHS)</label>
                        <input type="number" name="price" placeholder="e.g. 1500" required class="w-full text-sm border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Property Type</label>
                        <select name="property_type" required class="w-full text-sm border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-white">
                            <option value="">Select Type</option>
                            <option value="Apartment">Apartment</option>
                            <option value="House">House</option>
                            <option value="Studio">Studio</option>
                        </select>
                    </div>
                </div>

                <!-- Bedrooms and Location -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Bedrooms</label>
                        <select name="bedrooms" required class="w-full text-sm border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-white">
                            <option value="">Select Bedrooms</option>
                            <option value="1">1 Bedroom</option>
                            <option value="2">2 Bedrooms</option>
                            <option value="3">3 Bedrooms</option>
                            <option value="4">4+ Bedrooms</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Location Neighborhood</label>
                        <input type="text" name="location" placeholder="e.g. East Legon, Accra" required class="w-full text-sm border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Description</label>
                    <textarea name="description" rows="4" placeholder="Describe the amenities, nearby attractions, security details, utilities..." required class="w-full text-sm border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"></textarea>
                </div>

                <!-- Photo Upload Field (Max 3) -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Upload Photos (Maximum 3)</label>
                    <input type="file" name="photos[]" multiple accept="image/*" required class="w-full text-sm border border-gray-300 rounded-lg p-3 bg-gray-50 focus:outline-none">
                    <p class="text-[11px] text-gray-400 mt-1">Select up to 3 images (PNG, JPG up to 5MB each).</p>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-sm shadow-sm transition">
                        Submit Listing for Verification
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
