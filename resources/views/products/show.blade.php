@extends('layout.app')

@section('title', $product->name . ' - Bunny Bakes')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-8">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center px-4 py-2 text-lg font-medium text-gray-700 bg-white rounded-lg border border-gray-300 hover:bg-gray-50 transition duration-150 ease-in-out">
                ← Back to Products
            </a>
        </div>

        <!-- Product Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="space-y-4">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 bg-gray-100 flex items-center justify-center">
                            <div class="text-center text-gray-400">
                                <p class="text-xl">No Image Available</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Information -->
            <div class="space-y-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
                    <div class="flex items-center space-x-2">
                        <span class="text-3xl font-bold" style="color: #B9375D;">${{ number_format($product->price, 2) }}</span>
                        @if($product->stock_quantity > 0)
                            <span class="text-sm font-medium" style="color: #B9375D;">
                                {{ $product->stock_quantity }} in stock
                            </span>
                        @else
                            <span class="text-sm font-medium" style="color: #B9375D;">
                                Out of stock
                            </span>
                        @endif
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Description</h3>
                    <p class="text-gray-600 text-lg leading-relaxed">{{ $product->description }}</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                    @auth
                        @if($product->isAvailable())
                            <form method="POST" action="{{ route('cart.add', $product) }}" class="space-y-4">
                                @csrf
                                <!-- Quantity Selector -->
                                <div class="flex items-center space-x-4">
                                    <label class="text-lg font-medium text-gray-700">Quantity:</label>
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button type="button" onclick="decreaseQuantity()"
                                                class="px-4 py-2 text-xl font-bold text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-l-lg transition duration-150 ease-in-out">
                                            -
                                        </button>
                                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                                               class="w-16 px-2 py-2 text-center border-0 focus:ring-0 focus:outline-none">
                                        <button type="button" onclick="increaseQuantity()"
                                                class="px-4 py-2 text-xl font-bold text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-r-lg transition duration-150 ease-in-out">
                                            +
                                        </button>
                                    </div>
                                </div>

                                <!-- Add to Cart Button -->
                                <button type="submit"
                                        class="w-full py-4 px-6 text-xl font-bold text-white rounded-lg shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:scale-105"
                                        style="background-color: #B9375D;">
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <button disabled
                                    class="w-full py-4 px-6 text-xl font-bold text-white bg-gray-400 rounded-lg cursor-not-allowed">
                                Currently Unavailable
                            </button>
                        @endif
                    @else
                        <div class="text-center">
                            <p class="text-gray-600 mb-4">Please log in to add items to your cart</p>
                            <a href="{{ route('login') }}"
                               class="inline-block w-full py-4 px-6 text-xl font-bold text-white rounded-lg shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:scale-105"
                               style="background-color: #B9375D;">
                                Login to Add to Cart
                            </a>
                        </div>
                    @endauth

                    <!-- Additional Actions -->
                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <a href="{{ route('cart.index') }}"
                           class="py-3 px-4 text-center text-lg font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-150 ease-in-out">
                            View Cart
                        </a>
                        <a href="{{ route('return-policy') }}"
                           class="py-3 px-4 text-center text-lg font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-150 ease-in-out">
                            Return Policy
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    </div>
</div>

<script>
function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const maxValue = parseInt(quantityInput.max);

    if (currentValue < maxValue) {
        quantityInput.value = currentValue + 1;
    }
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const minValue = parseInt(quantityInput.min);

    if (currentValue > minValue) {
        quantityInput.value = currentValue - 1;
    }
}
</script>
@endsection
