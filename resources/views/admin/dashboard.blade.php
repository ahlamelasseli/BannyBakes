@extends('layout.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.orders') }}"
                       class="px-4 py-2 text-white rounded-lg hover:opacity-90 transition duration-150 ease-in-out"
                       style="background-color: #B9375D;">
                        View Orders
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-2 hover:shadow-lg transition-all duration-200"
                 style="border-color: #B9375D; color: #B9375D;"
                 onmouseover="this.style.backgroundColor='#B9375D'; this.style.color='#EEEEEE';"
                 onmouseout="this.style.backgroundColor='white'; this.style.color='#B9375D';">
                <div class="text-center">
                    <p class="text-sm font-medium mb-2">Total Products</p>
                    <p class="text-2xl font-semibold">{{ $stats['total_products'] }}</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-2 hover:shadow-lg transition-all duration-200"
                 style="border-color: #B9375D; color: #B9375D;"
                 onmouseover="this.style.backgroundColor='#B9375D'; this.style.color='#EEEEEE';"
                 onmouseout="this.style.backgroundColor='white'; this.style.color='#B9375D';">
                <div class="text-center">
                    <p class="text-sm font-medium mb-2">Total Orders</p>
                    <p class="text-2xl font-semibold">{{ $stats['total_orders'] }}</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-2 hover:shadow-lg transition-all duration-200"
                 style="border-color: #B9375D; color: #B9375D;"
                 onmouseover="this.style.backgroundColor='#B9375D'; this.style.color='#EEEEEE';"
                 onmouseout="this.style.backgroundColor='white'; this.style.color='#B9375D';">
                <div class="text-center">
                    <p class="text-sm font-medium mb-2">Total Customers</p>
                    <p class="text-2xl font-semibold">{{ $stats['total_customers'] }}</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-2 hover:shadow-lg transition-all duration-200"
                 style="border-color: #B9375D; color: #B9375D;"
                 onmouseover="this.style.backgroundColor='#B9375D'; this.style.color='#EEEEEE';"
                 onmouseout="this.style.backgroundColor='white'; this.style.color='#B9375D';">
                <div class="text-center">
                    <p class="text-sm font-medium mb-2">Pending Orders</p>
                    <p class="text-2xl font-semibold">{{ $stats['pending_orders'] }}</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-2 hover:shadow-lg transition-all duration-200"
                 style="border-color: #B9375D; color: #B9375D;"
                 onmouseover="this.style.backgroundColor='#B9375D'; this.style.color='#EEEEEE';"
                 onmouseout="this.style.backgroundColor='white'; this.style.color='#B9375D';">
                <div class="text-center">
                    <p class="text-sm font-medium mb-2">Total Revenue</p>
                    <p class="text-2xl font-semibold">${{ number_format($stats['total_revenue'], 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <a href="{{ route('admin.products.create') }}"
               class="bg-white rounded-lg shadow p-6 border-2 hover:shadow-lg transition-all duration-200"
               style="border-color: #B9375D; color: #B9375D;"
               onmouseover="this.style.backgroundColor='#B9375D'; this.style.color='#EEEEEE';"
               onmouseout="this.style.backgroundColor='white'; this.style.color='#B9375D';">
                <div class="text-center">
                    <h3 class="text-lg font-semibold mb-2">Add New Product</h3>
                </div>
            </a>

            <a href="{{ route('admin.products') }}"
               class="bg-white rounded-lg shadow p-6 border-2 hover:shadow-lg transition-all duration-200"
               style="border-color: #B9375D; color: #B9375D;"
               onmouseover="this.style.backgroundColor='#B9375D'; this.style.color='#EEEEEE';"
               onmouseout="this.style.backgroundColor='white'; this.style.color='#B9375D';">
                <div class="text-center">
                    <h3 class="text-lg font-semibold mb-2">Manage Products</h3>
                </div>
            </a>
        </div>

        <!-- Recent Orders and Low Stock -->
        <div class="grid grid-cols-1 lg:grid-cols-1 gap-8">
            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Orders</h3>
                </div>
                <div class="p-6">
                    @if($recentOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-semibold text-gray-900">Order #{{ $order->id }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold" style="color: #B9375D;">${{ number_format($order->total_amount, 2) }}</p>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                            @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.orders') }}" class="text-sm font-medium" style="color: #B9375D;">
                                View all orders →
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500">No orders yet.</p>
                    @endif
                </div>
            </div>

        </div>

{{-- <div class="bg-white rounded-xl border-2 border-bunny-pink shadow-lg mb-8">
    <div class="bg-bunny-pink text-white rounded-t-xl py-4 px-6 flex justify-between items-center">
        <h5 class="font-script text-2xl font-bold italic">
            📞 Today's Follow-ups
        </h5>

    </div>
    <div class="p-6">
        @php
            // Calculate today's follow-ups (orders placed 2 days ago)
            $todayFollowUps = \App\Models\Order::whereDate('created_at', now()->subDays(2))->with('user')->get();
        @endphp

        @if($todayFollowUps->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($todayFollowUps->take(3) as $order)
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h6 class="font-script text-xl font-bold text-gray-800 mb-2">{{ $order->customer_name }}</h6>
                        <p class="font-script text-gray-600 mb-3">{{ $order->customer_email }}</p>
                        <p class="font-script text-gray-700 mb-4">
                            <strong>Order #{{ $order->id }}</strong><br>
                            <span class="text-green-600 font-bold">${{ number_format($order->total_amount, 2) }}</span>
                        </p>
                        <a href="mailto:{{ $order->customer_email }}" class="bg-bunny-pink text-white font-script font-semibold px-4 py-2 rounded-lg hover:bg-opacity-90 transition-colors duration-300 inline-block">
                            ✉️ Contact
                        </a>
                    </div>
                @endforeach
            </div>
            @if($todayFollowUps->count() > 3)
                <div class="text-center mt-6">
                    <p class="text-gray-600">
                        And {{ $todayFollowUps->count() - 3 }} more follow-ups for today
                    </p>
                </div>
            @endif
        @else
            <div class="text-center py-8">
                <div class="text-6xl text-bunny-pink mb-4"></div>
                <p class="font-script text-xl text-gray-600">No follow-ups scheduled for today.</p>
            </div>
        @endif
    </div>
</div> --}}


    </div>
</div>
@endsection