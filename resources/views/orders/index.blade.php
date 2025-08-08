@extends('layout.app')

@section('title', 'My Orders')

@section('content')
<div class="min-h-screen py-8" style="background-color: #EEEEEE;">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
            <p class="text-gray-600 mt-2">Track your order history and status</p>
        </div>

        @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-lg shadow-lg p-6" style="border: 1px solid #E7D3D3;">
                        {{-- <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Order #{{ $order->id }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Placed on {{ $order->created_at->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="mt-2 sm:mt-0 flex items-center space-x-3">
                                @if($order->latestTracking)
                                    <div class="text-center">
                                        <div class="text-xs text-gray-600">{{ $order->latestTracking->status_display['name'] }}</div>
                                    </div>
                                @endif
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'packed') bg-purple-100 text-purple-800
                                    @elseif($order->status === 'shipped') bg-indigo-100 text-indigo-800
                                    @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
 --}}
                        <!-- Order Items -->
                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Order Items:</h4>
                            <div class="space-y-2">
                                @foreach($order->orderItems as $item)
                                    <div class="flex items-center justify-between py-2">
                                        <div class="flex items-center">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $item->product_name }}</p>
                                                <p class="text-sm text-gray-500">
                                                    Quantity: {{ $item->quantity }} × ${{ number_format($item->product_price, 2) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">
                                            ${{ number_format($item->subtotal, 2) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">
                                        <strong>Shipping Address:</strong><br>
                                        {{ $order->shipping_address }}
                                    </p>
                                    @if($order->estimated_delivery_date)
                                        <p class="text-sm text-gray-600 mt-2">
                                            <strong>Estimated Delivery:</strong> 
                                            {{ $order->estimated_delivery_date->format('M d, Y') }}
                                        </p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-semibold" style="color: #B9375D;">
                                        Total: ${{ number_format($order->total_amount, 2) }}
                                    </p>
                                    <div class="mt-2 space-x-2">
                                        <a href="{{ route('orders.show', $order) }}"
                                           class="inline-block px-4 py-2 text-sm text-white rounded-lg hover:opacity-90 transition duration-150 ease-in-out"
                                           style="background-color: #B9375D;">
                                            View Details
                                        </a>
                                        <a href="{{ route('orders.tracking', $order) }}"
                                           class="inline-block px-4 py-2 text-sm border-2 rounded-lg hover:bg-pink-50 transition duration-150 ease-in-out"
                                           style="border-color: #B9375D; color: #B9375D;">
                                            Track Order
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>

        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center" style="border: 1px solid #E7D3D3;">
                <div class="mb-4">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No orders yet</h3>
                <p class="text-gray-600 mb-6">You haven't placed any orders yet. Start shopping to see your orders here!</p>
                <a href="{{ route('products.index') }}" 
                   class="inline-block px-6 py-3 text-white font-semibold rounded-lg hover:opacity-90 transition duration-150 ease-in-out"
                   style="background-color: #B9375D;">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
