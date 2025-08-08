<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderTracking;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        // Get dashboard statistics
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
        ];

        // Get recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Get low stock products
        $lowStockProducts = Product::where('stock_quantity', '<=', 10)
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts'));
    }

    /**
     * Show all products.
     */
    public function products()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function createProduct()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created product.
     */
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'stock_quantity']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products')->with('success', 'Product created successfully!');
    }

    /**
     * Show the form for editing a product.
     */
    public function editProduct(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified product.
     */
    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'stock_quantity']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product.
     */
    public function deleteProduct(Product $product)
    {
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }

    /**
     * Show all orders.
     */
    public function orders()
    {
        $orders = Order::with('user', 'orderItems.product')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show order details.
     */
    public function showOrder(Order $order)
    {
        $order->load('user', 'orderItems.product');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status.
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Show order tracking management page
     */
    public function orderTracking(Order $order)
    {
        $order->load(['trackingUpdates.updatedBy', 'orderItems', 'user']);

        return view('admin.orders.tracking', compact('order'));
    }

    /**
     * Add a new tracking update
     */
    public function addTrackingUpdate(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,packed,shipped,delivered',
            'message' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:255',
        ]);

        // Create tracking update
        OrderTracking::create([
            'order_id' => $order->id,
            'status' => $request->status,
            'message' => $request->message,
            'location' => $request->location,
            'status_date' => now(),
            'updated_by' => Auth::id(),
        ]);

        // Update order status to match latest tracking
        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Tracking update added successfully!');
    }
}
