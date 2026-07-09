<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accra Rent | Affordable Housing & Room Rental Marketplace</title>
    
    <!-- Load Tailwind CSS via CDN for lightweight, build-free setup -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Font (Inter) for clean typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- Navigation Header -->
    <header class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <!-- Logo / Home Link -->
                <a href="/" class="text-2xl font-bold text-blue-600 flex items-center gap-1">
                    <span>AccraRent</span>
                    <span class="text-xs px-2 py-0.5 bg-green-100 text-green-800 rounded-full font-medium">MVP</span>
                </a>
            </div>
            
            <nav class="hidden md:flex items-center gap-6">
                <a href="/listings" class="text-gray-600 hover:text-blue-600 font-medium transition">Find a Room</a>
                <a href="/#how-it-works" class="text-gray-600 hover:text-blue-600 font-medium transition">How it Works</a>
                @auth
                    <a href="/favorites" class="text-gray-600 hover:text-blue-600 font-medium transition">Favorites</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="/admin/dashboard" class="text-gray-600 hover:text-blue-600 font-bold transition">Admin Portal</a>
                    @elseif(auth()->user()->role === 'landlord')
                        <a href="/landlord/dashboard" class="text-gray-600 hover:text-blue-600 font-bold transition">Landlord Portal</a>
                    @else
                        <a href="/tenant/dashboard" class="text-gray-600 hover:text-blue-600 font-bold transition">Tenant Portal</a>
                    @endif
                @endauth
            </nav>

            <div class="flex items-center gap-3">
                <a href="/listings" class="hidden sm:inline-block px-4 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg font-medium text-sm transition">
                    Browse Listings
                </a>
                
                @guest
                    <!-- Sign In / Register buttons -->
                    <a href="{{ route('login') }}" class="hidden sm:inline-block text-gray-600 hover:text-blue-600 font-medium text-sm transition">Sign In</a>
                    <a href="{{ route('register') }}" class="hidden sm:inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm transition">
                        Register
                    </a>
                @endguest

                @auth
                    <!-- User Account / Logout -->
                    <div class="hidden sm:flex items-center gap-3 text-sm">
                        <span class="font-medium text-gray-700 hidden lg:inline">Hello, {{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-3.5 py-2 bg-gray-100 hover:bg-red-50 text-gray-700 hover:text-red-600 rounded-lg text-xs font-semibold transition border border-gray-200">
                                Logout
                            </button>
                        </form>
                    </div>
                @endauth

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" type="button" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path id="menu-icon-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path id="menu-icon-close" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Navigation -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white px-4 py-3 space-y-3 shadow-inner">
            <a href="/listings" class="block py-2 text-gray-600 hover:text-blue-600 font-medium transition">Find a Room</a>
            <a href="/#how-it-works" class="block py-2 text-gray-600 hover:text-blue-600 font-medium transition">How it Works</a>
            @auth
                <a href="/favorites" class="block py-2 text-gray-600 hover:text-blue-600 font-medium transition">Favorites</a>
                @if(auth()->user()->role === 'admin')
                    <a href="/admin/dashboard" class="block py-2 text-gray-600 hover:text-blue-600 font-bold transition">Admin Portal</a>
                @elseif(auth()->user()->role === 'landlord')
                    <a href="/landlord/dashboard" class="block py-2 text-gray-600 hover:text-blue-600 font-bold transition">Landlord Portal</a>
                @else
                    <a href="/tenant/dashboard" class="block py-2 text-gray-600 hover:text-blue-600 font-bold transition">Tenant Portal</a>
                @endif
                
                <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-sm">
                    <span class="font-medium text-gray-700">Hello, {{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3.5 py-2 bg-gray-100 hover:bg-red-50 text-gray-700 hover:text-red-600 rounded-lg text-xs font-semibold transition border border-gray-200">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="pt-3 border-t border-gray-100 grid grid-cols-2 gap-3">
                    <a href="{{ route('login') }}" class="flex items-center justify-center px-4 py-2 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 text-sm font-medium transition text-center">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition text-center">
                        Register
                    </a>
                </div>
            @endguest
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const btn = document.getElementById('mobile-menu-btn');
                const menu = document.getElementById('mobile-menu');
                const openIcon = document.getElementById('menu-icon-open');
                const closeIcon = document.getElementById('menu-icon-close');

                if (btn && menu) {
                    btn.addEventListener('click', function() {
                        menu.classList.toggle('hidden');
                        openIcon.classList.toggle('hidden');
                        closeIcon.classList.toggle('hidden');
                    });
                }
            });
        </script>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-white font-bold text-lg mb-3">AccraRent</h3>
                    <p class="text-sm">Connecting tenants and verified property owners in Accra, Ghana. Simple, affordable, and trustworthy.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-3">Neighborhoods</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/listings?search=East+Legon" class="hover:text-white transition">East Legon</a></li>
                        <li><a href="/listings?search=Osu" class="hover:text-white transition">Osu</a></li>
                        <li><a href="/listings?search=Spintex" class="hover:text-white transition">Spintex</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-800 text-center text-xs">
                <p>&copy; {{ date('Y') }} AccraRent. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>