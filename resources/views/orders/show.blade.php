@extends('layout.app')

@section('title', 'Order Details')

@section('content')
<div class="min-h-screen py-8" style="background-color: #EEEEEE;">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Order #{{ $order->id }}</h1>
                    <p class="text-gray-600 mt-2">Placed on {{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                </div>
                <a href="{{ route('orders.index') }}" 
                   class="px-4 py-2 text-gray-600 hover:text-gray-800 transition duration-150 ease-in-out">
                    ← Back to Orders
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Order Details -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6" style="border: 1px solid #E7D3D3;">
                    <h2 class="text-xl font-semibold mb-4" style="color: #B9375D;">Order Status</h2>
                    <div class="flex items-center">
                        <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                            @elseif($order->status === 'delivered') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                        @if($order->estimated_delivery_date)
                            <span class="ml-4 text-sm text-gray-600">
                                Estimated delivery: {{ $order->estimated_delivery_date->format('M d, Y') }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-lg p-6" style="border: 1px solid #E7D3D3;">
                    <h2 class="text-xl font-semibold mb-4" style="color: #B9375D;">Order Items</h2>
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                            <div class="flex items-center justify-between py-4 border-b border-gray-200 last:border-b-0">
                                <div class="flex items-center">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">{{ $item->product_name }}</h3>
                                        <p class="text-sm text-gray-500">
                                            ${{ number_format($item->product_price, 2) }} × {{ $item->quantity }}
                                        </p>
                                        @if($item->product)
                                            <p class="text-xs text-gray-400 mt-1">{{ $item->product->description }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-lg font-semibold text-gray-900">
                                    ${{ number_format($item->subtotal, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Total -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <div class="flex items-center justify-between text-xl font-semibold">
                            <span>Total:</span>
                            <span style="color: #B9375D;">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Information -->
            <div class="space-y-6">
                <!-- Customer Information -->
                <div class="bg-white rounded-lg shadow-lg p-6" style="border: 1px solid #E7D3D3;">
                    <h3 class="text-lg font-semibold mb-4" style="color: #B9375D;">Customer Information</h3>
                    <div class="space-y-2">
                        <p class="text-sm">
                            <span class="font-medium text-gray-700">Name:</span><br>
                            <span class="text-gray-900">{{ $order->customer_name }}</span>
                        </p>
                        <p class="text-sm">
                            <span class="font-medium text-gray-700">Email:</span><br>
                            <span class="text-gray-900">{{ $order->customer_email }}</span>
                        </p>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white rounded-lg shadow-lg p-6" style="border: 1px solid #E7D3D3;">
                    <h3 class="text-lg font-semibold mb-4" style="color: #B9375D;">Shipping Address</h3>
                    <div class="text-sm text-gray-900 whitespace-pre-line">{{ $order->shipping_address }}</div>
                </div>

                <!-- Payment Information -->
                @if($order->payment_intent_id)
                <div class="bg-white rounded-lg shadow-lg p-6" style="border: 1px solid #E7D3D3;">
                    <h3 class="text-lg font-semibold mb-4" style="color: #B9375D;">Payment Information</h3>
                    <div class="space-y-2">
                        <p class="text-sm">
                            <span class="font-medium text-gray-700">Payment Status:</span><br>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Paid
                            </span>
                        </p>
                        <p class="text-sm">
                            <span class="font-medium text-gray-700">Payment ID:</span><br>
                            <span class="text-gray-900 font-mono text-xs">{{ $order->payment_intent_id }}</span>
                        </p>
                    </div>
                </div>
                @endif

                <!-- Order Actions -->
                <div class="bg-white rounded-lg shadow-lg p-6" style="border: 1px solid #E7D3D3;">
                    <h3 class="text-lg font-semibold mb-4" style="color: #B9375D;">Need Help?</h3>
                    <div class="space-y-3">
                        <p class="text-sm text-gray-600">
                            If you have any questions about your order, please contact our support team.
                        </p>
                        <a href="mailto:support@bunnybakes.com" 
                           class="inline-block w-full text-center px-4 py-2 text-white rounded-lg hover:opacity-90 transition duration-150 ease-in-out"
                           style="background-color: #B9375D;">
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
