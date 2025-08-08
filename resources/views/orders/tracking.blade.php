@extends('layout.app')

@section('title', 'Track Order #' . $order->id)

@section('content')
<div class="min-h-screen py-8" style="background-color: #EEEEEE;">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold" style="color: #B9375D;">Track Your Order</h1>
                    <p class="text-gray-600 mt-2">Order #{{ $order->id }} • Placed on {{ $order->created_at->format('M d, Y') }}</p>
                </div>
                <a href="{{ route('orders.index') }}" 
                   class="px-4 py-2 text-white rounded-lg hover:opacity-90 transition duration-150 ease-in-out"
                   style="background-color: #B9375D;">
                    ← Back to Orders
                </a>
            </div>
        </div>

        <!-- Order Summary Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8 border-2" style="border-color: #E7D3D3;">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h3 class="font-bold mb-2" style="color: #B9375D;"> Order Details</h3>
                    <p class="text-sm text-gray-600">{{ $order->orderItems->count() }} items</p>
                    <p class="text-lg font-bold" style="color: #B9375D;">${{ number_format($order->total_amount, 2) }}</p>
                </div>
                <div>
                    <h3 class="font-bold mb-2" style="color: #B9375D;"> Delivery Address</h3>
                    <p class="text-sm text-gray-600 whitespace-pre-line">{{ $order->shipping_address }}</p>
                </div>
                <div>
                    <h3 class="font-bold mb-2" style="color: #B9375D;"> Estimated Delivery</h3>
                    <p class="text-sm text-gray-600">{{ $order->estimated_delivery_date->format('M d, Y') }}</p>
                    @if($order->status === 'delivered')
                        <p class="text-sm font-bold text-green-600"> Delivered!</p>
                    @else
                        <p class="text-sm text-gray-500">{{ $order->estimated_delivery_date->diffForHumans() }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tracking Timeline -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-2" style="border-color: #E7D3D3;">
            <h2 class="text-2xl font-bold mb-6" style="color: #B9375D;"> Order Progress</h2>
            
            @if($order->trackingUpdates->count() > 0)
                <div class="space-y-6">
                    @foreach($order->trackingUpdates as $tracking)
                        <div class="flex items-start space-x-4">
                            <!-- Status Indicator -->
                            <div class="flex-shrink-0">
                                <div class="w-4 h-4 rounded-full
                                    @if($loop->first)
                                        @if($tracking->status === 'delivered') bg-green-500
                                        @else bg-blue-500 @endif
                                    @else bg-gray-400 @endif">
                                </div>
                            </div>
                            
                            <!-- Status Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold" style="color: #B9375D;">
                                        {{ $tracking->status_display['name'] }}
                                    </h3>
                                    <span class="text-sm text-gray-500">
                                        {{ $tracking->status_date->format('M d, Y g:i A') }}
                                    </span>
                                </div>
                                
                                @if($tracking->message)
                                    <p class="text-gray-700 mt-1">{{ $tracking->message }}</p>
                                @endif
                                
                                @if($tracking->location)
                                    <p class="text-sm text-gray-500 mt-1"> {{ $tracking->location }}</p>
                                @endif
                                
                                @if($tracking->updatedBy)
                                    <p class="text-xs text-gray-400 mt-2">
                                        Updated by {{ $tracking->updatedBy->name }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        
                        @if(!$loop->last)
                            <div class="ml-6 w-0.5 h-6 bg-gray-200"></div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <h3 class="text-lg font-semibold mb-2" style="color: #B9375D;">No Tracking Updates Yet</h3>
                    <p class="text-gray-600">We'll update you as soon as your order starts processing!</p>
                </div>
            @endif
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-lg p-6 mt-8 border-2" style="border-color: #E7D3D3;">
            <h2 class="text-2xl font-bold mb-6" style="color: #B9375D;"> Your Items</h2>
            <div class="space-y-4">
                @foreach($order->orderItems as $item)
                    <div class="flex items-center justify-between py-4 border-b border-gray-200 last:border-b-0">
                        <div class="flex items-center">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $item->product_name }}</h3>
                                <p class="text-sm text-gray-500">
                                    ${{ number_format($item->product_price, 2) }} × {{ $item->quantity }}
                                </p>
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

        <!-- Help Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mt-8 border-2" style="border-color: #E7D3D3;">
            <h2 class="text-xl font-bold mb-4" style="color: #B9375D;"> Need Help?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold mb-2">Contact Support</h3>
                    <p class="text-sm text-gray-600 mb-2">Have questions about your order?</p>
                    <a href="mailto:support@bunnybakes.com" 
                       class="inline-block px-4 py-2 text-white rounded-lg hover:opacity-90 transition duration-150 ease-in-out"
                       style="background-color: #B9375D;">
                         Email Support
                    </a>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Order Information</h3>
                    <p class="text-sm text-gray-600">
                        <strong>Order ID:</strong> #{{ $order->id }}<br>
                        <strong>Payment ID:</strong> {{ $order->payment_intent_id ? Str::limit($order->payment_intent_id, 20) : 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
