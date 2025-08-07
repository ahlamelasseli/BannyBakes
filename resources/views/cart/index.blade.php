@extends('layout.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Your Shopping Cart</h1>
            <p class="text-xl text-gray-600">Review your delicious cookie selection</p>
        </div>

        @if($cartItems->isEmpty())
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="mb-8">
                    <div class="text-8xl mb-4">🍪</div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Your cart is empty</h2>
                    <p class="text-xl text-gray-600 mb-8">Add some delicious cookies to get started!</p>
                </div>
                <a href="{{ route('products.index') }}"
                   class="inline-block px-8 py-4 text-xl font-semibold text-white rounded-lg shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:scale-105"
                   style="background-color: #B9375D;">
                    🐰 Shop Our Cookies
                </a>
            </div>
        @else
            <!-- Cart Items -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items List -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200" style="background-color: #B9375D;">
                            <h2 class="text-2xl font-bold text-white">Cart Items ({{ $cartItems->sum('quantity') }} items)</h2>
                        </div>

                        <div class="divide-y divide-gray-200">
                            @foreach($cartItems as $item)
                                <div class="p-6 hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <div class="flex items-center space-x-4">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/100x100/B9375D/FFFFFF?text=🍪' }}"
                                                 alt="{{ $item->product->name }}"
                                                 class="w-20 h-20 rounded-lg object-cover shadow-md">
                                        </div>

                                        <!-- Product Details -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-xl font-semibold text-gray-800 truncate">{{ $item->product->name }}</h3>
                                            <p class="text-gray-600 mt-1">{{ Str::limit($item->product->description, 100) }}</p>
                                            <p class="text-lg font-bold mt-2" style="color: #B9375D;">${{ number_format($item->product->price, 2) }} each</p>
                                        </div>

                                        <!-- Quantity Controls & Actions -->
                                        <div class="flex items-center justify-between space-x-4">
                                            <!-- Quantity Controls -->
                                            <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center space-x-2">
                                                @csrf
                                                @method('PATCH')
                                                <label class="text-sm font-medium text-gray-700">Qty:</label>
                                                <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                       min="1" max="{{ $item->product->stock_quantity }}"
                                                       class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                                       onchange="this.form.submit()">
                                            </form>

                                            <!-- Price & Remove -->
                                            <div class="flex items-center space-x-4">
                                                <p class="text-xl font-bold text-gray-800">${{ number_format($item->subtotal, 2) }}</p>
                                                <form method="POST" action="{{ route('cart.remove', $item) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-800 text-sm font-medium transition duration-150 ease-in-out"
                                                            onclick="return confirm('Remove this item from cart?')">
                                                        Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden sticky top-8">
                        <div class="px-6 py-4 border-b border-gray-200" style="background-color: #B9375D;">
                            <h2 class="text-2xl font-bold text-white">Order Summary</h2>
                        </div>

                        <div class="p-6">
                            <!-- Order Details -->
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between text-lg">
                                    <span class="text-gray-600">Items ({{ $cartItems->sum('quantity') }}):</span>
                                    <span class="font-semibold">${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="border-t pt-4">
                                    <div class="flex justify-between text-2xl font-bold">
                                        <span>Total:</span>
                                        <span style="color: #B9375D;">${{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                <!-- Proceed to Checkout -->
                                @auth
                                    <a href="{{ route('orders.checkout') }}"
                                       class="block w-full py-4 px-6 text-center text-xl font-bold text-white rounded-lg shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:scale-105"
                                       style="background-color: #B9375D;">
                                        Proceed to Payment
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                       class="block w-full py-4 px-6 text-center text-xl font-bold text-white rounded-lg shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:scale-105"
                                       style="background-color: #B9375D;">
                                        Login to Checkout
                                    </a>
                                @endauth



                                <!-- Clear Cart -->
                                <form method="POST" action="{{ route('cart.clear') }}" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full py-3 px-6 text-lg font-semibold bg-white rounded-lg border-2 hover:bg-gray-50 transition duration-150 ease-in-out"
                                            style="border-color: #B9375D; color: #B9375D;"
                                            onclick="return confirm('Are you sure you want to clear your entire cart?')">
                                        Clear All Items
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection