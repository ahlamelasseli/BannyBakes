@extends('layout.app')

@section('title', 'Manage Order Tracking - Admin')

@section('content')
<div class="min-h-screen py-8" style="background-color: #EEEEEE;">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold" style="color: #B9375D;">Manage Order Tracking</h1>
                    <p class="text-gray-600 mt-2">Order #{{ $order->id }} • Customer: {{ $order->customer_name }}</p>
                </div>
                <a href="{{ route('admin.orders') }}" 
                   class="px-4 py-2 text-white rounded-lg hover:opacity-90 transition duration-150 ease-in-out"
                   style="background-color: #B9375D;">
                    ← Back to Orders
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Add New Tracking Update -->
            <div class="bg-white rounded-lg shadow-lg p-6 border-2" style="border-color: #E7D3D3;">
                <h2 class="text-2xl font-bold mb-6" style="color: #B9375D;">Add Tracking Update</h2>
                
                <form action="{{ route('admin.orders.tracking.add', $order) }}" method="POST">
                    @csrf
                    
                    <div class="space-y-4">
                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Order Status</label>
                            <select id="status" name="status" required 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                                <option value="">Select Status</option>
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}> Order Received</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}> Preparing Order</option>
                                <option value="packed" {{ $order->status === 'packed' ? 'selected' : '' }}> Packed & Ready</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}> On the Way</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}> Delivered</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Update Message</label>
                            <textarea id="message" name="message" rows="3" 
                                      placeholder="Enter a message for the customer about this update..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500"></textarea>
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Current Location (Optional)</label>
                            <input type="text" id="location" name="location" 
                                   placeholder="e.g., Distribution Center, Out for Delivery"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" 
                                class="w-full py-3 px-4 text-white font-semibold rounded-lg hover:opacity-90 transition duration-150 ease-in-out"
                                style="background-color: #B9375D;">
                            Add Tracking Update
                        </button>
                    </div>
                </form>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-lg p-6 border-2" style="border-color: #E7D3D3;">
                    <h3 class="text-xl font-bold mb-4" style="color: #B9375D;">Order Summary</h3>
                    <div class="space-y-2">
                        <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                        <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
                        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                        <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y g:i A') }}</p>
                        <p><strong>Total:</strong> <span style="color: #B9375D; font-weight: bold;">${{ number_format($order->total_amount, 2) }}</span></p>
                        <p><strong>Current Status:</strong> 
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'packed') bg-purple-100 text-purple-800
                                @elseif($order->status === 'shipped') bg-indigo-100 text-indigo-800
                                @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6 border-2" style="border-color: #E7D3D3;">
                    <h3 class="text-xl font-bold mb-4" style="color: #B9375D;"> Shipping Address</h3>
                    <div class="bg-gray-50 p-4 rounded-lg border">
                        <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ $order->shipping_address }}</pre>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 mt-8 border-2" style="border-color: #E7D3D3;">
            <h2 class="text-2xl font-bold mb-6" style="color: #B9375D;">Tracking History</h2>
            
            @if($order->trackingUpdates->count() > 0)
                <div class="space-y-6">
                    @foreach($order->trackingUpdates as $tracking)
                        <div class="flex items-start space-x-4 p-4 rounded-lg border-2" style="border-color: #E7D3D3; background-color: #EEEEEE;">
                            <div class="flex-shrink-0">
                                <div class="w-4 h-4 rounded-full
                                    @if($loop->first) bg-blue-500 @else bg-gray-400 @endif">
                                </div>
                            </div>
                            
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
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <h3 class="text-lg font-semibold mb-2" style="color: #B9375D;">No Tracking Updates Yet</h3>
                    <p class="text-gray-600">Add the first tracking update to start the customer's tracking journey!</p>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 mt-8 border-2" style="border-color: #E7D3D3;">
            <h2 class="text-2xl font-bold mb-6" style="color: #B9375D;"> Order Items</h2>
            <div class="space-y-4">
                @foreach($order->orderItems as $item)
                    <div class="flex items-center justify-between py-4 border-b border-gray-200 last:border-b-0">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $item->product_name }}</h3>
                            <p class="text-sm text-gray-500">
                                ${{ number_format($item->product_price, 2) }} × {{ $item->quantity }}
                            </p>
                        </div>
                        <div class="text-lg font-semibold text-gray-900">
                            ${{ number_format($item->subtotal, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="flex items-center justify-between text-xl font-semibold">
                    <span>Total:</span>
                    <span style="color: #B9375D;">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
