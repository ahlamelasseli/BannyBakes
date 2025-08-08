<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bunny Bakes') }} - @yield('title', 'Delicious Homemade Cookies')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dancing-script:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        input:focus,
        textarea:focus,
        select:focus {
            outline: none !important;
            border-color: #B9375D !important;
            box-shadow: 0 0 0 2px rgba(185, 55, 93, 0.2) !important;
        }

        input,
        textarea,
        select {
            border: 1px solid #d1d5db;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            outline: none !important;
            border-color: #B9375D !important;
            box-shadow: 0 0 0 2px rgba(185, 55, 93, 0.2) !important;
        }
    </style>
</head>
<body class="font-sans antialiased" style="background-color: #EEEEEE; font-family: 'Dancing Script', cursive;">
    <div class="min-h-screen">
        <nav class="shadow-lg" style="background-color: #B9375D;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                            <h1 class="text-2xl font-bold text-white">Bunny Bakes</h1>
                        </a>

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
                        @auth
                            @if(!Auth::user()->isAdmin())
                                <a href="{{ route('cart.index') }}" class="relative text-white hover:text-pink-200 px-3 py-2 rounded-md text-lg font-medium transition duration-150 ease-in-out">
                                    Cart
                                    <span id="cart-count" class="absolute -top-1 -right-1 bg-pink-200 text-pink-800 text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center" style="display: none;">
                                        0
                                    </span>
                                </a>
                            @endif
                        @else
                            <a href="{{ route('cart.index') }}" class="relative text-white hover:text-pink-200 px-3 py-2 rounded-md text-lg font-medium transition duration-150 ease-in-out">
                                Cart
                                <span id="cart-count" class="absolute -top-1 -right-1 bg-pink-200 text-pink-800 text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center" style="display: none;">
                                    0
                                </span>
                            </a>
                        @endauth

                        @auth
                            <!-- User Menu -->
                            <div class="relative">
                                <button class="text-white hover:text-pink-200 px-3 py-2 rounded-md text-lg font-medium transition duration-150 ease-in-out">
                                    {{ Auth::user()->name }}
                                </button>
                            </div>

                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-pink-200 px-3 py-2 rounded-md text-lg font-medium transition duration-150 ease-in-out">
                                    Admin
                                </a>
                            @else
                                <a href="{{ route('orders.index') }}" class="text-white hover:text-pink-200 px-3 py-2 rounded-md text-lg font-medium transition duration-150 ease-in-out">
                                    My Orders
                                </a>
                            @endif

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

        <main class="">
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
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('cart-count')) {
                updateCartCount();
            }

            // Success Modal
            const successModal = document.getElementById('successModal');
            const closeSuccessModal = document.getElementById('closeSuccessModal');

            if (successModal && closeSuccessModal) {
                closeSuccessModal.addEventListener('click', function() {
                    successModal.style.display = 'none';
                });

                successModal.addEventListener('click', function(e) {
                    if (e.target === successModal) {
                        successModal.style.display = 'none';
                    }
                });

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

                
                errorModal.addEventListener('click', function(e) {
                    if (e.target === errorModal) {
                        errorModal.style.display = 'none';
                    }
                });
            }
        });

        // Function to update cart count
        function updateCartCount() {
            @auth
                @if(!Auth::user()->isAdmin())
                    fetch('{{ route('cart.count') }}')
                        .then(response => response.json())
                        .then(data => {
                            const cartCountElement = document.getElementById('cart-count');
                            if (cartCountElement) {
                                if (data.count > 0) {
                                    cartCountElement.textContent = data.count;
                                    cartCountElement.style.display = 'flex';
                                } else {
                                    cartCountElement.style.display = 'none';
                                }
                            }
                        })
                        .catch(error => console.error('Error updating cart count:', error));
                @endif
            @else
                fetch('{{ route('cart.count') }}')
                    .then(response => response.json())
                    .then(data => {
                        const cartCountElement = document.getElementById('cart-count');
                        if (cartCountElement) {
                            if (data.count > 0) {
                                cartCountElement.textContent = data.count;
                                cartCountElement.style.display = 'flex';
                            } else {
                                cartCountElement.style.display = 'none';
                            }
                        }
                    })
                    .catch(error => console.error('Error updating cart count:', error));
            @endauth
        }

    
        document.addEventListener('submit', function(e) {
            if (e.target.action && e.target.action.includes('/cart/add/')) {
                setTimeout(updateCartCount, 500); 
            }
        });
    </script>
</body>
</html>