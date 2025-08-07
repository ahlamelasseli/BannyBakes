@extends('layout.app')

@section('title', 'Home')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="text-center py-16">
        <h1 class="text-6xl font-bold text-gray-800 mb-4">
            Welcome to Bunny Bakes
        </h1>
        <p class="text-2xl text-gray-600 mb-8">
            Delicious homemade cookies made with love and the finest ingredients
        </p>
        <a href="{{ route('products.index') }}" class="inline-block px-8 py-4 text-xl font-semibold text-white rounded-lg shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:scale-105" style="background-color: #B9375D;">
            Shop Our Cookies
        </a>
    </div>

    <!-- Featured Products -->
    @if($products->count() > 0)
        <div class="py-16">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">
                Featured Cookies
            </h2>
            
            {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 ease-in-out transform hover:scale-105">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-6xl">🍪</span>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <h3 class="text-2xl font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($product->description, 100) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold" style="color: #B9375D;">${{ number_format($product->price, 2) }}</span>
                                <a href="{{ route('products.show', $product) }}" class="px-4 py-2 text-white rounded-lg hover:opacity-90 transition duration-150 ease-in-out" style="background-color: #B9375D;">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
             --}}
                 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($products as $product)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 ease-in-out transform hover:scale-105">
                <!-- Product Image -->
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-6xl">🍪</span>
                    </div>
                @endif

                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($product->description, 100) }}</p>

                    <div class="flex justify-between items-center mb-4">
                        <span class="text-2xl font-bold" style="color: #B9375D;">${{ number_format($product->price, 2) }}</span>
                        @if($product->stock_quantity > 0)
                            <span class="text-sm" style="color: #B9375D;">{{ $product->stock_quantity }} in stock</span>
                        @else
                            <span class="text-sm" style="color: #B9375D;">Out of stock</span>
                        @endif
                    </div>

                    <div class="space-y-3">
                        <!-- Add to Cart Button -->
                        @auth
                            @if($product->isAvailable())
                                <form method="POST" action="{{ route('cart.add', $product) }}" class="w-full">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit"
                                            class="w-full py-3 px-4 text-lg font-bold text-white rounded-lg shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:scale-105"
                                            style="background-color: #B9375D;">
                                        🛒 Add to Cart
                                    </button>
                                </form>
                            @else
                                <button disabled class="w-full py-3 px-4 text-lg font-bold text-white bg-gray-400 rounded-lg cursor-not-allowed">
                                    ❌ Unavailable
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                               class="block w-full py-3 px-4 text-center text-lg font-bold text-white rounded-lg shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:scale-105"
                               style="background-color: #B9375D;">
                                Login to Add to Cart
                            </a>
                        @endauth



                        <a href="{{ route('products.show', $product) }}" class="block w-full py-2 px-4 text-center border-2 rounded-lg hover:bg-gray-50 transition duration-150 ease-in-out" style="border-color: #B9375D; color: #B9375D;">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">No cookies available yet!</h3>
                    <p class="text-gray-600 mb-6">
                        Our bakers are working hard to prepare delicious cookies for you.
                        Please check back soon!
                    </p>
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.products.create') }}" class="inline-block px-6 py-3 text-white rounded-lg hover:opacity-90 transition duration-150 ease-in-out" style="background-color: #B9375D;">
                                Add First Product
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        @endforelse
    </div>

            <div class="text-center mt-12">
                <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 text-lg font-semibold text-white rounded-lg hover:opacity-90 transition duration-150 ease-in-out" style="background-color: #B9375D;">
                    View All Products
                </a>
            </div>
        </div>
    @endif

    <!-- About Section -->
    <div class="py-16 bg-white rounded-lg shadow-lg mx-4">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-8">
                About Bunny Bakes
            </h2>
            <p class="text-xl text-gray-600 leading-relaxed mb-6">
                At Bunny Bakes, we believe that every cookie should be a moment of pure joy. Our artisan bakers craft each cookie with premium ingredients, traditional techniques, and a whole lot of love.
            </p>
            <p class="text-xl text-gray-600 leading-relaxed">
                From classic chocolate chip to innovative seasonal flavors, we're committed to bringing you the most delicious homemade cookies that will make your taste buds hop with happiness!
            </p>
        </div>
    </div>
</div>
@endsection
