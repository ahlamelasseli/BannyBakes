<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bunny Bakes') }} - @yield('title', 'Delicious Homemade Cookies')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dancing-script:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="background-color: #EEEEEE; font-family: 'Dancing Script', cursive;">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="shadow-lg" style="background-color: #B9375D;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                            <h1 class="text-2xl font-bold text-white">Bunny Bakes</h1>
                        </a>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <a href="{{ route('home') }}" class="text-white hover:text-pink-200 px-3 py-2 rounded-md text-lg font-medium transition duration-150 ease-in-out">
                                Home
                            </a>
                            <a href="{{ route('products.index') }}" class="text-white hover:text-pink-200 px-3 py-2 rounded-md text-lg font-medium transition duration-150 ease-in-out">
                                Products
                            </a>
                            <a href="{{ route('return-policy') }}" class="text-white hover:text-pink-200 px-3 py-2 rounded-md text-lg font-medium transition duration-150 ease-in-out">
                                Return Policy
                            </a>
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center space-x-4">
                        <!-- Cart with Counter -->
                        <a href="{{ route('cart.index') }}" class="relative text-white hover:text-pink-200 px-3 py-2 rounded-md text-lg font-medium transition duration-150 ease-in-out">
                            Cart
                            <span id="cart-count" class="absolute -top-1 -right-1 bg-pink-200 text-pink-800 text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center" style="display: none;">
                                0
                            </span>
                        </a>

                        @auth
                            <!-- User Menu -->
                            <div class="relative">
                                <button class="text-white hover:text-pink-200 px-3 py-2 rounded-md text-lg font-medium transition duration-150 ease-in-out">
                                    {{ Auth::user()->name }}
                                </button>
                                <!-- Dropdown would go here -->
                            </div>

                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="bg-pink-200 text-pink-800 hover:bg-pink-300 px-3 py-2 rounded-md text-lg font-medium transition duration-150 ease-in-out">
                                    Admin
                                </a>
                            @endif

                            <a href="{{ route('orders.index') }}" class="text-white hover:text-pink-200 px-3 py-2 rounded-md text-lg font-medium transition duration-150 ease-in-out">
                                My Orders
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-white hover:text-pink-200 px-3 py-2 rounded-md text-lg font-medium transition duration-150 ease-in-out">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:text-pink-200 px-3 py-2 rounded-md text-lg font-medium transition duration-150 ease-in-out">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="text-white hover:text-pink-200 px-3 py-2 rounded-md text-lg font-medium transition duration-150 ease-in-out">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Success Modal -->
        @if(session('success'))
            <div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3 text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Success!</h3>
                        <div class="mt-2 px-7 py-3">
                            <p class="text-sm text-gray-500">{{ session('success') }}</p>
                        </div>
                        <div class="items-center px-4 py-3">
                            <button id="closeSuccessModal" class="px-4 py-2 text-white text-base font-medium rounded-md w-full shadow-sm hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-300 transition duration-150 ease-in-out" style="background-color: #B9375D;">
                                OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Error Modal -->
        @if(session('error'))
            <div id="errorModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3 text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Error!</h3>
                        <div class="mt-2 px-7 py-3">
                            <p class="text-sm text-gray-500">{{ session('error') }}</p>
                        </div>
                        <div class="items-center px-4 py-3">
                            <button id="closeErrorModal" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-150 ease-in-out">
                                OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <main class="py-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="mt-16 py-8" style="background-color: #B9375D;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center text-white">
                    <h3 class="text-xl font-semibold mb-2">Bunny Bakes</h3>
                    <p class="text-pink-200">Delicious homemade cookies made with love</p>
                    <p class="text-pink-200 mt-2">&copy; {{ date('Y') }} Bunny Bakes. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Cart Count Script -->
    <script>
        // Update cart count on page load and handle modals
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();

            // Success Modal
            const successModal = document.getElementById('successModal');
            const closeSuccessModal = document.getElementById('closeSuccessModal');

            if (successModal && closeSuccessModal) {
                closeSuccessModal.addEventListener('click', function() {
                    successModal.style.display = 'none';
                });

                // Close modal when clicking outside
                successModal.addEventListener('click', function(e) {
                    if (e.target === successModal) {
                        successModal.style.display = 'none';
                    }
                });

                // Auto-close after 5 seconds
                setTimeout(function() {
                    if (successModal) {
                        successModal.style.display = 'none';
                    }
                }, 5000);
            }

            // Error Modal
            const errorModal = document.getElementById('errorModal');
            const closeErrorModal = document.getElementById('closeErrorModal');

            if (errorModal && closeErrorModal) {
                closeErrorModal.addEventListener('click', function() {
                    errorModal.style.display = 'none';
                });

                // Close modal when clicking outside
                errorModal.addEventListener('click', function(e) {
                    if (e.target === errorModal) {
                        errorModal.style.display = 'none';
                    }
                });
            }
        });

        // Function to update cart count
        function updateCartCount() {
            fetch('{{ route('cart.count') }}')
                .then(response => response.json())
                .then(data => {
                    const cartCountElement = document.getElementById('cart-count');
                    if (data.count > 0) {
                        cartCountElement.textContent = data.count;
                        cartCountElement.style.display = 'flex';
                    } else {
                        cartCountElement.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error updating cart count:', error));
        }

        // Update cart count after adding items (for forms that add to cart)
        document.addEventListener('submit', function(e) {
            if (e.target.action && e.target.action.includes('/cart/add/')) {
                setTimeout(updateCartCount, 500); // Small delay to allow server processing
            }
        });
    </script>
</body>
</html>