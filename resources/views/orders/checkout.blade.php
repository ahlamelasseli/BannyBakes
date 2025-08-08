@extends('layout.app')

@section('title', 'Checkout')

@section('content')
<div class="min-h-screen py-8" style="background-color: #EEEEEE;">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
            <p class="text-gray-600 mt-2">Complete your order</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-lg p-6" style="border: 1px solid #E7D3D3;">
                <h2 class="text-xl font-semibold mb-4" style="color: #B9375D;">Order Summary</h2>

                <div class="space-y-4">
                    @foreach($cartItems as $item)
                        <div class="flex items-center justify-between py-3 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                                    <p class="text-sm text-gray-500">${{ number_format($item->product->price, 2) }} each</p>
                                </div>
                            </div>
                            <div class="text-sm font-medium text-gray-900">
                                ${{ number_format($item->subtotal, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="flex items-center justify-between text-lg font-semibold">
                        <span>Total:</span>
                        <span style="color: #B9375D;">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="bg-white rounded-lg shadow-lg p-6" style="border: 1px solid #E7D3D3;">
                <h2 class="text-xl font-semibold mb-4" style="color: #B9375D;">Shipping Information</h2>

                <form id="checkout-form">
                    @csrf

                    <!-- Customer Information -->
                    <div class="space-y-4">
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text"
                                   id="customer_name"
                                   name="customer_name"
                                   value="{{ auth()->user()->name }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                        </div>

                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email"
                                   id="customer_email"
                                   name="customer_email"
                                   value="{{ auth()->user()->email }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                        </div>

                        <div>
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">Shipping Address</label>
                            <textarea id="shipping_address"
                                      name="shipping_address"
                                      rows="3"
                                      required
                                      placeholder="Enter your complete shipping address"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500"></textarea>
                        </div>
                    </div>

                    <!-- Payment Section -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4" style="color: #B9375D;">Payment Information</h3>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Card Details</label>
                            <div id="card-element" class="p-3 border border-gray-300 rounded-md">
                            </div>
                            <div id="card-errors" role="alert" class="text-red-600 text-sm mt-2"></div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8">
                        <button type="submit"
                                id="submit-button"
                                class="w-full py-3 px-4 text-white font-semibold rounded-lg hover:opacity-90 transition duration-150 ease-in-out"
                                style="background-color: #B9375D;">
                            <span id="button-text">Complete Order - ${{ number_format($total, 2) }}</span>
                            <span id="spinner" class="hidden">Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Stripe JavaScript -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config('services.stripe.publishable_key') }}');
    const elements = stripe.elements();

    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#424770',
                '::placeholder': {
                    color: '#aab7c4',
                },
            },
            invalid: {
                color: '#9e2146',
            },
        },
    });

    // Mount card element
    cardElement.mount('#card-element');

    cardElement.on('change', ({error}) => {
        const displayError = document.getElementById('card-errors');
        if (error) {
            displayError.textContent = error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission
    const form = document.getElementById('checkout-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const submitButton = document.getElementById('submit-button');
        const buttonText = document.getElementById('button-text');
        const spinner = document.getElementById('spinner');

        // Disable submit button and show loading
        submitButton.disabled = true;
        buttonText.classList.add('hidden');
        spinner.classList.remove('hidden');

        const formData = new FormData(form);

        try {
            const {error, paymentMethod} = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
                billing_details: {
                    name: formData.get('customer_name'),
                    email: formData.get('customer_email'),
                },
            });

            if (error) {
                document.getElementById('card-errors').textContent = error.message;

                submitButton.disabled = false;
                buttonText.classList.remove('hidden');
                spinner.classList.add('hidden');
            } else {
                const response = await fetch('{{ route('orders.process-payment') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        payment_method_id: paymentMethod.id,
                        customer_name: formData.get('customer_name'),
                        customer_email: formData.get('customer_email'),
                        shipping_address: formData.get('shipping_address'),
                    }),
                });

                const result = await response.json();

                if (result.success) {
                    window.location.href = '{{ route('orders.index') }}';
                } else {
                    document.getElementById('card-errors').textContent = result.message || 'Payment failed. Please try again.';

                    submitButton.disabled = false;
                    buttonText.classList.remove('hidden');
                    spinner.classList.add('hidden');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('card-errors').textContent = 'An error occurred. Please try again.';

            submitButton.disabled = false;
            buttonText.classList.remove('hidden');
            spinner.classList.add('hidden');
        }
    });
</script>
@endsection