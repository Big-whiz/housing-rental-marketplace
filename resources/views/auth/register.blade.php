<x-layout>
    <div class="max-w-md mx-auto my-12 px-4">
        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm space-y-6">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-900">Create Account</h1>
                <p class="text-gray-500 text-sm mt-1">Join the AccraRent marketplace</p>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="p-3.5 bg-red-50 border border-red-200 text-red-700 text-xs rounded-lg font-medium">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. John Doe" class="w-full text-sm border border-gray-300 rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="e.g. john@example.com" class="w-full text-sm border border-gray-300 rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="e.g. +233240000000" class="w-full text-sm border border-gray-300 rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>

                <!-- Role Selection -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">I am registering as a</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="border border-gray-300 rounded-lg p-3 flex items-center justify-between text-sm cursor-pointer hover:bg-gray-50">
                            <span class="font-medium text-gray-700">Tenant</span>
                            <input type="radio" name="role" value="tenant" checked class="text-blue-600 focus:ring-blue-500">
                        </label>
                        <label class="border border-gray-300 rounded-lg p-3 flex items-center justify-between text-sm cursor-pointer hover:bg-gray-50">
                            <span class="font-medium text-gray-700">Landlord</span>
                            <input type="radio" name="role" value="landlord" class="text-blue-600 focus:ring-blue-500">
                        </label>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Password</label>
                    <input type="password" name="password" required placeholder="•••••••• (Min 6 characters)" class="w-full text-sm border border-gray-300 rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" required placeholder="••••••••" class="w-full text-sm border border-gray-300 rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>

                <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-sm transition shadow-sm">
                    Create Account
                </button>
            </form>

            <div class="text-center text-xs text-gray-500">
                Already have an account? <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:underline">Sign in here</a>
            </div>
        </div>
    </div>
</x-layout>
