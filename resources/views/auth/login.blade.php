<x-layout>
    <div class="max-w-md mx-auto my-12 px-4">
        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm space-y-6">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-900">Sign In to AccraRent</h1>
                <p class="text-gray-500 text-sm mt-1">Access listings and dashboards</p>
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

            <!-- Tabs selector for Password vs OTP -->
            <div class="flex border-b border-gray-200 text-sm">
                <button onclick="toggleTab('password-tab', 'otp-tab')" id="btn-password" class="w-1/2 py-2 text-center font-semibold text-blue-600 border-b-2 border-blue-600 focus:outline-none">
                    Password Login
                </button>
                <button onclick="toggleTab('otp-tab', 'password-tab')" id="btn-otp" class="w-1/2 py-2 text-center font-medium text-gray-500 hover:text-gray-700 focus:outline-none">
                    Phone OTP Login
                </button>
            </div>

            <!-- Email & Password Form -->
            <form action="{{ route('login') }}" method="POST" id="password-tab" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Email Address</label>
                    <input type="email" name="email" required placeholder="e.g. tenant@example.com" class="w-full text-sm border border-gray-300 rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Password</label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full text-sm border border-gray-300 rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>

                <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-sm transition shadow-sm">
                    Sign In
                </button>
            </form>

            <!-- Phone OTP Form -->
            <form action="{{ route('login') }}" method="POST" id="otp-tab" class="hidden space-y-4">
                @csrf
                <input type="hidden" name="otp" value="1">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Phone Number</label>
                    <input type="text" name="phone" id="otp-phone" placeholder="e.g. +233200111222" class="w-full text-sm border border-gray-300 rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>

                <div id="otp-code-section" class="hidden">
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Simulated OTP Code</label>
                    <input type="text" name="otp_code" placeholder="Enter 1234" class="w-full text-sm border border-gray-300 rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <p class="text-[10px] text-green-600 font-medium mt-1">SMS Verification Sent! Enter <strong>1234</strong> to simulate validation.</p>
                </div>

                <button type="button" id="btn-request-otp" onclick="requestOTP()" class="w-full py-2.5 bg-gray-800 hover:bg-gray-900 text-white font-bold rounded-lg text-sm transition shadow-sm">
                    Request OTP Code
                </button>

                <button type="submit" id="btn-submit-otp" class="hidden w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-sm transition shadow-sm">
                    Verify & Login
                </button>
            </form>



            <div class="text-center text-xs text-gray-500">
                Don't have an account? <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:underline">Register here</a>
            </div>
        </div>
    </div>

    <script>
        function toggleTab(showId, hideId) {
            document.getElementById(showId).classList.remove('hidden');
            document.getElementById(hideId).classList.add('hidden');
            
            if (showId === 'password-tab') {
                document.getElementById('btn-password').className = "w-1/2 py-2 text-center font-semibold text-blue-600 border-b-2 border-blue-600 focus:outline-none";
                document.getElementById('btn-otp').className = "w-1/2 py-2 text-center font-medium text-gray-500 hover:text-gray-700 focus:outline-none";
            } else {
                document.getElementById('btn-otp').className = "w-1/2 py-2 text-center font-semibold text-blue-600 border-b-2 border-blue-600 focus:outline-none";
                document.getElementById('btn-password').className = "w-1/2 py-2 text-center font-medium text-gray-500 hover:text-gray-700 focus:outline-none";
            }
        }

        function requestOTP() {
            var phone = document.getElementById('otp-phone').value;
            if (!phone) {
                alert('Please enter a phone number first!');
                return;
            }
            document.getElementById('otp-code-section').classList.remove('hidden');
            document.getElementById('btn-request-otp').classList.add('hidden');
            document.getElementById('btn-submit-otp').classList.remove('hidden');
        }


    </script>
</x-layout>
