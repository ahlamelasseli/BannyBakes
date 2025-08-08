<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class OrderController extends Controller
{
    /**
     * Display user's order history.
     */
    public function index()
    {
        $orders = Auth::user()->orders()->with('orderItems.product')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Create Stripe Checkout Session and redirect to Stripe.
     */
    public function checkout()
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Check stock availability for all items
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock_quantity) {
                return redirect()->route('cart.index')->with('error', "Not enough stock for {$item->product->name}.");
            }
        }

        try {
            // Set Stripe API key
            Stripe::setApiKey(config('services.stripe.secret_key'));

            // Prepare line items for Stripe
            $lineItems = [];
            foreach ($cartItems as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $item->product->name,
                            'description' => $item->product->description ?? 'Delicious homemade cookie',
                        ],
                        'unit_amount' => intval($item->product->price * 100), // Convert to cents
                    ],
                    'quantity' => $item->quantity,
                ];
            }

            // Create Stripe Checkout Session
            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('orders.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cart.index'),
                'customer_email' => Auth::user()->email,
                'metadata' => [
                    'user_id' => Auth::id(),
                    'customer_name' => Auth::user()->name,
                ],
                'shipping_address_collection' => [
                    'allowed_countries' => ['US', 'CA'], // Add more countries as needed
                ],
            ]);

            // Redirect to Stripe Checkout
            return redirect($checkoutSession->url);

        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Unable to create checkout session. Please try again.');
        }
    }

    /**
     * Handle successful payment return from Stripe
     */
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('cart.index')->with('error', 'Invalid session.');
        }

        try {
            // Set Stripe API key
            Stripe::setApiKey(config('services.stripe.secret_key'));

            // Retrieve the checkout session
            $checkoutSession = Session::retrieve($sessionId);

            if ($checkoutSession->payment_status === 'paid') {
                // Check if order already exists for this payment intent
                $existingOrder = Order::where('payment_intent_id', $checkoutSession->payment_intent)->first();

                if ($existingOrder) {
                    return redirect()->route('orders.index');
                }

                // Get cart items for this user
                $cartItems = $this->getCartItems();

                if ($cartItems->isEmpty()) {
                    return redirect()->route('orders.index');
                }

                // Create order in database
                DB::transaction(function () use ($checkoutSession, $cartItems) {
                    $total = $cartItems->sum('subtotal');

                    // Create order
                    $order = Order::create([
                        'user_id' => Auth::id(),
                        'customer_name' => $checkoutSession->metadata->customer_name ?? Auth::user()->name,
                        'customer_email' => Auth::user()->email,
                        'shipping_address' => $this->formatShippingAddress($checkoutSession->shipping_details),
                        'total_amount' => $total,
                        'status' => 'pending',
                        'estimated_delivery_date' => now()->addDays(3),
                        'payment_intent_id' => $checkoutSession->payment_intent,
                    ]);

                    // Create initial tracking entry
                    OrderTracking::create([
                        'order_id' => $order->id,
                        'status' => 'pending',
                        'message' => 'Your order has been received and payment confirmed. We will start preparing your delicious cookies soon!',
                        'status_date' => now(),
                    ]);

                    // Create order items and update stock
                    foreach ($cartItems as $cartItem) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $cartItem->product_id,
                            'product_name' => $cartItem->product->name,
                            'product_price' => $cartItem->product->price,
                            'quantity' => $cartItem->quantity,
                            'subtotal' => $cartItem->subtotal,
                        ]);

                        // Update product stock
                        $cartItem->product->decrement('stock_quantity', $cartItem->quantity);
                    }

                    // Clear cart
                    $cartItems->each->delete();
                });

                return redirect()->route('orders.index');
            } else {
                return redirect()->route('cart.index')->with('error', 'Payment was not completed.');
            }

        } catch (\Exception $e) {
            Log::error('Order processing error: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Unable to process order. Please contact support.');
        }
    }

    /**
     * Format shipping address from Stripe checkout session
     */
    private function formatShippingAddress($shippingDetails)
    {
        if (!$shippingDetails || !$shippingDetails->address) {
            return 'Address not provided';
        }

        $address = $shippingDetails->address;
        $formatted = $shippingDetails->name . "\n";
        $formatted .= $address->line1;

        if ($address->line2) {
            $formatted .= "\n" . $address->line2;
        }

        $formatted .= "\n" . $address->city . ", " . $address->state . " " . $address->postal_code;
        $formatted .= "\n" . $address->country;

        return $formatted;
    }

    /**
     * Store a new order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'shipping_address' => 'required|string|max:1000',
        ]);

        $cartItems = $this->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Check stock availability for all items
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock_quantity) {
                return back()->with('error', "Not enough stock for {$item->product->name}.");
            }
        }

        DB::transaction(function () use ($request, $cartItems) {
            // Calculate total
            $total = $cartItems->sum('subtotal');

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'shipping_address' => $request->shipping_address,
                'total_amount' => $total,
                'status' => 'Ordered',
                'estimated_delivery_date' => now()->addDays(3),
            ]);

            // Create order items and update stock
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'product_price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->subtotal,
                ]);

                // Update product stock
                $cartItem->product->decrement('stock_quantity', $cartItem->quantity);
            }

            // Clear cart
            $cartItems->each->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }



    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('orderItems.product');

        return view('orders.show', compact('order'));
    }

    /**
     * Display order tracking information
     */
    public function tracking(Order $order)
    {
        // Make sure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to order.');
        }

        // Load tracking updates with admin info
        $order->load(['trackingUpdates.updatedBy']);

        return view('orders.tracking', compact('order'));
    }

    /**
     * Display admin order management.
     */
    public function adminIndex()
    {
        $orders = Order::with('user', 'orderItems')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show admin order details.
     */
    public function adminShow(Order $order)
    {
        $order->load('user', 'orderItems.product');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Ordered,Packed,Shipped,Delivered'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Update delivery date.
     */
    public function updateDeliveryDate(Request $request, Order $order)
    {
        $request->validate([
            'estimated_delivery_date' => 'required|date|after:today'
        ]);

        $order->update(['estimated_delivery_date' => $request->estimated_delivery_date]);

        return back()->with('success', 'Delivery date updated successfully!');
    }

    /**
     * Get cart items for current user.
     */
    private function getCartItems()
    {
        return Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
    }
}
