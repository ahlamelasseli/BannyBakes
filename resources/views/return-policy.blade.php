@extends('layout.app')

@section('title', 'Return Policy')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Return Policy</h1>
            <p class="text-xl text-gray-600">Your satisfaction is our priority at Bunny Bakes</p>
        </div>

        <div class="prose prose-lg max-w-none">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Our Promise to You</h2>
            <p class="text-gray-600 mb-6">
                At Bunny Bakes, we're committed to delivering the freshest, most delicious cookies to your doorstep. 
                If for any reason you're not completely satisfied with your order, we're here to make it right.
            </p>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Return Guidelines</h2>
            
            <h3 class="text-xl font-semibold text-gray-800 mb-3">Freshness Guarantee</h3>
            <ul class="list-disc list-inside text-gray-600 mb-6 space-y-2">
                <li>All cookies are baked fresh and shipped within 24 hours</li>
                <li>If your cookies arrive stale or damaged, we'll replace them free of charge</li>
                <li>Contact us within 48 hours of delivery for freshness issues</li>
            </ul>

            <h3 class="text-xl font-semibold text-gray-800 mb-3">Quality Issues</h3>
            <ul class="list-disc list-inside text-gray-600 mb-6 space-y-2">
                <li>Broken or damaged cookies due to shipping</li>
                <li>Incorrect items in your order</li>
                <li>Missing items from your order</li>
                <li>Cookies that don't meet our quality standards</li>
            </ul>

            <h3 class="text-xl font-semibold text-gray-800 mb-3">Return Process</h3>
            <ol class="list-decimal list-inside text-gray-600 mb-6 space-y-2">
                <li>Contact our customer service team within 48 hours of delivery</li>
                <li>Provide your order number and photos of the issue (if applicable)</li>
                <li>We'll provide a prepaid return label if needed</li>
                <li>Refund or replacement will be processed within 3-5 business days</li>
            </ol>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">What We Cannot Accept</h2>
            <ul class="list-disc list-inside text-gray-600 mb-6 space-y-2">
                <li>Returns after 48 hours from delivery</li>
                <li>Cookies that have been partially consumed (unless quality issue)</li>
                <li>Custom or personalized orders (unless defective)</li>
                <li>Returns due to personal taste preferences</li>
            </ul>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Refund Policy</h2>
            <p class="text-gray-600 mb-4">
                Refunds will be processed to the original payment method within 3-5 business days after we receive 
                and process your return. You'll receive an email confirmation once the refund has been initiated.
            </p>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Contact Us</h2>
            <div class="bg-gray-50 p-6 rounded-lg">
                <p class="text-gray-600 mb-2">
                    <strong>Email:</strong> support@bunnybakes.com
                </p>
                <p class="text-gray-600 mb-2">
                    <strong>Phone:</strong> 1-800-BUNNY-BAKES
                </p>
                <p class="text-gray-600">
                    <strong>Hours:</strong> Monday - Friday, 9 AM - 6 PM EST
                </p>
            </div>

            <div class="mt-8 p-6 rounded-lg" style="background-color: #fdf2f8;">
                <h3 class="text-xl font-semibold mb-2" style="color: #B9375D;">The Bunny Bakes Promise</h3>
                <p class="text-gray-700">
                    We stand behind every cookie we bake. If you're not hopping with joy after trying our cookies, 
                    we'll make it right. That's the Bunny Bakes guarantee!
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
